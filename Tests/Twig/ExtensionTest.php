<?php

namespace Twig;

use PHPUnit\Framework\TestCase;
use Fmaruejol\Bundle\MatomoBundle\Twig\Extension;

class ExtensionTest extends TestCase
{
    public function testMatomoCodeReturnsNoScriptWhenDisabled()
    {
        $extension = new Extension(true, 1, '', false);
        $this->assertNotContains('script', $extension->matomoCode());
    }

    public function testMatomoCodeReturnsScript()
    {
        $extension = new Extension(false, 1, '', false);
        $this->assertContains('script', $extension->matomoCode());
    }

    public function testMatomoCodeContainsSiteId()
    {
        $siteId = 1234;
        $extension = new Extension(false, $siteId, '', false);
        $this->assertContains((string) $siteId, $extension->matomoCode());
    }

    public function testMatomoCodeContainsHostName()
    {
        $hostname = 'myHost.de';
        $extension = new Extension(false, 1, $hostname);
        $this->assertContains($hostname, $extension->matomoCode());
    }

    public function testAdditionalApiCallsCanBeAdded()
    {
        $extension = new Extension(false, 1, 'my.host');
        $extension->matomoPush('foo', 'bar', 'baz');
        $this->assertContains('["foo","bar","baz"]', $extension->matomoCode());
    }

    public function testTrackPageViewEnabledByDefault()
    {
        $extension = new Extension(false, 1, 'my.host');
        $this->assertContains('"trackPageView"', $extension->matomoCode());
    }

    public function testTrackSiteSearchDisablesPageTracking()
    {
        $extension = new Extension(false, 1, 'my.host');
        $extension->matomoPush('trackSiteSearch', 'Banana', 'Organic Food', 42);

        $code = $extension->matomoCode();
        $this->assertContains('"trackSiteSearch"', $code);
        $this->assertNotContains('"trackPageView"', $code);
    }

    public function testIsTwigExtension()
    {
        $extension = new Extension(false, 1, '');
        $this->assertInstanceOf('\Twig\Extension\ExtensionInterface', $extension);
    }
}
