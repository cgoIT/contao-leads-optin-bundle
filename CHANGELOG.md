# Changelog

## [3.0.4](https://github.com/cgoIT/contao-leads-optin-bundle/compare/v3.0.3...v3.0.4) (2024-03-28)


### Bug Fixes

* simplification with file handling ([d04781c](https://github.com/cgoIT/contao-leads-optin-bundle/commit/d04781c4bd16aaf0349ac0f6989baa8755504052))

## [3.0.3](https://github.com/cgoIT/contao-leads-optin-bundle/compare/v3.0.2...v3.0.3) (2024-03-22)


### Miscellaneous Chores

* fix ecs errors ([0accf97](https://github.com/cgoIT/contao-leads-optin-bundle/commit/0accf970e952aba49750807a19cadf725c068a03))

## [3.0.2](https://github.com/cgoIT/contao-leads-optin-bundle/compare/v3.0.1...v3.0.2) (2024-03-22)


### Bug Fixes

* remove obsolete services from di.yml ([7b0768d](https://github.com/cgoIT/contao-leads-optin-bundle/commit/7b0768d3b5dd6d8802ba81337f31a058ea6efff0))

## [3.0.1](https://github.com/cgoIT/contao-leads-optin-bundle/compare/v3.0.0...v3.0.1) (2024-03-22)


### Bug Fixes

* correct composer.json ([0ea965c](https://github.com/cgoIT/contao-leads-optin-bundle/commit/0ea965c6a1f92e372a2d736ca7ad1b0292f071c3))

## 3.0.0 (2024-03-22)


### ⚠ BREAKING CHANGES

* change namespace to Cgoit\LeadsOptinBundle

### Features

* add cron job to delete leads with expired tokens ([2f1a78b](https://github.com/cgoIT/contao-leads-optin-bundle/commit/2f1a78b682a269542350e80eae4c9d1ae1965911))
* add exporters for optin leads data ([f9b27fb](https://github.com/cgoIT/contao-leads-optin-bundle/commit/f9b27fbb0e48a8a3ee3d33711ee9e9e341602c8e))
* adjustments for notification center 2 ([de5db4a](https://github.com/cgoIT/contao-leads-optin-bundle/commit/de5db4ab504fc85f3cb71eb59d3181e0be8dcec2))
* change namespace to Cgoit\LeadsOptinBundle ([47d7fff](https://github.com/cgoIT/contao-leads-optin-bundle/commit/47d7fff754f21eeeb8b7aa66137a1e6b598166f5))
* compatibility with leads 3.x ([489d941](https://github.com/cgoIT/contao-leads-optin-bundle/commit/489d941f6345127cc35b2b747cd148a68fd2236c))
* migrate to notification center 2.x ([ccb7623](https://github.com/cgoIT/contao-leads-optin-bundle/commit/ccb7623ebacc1840f8a2ebb5704317a3f02b4a7d))
* upgrade dependencies haste and leads ([d05c6df](https://github.com/cgoIT/contao-leads-optin-bundle/commit/d05c6df224c4e0aaf907cfec92820c3cc760619a))


### Bug Fixes

* 4 ([9d20c4d](https://github.com/cgoIT/contao-leads-optin-bundle/commit/9d20c4d2065eec50eb4c8084ecaafc1276a084f5))
* add index on tl_lead.post_data for better performance ([797e005](https://github.com/cgoIT/contao-leads-optin-bundle/commit/797e005345d25326c3b28c3538f33ff9be2f26cf))
* add optin_tstamp and optin_ip to tokens on success notification ([630507f](https://github.com/cgoIT/contao-leads-optin-bundle/commit/630507fe418893b6f37a46ca07bc499a86f72868))
* change default separator for arrays ([c1571a5](https://github.com/cgoIT/contao-leads-optin-bundle/commit/c1571a5f3b84d54dcfeed61645ea3d6d1a602524))
* don't use TL_MODE ([3c89632](https://github.com/cgoIT/contao-leads-optin-bundle/commit/3c89632cb9dd8ee230d5b767b9d05d25aecc4a12))
* fix error with wrong data type in TokenTrait ([ccfcff8](https://github.com/cgoIT/contao-leads-optin-bundle/commit/ccfcff8078014b12efecb890759f5f21357d8f6a))
* only show optin icon if optin is enabled for form ([69a7473](https://github.com/cgoIT/contao-leads-optin-bundle/commit/69a7473cc536b06af8c2d086eb5a44bee677597e))
* set tokens ins hook correctly ([19169b3](https://github.com/cgoIT/contao-leads-optin-bundle/commit/19169b3874763edbf67f236f52370ffc005f8fa6))


### Miscellaneous Chores

* code cleanup ([0078102](https://github.com/cgoIT/contao-leads-optin-bundle/commit/00781022d548c3be6b78da772ac262d11e1532ab))
* rename repo to cgoit/contao-leads-optin-bundle ([411ed63](https://github.com/cgoIT/contao-leads-optin-bundle/commit/411ed63d79717341ac6b403d344bc3dbac3b50b0))
* update README.md and change dependency injection ([169dc34](https://github.com/cgoIT/contao-leads-optin-bundle/commit/169dc34288753b74581d43b17596b7d7d10fcfd3))
