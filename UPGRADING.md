Upgrading notes
===============

Version 3.0
-----------

* [BC break] Rename `piwik_code` to `matomo_code`
* [BC break] Rename `piwik` to `matomo`
* [BC break] Change bundle namespace from `\WebFactory\Bundle\PiwikBundle` to `\Fmaruejol\Bundle\MatomoBundle`
* [BC break] Rename config root name from `webfactory_piwki` to `fmaruejol_matomo`
* [BC break] Remove config key `tracker_path`
* [BC break] Change Twig Extension public service id from `webfactory_piwik.twig_extension` to `fmaruejol_matomo.twig_extension`

Version 2.2
-----------

* Make the Twig Extension available as a public service `webfactory_piwik.twig_extension` (#5)

Version 2.1
-----------

* Added the new Twig function piwik() to perform additional (arbitrary) API calls on the JavaScript tracker. 

Version 2.0
-----------

* [BC break] The configuration setting `use_cacheable_tracking_script` has been replaced by `tracker_path`. If `use_cacheable_tracking_script` was set to `true` (the default), use `js/`. Otherwise, use `piwik.js`. See issue #1.
