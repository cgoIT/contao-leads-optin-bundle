<?php

declare(strict_types=1);

/*
 * This file is part of cgoit\contao-leads-optin-bundle for Contao Open Source CMS.
 *
 * @copyright  Copyright (c) 2025, cgoIT
 * @author     cgoIT <https://cgo-it.de>
 * @author     Christopher Bölter
 * @license    LGPL-3.0-or-later
 */

namespace Cgoit\LeadsOptinBundle\Controller\Module;

use BugBuster\BotDetection\ModuleBotDetection;
use Cgoit\LeadsOptinBundle\Trait\TokenTrait;
use Cgoit\LeadsOptinBundle\Util\Constants;
use Codefog\HasteBundle\Form\Form;
use Codefog\HasteBundle\StringParser;
use Contao\Config;
use Contao\Controller;
use Contao\CoreBundle\Controller\FrontendModule\AbstractFrontendModuleController;
use Contao\CoreBundle\DependencyInjection\Attribute\AsFrontendModule;
use Contao\Date;
use Contao\Environment;
use Contao\FormModel;
use Contao\Input;
use Contao\ModuleModel;
use Contao\PageModel;
use Contao\StringUtil;
use Contao\System;
use Contao\Template;
use Doctrine\DBAL\Connection;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Terminal42\NotificationCenterBundle\NotificationCenter;

/**
 * Provides the frontend module to handle the optin process.
 *
 * @property string|null $leadOptInErrorMessage
 * @property string|null $leadOptInSuccessMessage
 * @property bool        $leadOptIndNeedsUserInteraction
 * @property string|null $leadOptInUserInteractionMessage
 * @property string      $leadOptInUserInteractionSubmit
 * @property int         $leadOptInSuccessNotification
 * @property string      $leadOptInSuccessType
 * @property int         $leadOptInSuccessJumpTo
 */
#[AsFrontendModule(type: LeadsOptInModule::TYPE, category: 'leads', template: 'mod_leads_optin')]
class LeadsOptInModule extends AbstractFrontendModuleController
{
    use TokenTrait;

    public const TYPE = 'leadsoptin';

    private readonly ModuleBotDetection $botDetection;

    public function __construct(
        private readonly NotificationCenter $notificationCenter,
        private readonly Connection $db,
        private readonly StringParser $stringParser,
    ) {
        $this->botDetection = new ModuleBotDetection();
    }

    protected function getResponse(Template $template, ModuleModel $model, Request $request): Response
    {
        $token = Input::get('token');
        $template->errorMessage = $model->leadOptInErrorMessage;

        if (!$token || $this->botDetection->checkBotAllTests()) {
            $template->isError = true;

            return $template->getResponse();
        }

        $arrLead = $this->db->fetchAssociative(
            'SELECT * FROM tl_lead Where optin_token = ? AND optin_token <> ? AND optin_tstamp = ? AND optin_notification_tstamp >= ?',
            [$token, '', '0', time() - Constants::$TOKEN_VALID_PERIOD],
        );

        if (!$arrLead || null === ($form = FormModel::findById($arrLead['form_id']))) {
            $template->isError = true;

            return $template->getResponse();
        }

        // check if we need to generate a form to confirm a real user uses the optIn link
        if ($model->leadOptIndNeedsUserInteraction) {
            $tokenForm = new Form('optin-check', 'POST', static fn ($objHaste) => Input::post('FORM_SUBMIT') === $objHaste->getFormId());

            $tokenForm->addFormField('mandatory', [
                'inputType' => 'explanation',
                'eval' => ['text' => $model->leadOptInUserInteractionMessage],
            ]);

            $tokenForm->addFormField('submit', [
                'label' => $model->leadOptInUserInteractionSubmit,
                'inputType' => 'submit',
            ]);

            // Checks whether a form has been submitted
            if (!$tokenForm->validate()) {
                // show token form if form has not been submitted
                $template->tokenForm = $tokenForm->generate();
                $template->showTokenForm = true;

                return $template->getResponse();
            }
        }

        $set = [
            'optin_tstamp' => time(),
            'optin_token' => '',
        ];

        if ($form->leadOptInStoreIp) {
            $set['optin_ip'] = Environment::get('ip');
        }

        $updated = $this->db->update('tl_lead', $set, ['id' => $arrLead['id'], 'optin_token' => $token, 'optin_tstamp' => '0']);

        if (0 === $updated) {
            $template->isError = true;

            return $template->getResponse();
        }

        $formConfig = $form->row();
        $tokens = $this->generateTokens(
            $this->db,
            $this->stringParser,
            StringUtil::deserialize($arrLead['post_data'], true),
            $formConfig,
            StringUtil::deserialize($arrLead['optin_files'], true),
            StringUtil::deserialize($arrLead['optin_labels'], true),
        );

        $tokens['lead_created'] = Date::parse($GLOBALS['TL_CONFIG']['datimFormat'], $arrLead['created']);
        $tokens['optin_tstamp'] = Date::parse(Config::get('datimFormat'), $set['optin_tstamp']);

        if ($form->leadOptInStoreIp) {
            $tokens['optin_ip'] = $set['optin_ip'];
        }

        // HOOK: add custom logic
        if (isset($GLOBALS['TL_HOOKS']['onLeadOptinSuccess']) && \is_array($GLOBALS['TL_HOOKS']['onLeadOptinSuccess'])) {
            foreach ($GLOBALS['TL_HOOKS']['onLeadOptinSuccess'] as $callback) {
                if (\is_array($callback)) {
                    System::importStatic($callback[0])->{$callback[1]}($arrLead, $tokens, $model);
                } elseif (\is_callable($callback)) {
                    $callback($arrLead, $tokens, $model);
                }
            }
        }

        if (!empty($model->leadOptInSuccessNotification)) {
            $bulkyItemsStamp = $this->processBulkyItems($this->notificationCenter, $tokens, StringUtil::deserialize($arrLead['optin_files'], true));
            $stamps = $this->notificationCenter->createBasicStampsForNotification((int) $model->leadOptInSuccessNotification, $tokens, $GLOBALS['TL_LANGUAGE']);

            if (null !== $bulkyItemsStamp) {
                $stamps = $stamps->with($bulkyItemsStamp);
            }

            $this->notificationCenter->sendNotificationWithStamps((int) $model->leadOptInSuccessNotification, $stamps);
        }

        if (
            'redirect' === $model->leadOptInSuccessType
            && 0 !== $model->leadOptInSuccessJumpTo
            && ($page = PageModel::findWithDetails($model->leadOptInSuccessJumpTo)) !== null
        ) {
            Controller::redirect($page->getFrontendUrl());
        }

        $template->successMessage = $this->stringParser->recursiveReplaceTokensAndTags($model->leadOptInSuccessMessage, $tokens);

        return $template->getResponse();
    }
}
