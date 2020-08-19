FmaruejolMatomoBundle
============

This repository is a fork from [WebfactoryPiwikBundle](https://github.com/webfactory/piwik-bundle).

This fork was created to release versions compatible with the future versions of Symfony and rename to a more accurate name since Piwik rename to Matomo.

A Symfony Bundle that helps you to use the Matomo (formerly known as Piwik) Open Analytics Platform with your project.

It contains a Twig function that can insert the tracking code into your website. Plus, you can turn it off with a simple configuration switch so you don't track your dev environment.

Installation
------------

As a fork this project has no planning to be maintained. So use [VCS repository](https://getcomposer.org/doc/05-repositories.md#vcs) to install it.

```json
{
    "repositories": [
        {
            "type": "vcs",
            "url": "https://github.com/fmaruejol/matomo-bundle"
        }
    ],
    "require": {
        "fmaruejol/matomo-bundle": "~3.0"
    }
}
```

If you do not use `symfony/flex` add the bundle in `config/bundles.php`:

```php
<?php
// config/bundles.php

return [
    // ...
    Fmaruejol\Bundle\MatomoBundle\FmaruejolMatomoBundle::class => ['all' => true],
];
```

Configuration
-------------
You should configure the bundle, create `fmaruejol_maotomo.yaml` file in `config/packages`. Full Example:

```yaml
fmaruejol_matomo:
    # Required, no default. Must be set to the site id found in the Matomo control panel
    site_id: 1
    # Required, has default. Usually, you only want to include the tracking code in a production environment
    disabled: '%kernel.debug%'
    # Required. no default. Hostname and path to the Matomo host.
    matomo_host: my.matomo.hostname
```

Usage
-----
Somewhere in your views, right before the closing `</body>` tag, insert 

	{{ matomo_code() }}

This will add the appropriate Matomo tracking code as [described in the API reference](https://developer.matomo.org/api-reference/tracking-javascript).

Add calls to the JavaScript tracker API
---------------------------------------

The [JavaScript tracking API](https://developer.matomo.org/api-reference/tracking-javascript) provides a lot of methods
for setting the page name, tracking search results, using custom variables and much more.

The generic `matomo()` function allows you to control the `_paq` variable and add additional API calls to it. For example,
in your Twig template, you can write

```twig
    <!-- Somewhere in your HTML, not necessarily at the end -->
    {{ matomo("setDocumentTitle", document.title) }}
    {{ matomo("trackGoal", 1) }}

    <!-- Then, at the end: -->
    {{ matomo_code() }}
    </body>
```

Note that when you call `trackSiteSearch`, this will automatically disable the `trackPageView` call made by default.
This is the [recommended](http://developer.matomo.org/api-reference/tracking-javascript#tracking-internal-search-keywords-categories-and-no-result-search-keywords)
behaviour.

Credits, Copyright and License
------------------------------

This code was written by webfactory GmbH, Bonn, Germany. We're a software development
agency with a focus on PHP (mostly [Symfony](http://github.com/symfony/symfony)). If you're a
developer looking for new challenges, we'd like to hear from you!

- <https://www.webfactory.de>
- <https://twitter.com/webfactory>

Copyright 2012 – 2020 webfactory GmbH, Bonn. Code released under [the MIT license](LICENSE).
