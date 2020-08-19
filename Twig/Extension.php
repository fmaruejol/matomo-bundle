<?php

namespace Fmaruejol\Bundle\MatomoBundle\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class Extension extends AbstractExtension
{
    /**
     * @var bool
     */
    private $disabled;

    /**
     * @var int
     */
    private $siteId;

    /**
     * @var string
     */
    private $matomoHost;

    /**
     * @var array
     */
    private $paqs = [];

    public function __construct(bool $disabled, string $siteId, string $matomoHost)
    {
        $this->disabled = $disabled;
        $this->siteId = $siteId;
        $this->matomoHost = rtrim($matomoHost, '/');
    }

    public function getFunctions()
    {
        return [
            new TwigFunction('matomo_code', [$this, 'matomoCode'], ['is_safe' => ['html']]),
            new TwigFunction('matomo', [$this, 'matomoPush']),
        ];
    }

    public function matomoPush(...$paqs)
    {
        $this->paqs[] = $paqs;
    }

    public function matomoCode()
    {
        if ($this->disabled) {
            return '<!-- Piwik is disabled due to fmaruejol_matomo.disabled=true in your configuration -->';
        }

        $this->addDefaultApiCalls();

        $paq = json_encode($this->paqs);

        return <<<EOT
<!-- Matomo -->
<script type="text/javascript">//<![CDATA[
var _paq = (window._paq || []).concat({$paq});
_paq.push(["setDoNotTrack", true]);
(function() {
    var u=(("https:" === document.location.protocol) ? "https" : "http") + "://{$this->matomoHost}/";
    _paq.push(["setTrackerUrl", u+"matomo.php"]);
    _paq.push(["setSiteId", "{$this->siteId}"]);
    var d=document, g=d.createElement("script"), s=d.getElementsByTagName("script")[0]; g.type="text/javascript";
    g.defer=true; g.async=true; g.src=u+"matomo.js"; s.parentNode.insertBefore(g,s);
})();
//]]></script>
<noscript><p><img src="//{$this->matomoHost}/matomo.php?idsite={$this->siteId}&amp;rec=1" style="border:0;" alt="" /></p></noscript>
<!-- End Matomo Code -->
EOT;
    }

    private function addDefaultApiCalls()
    {
        $this->paqs[] = ['enableLinkTracking'];

        foreach ($this->paqs as $paq) {
            if ('trackSiteSearch' === $paq[0]) {
                /*
                 * It is recommended *not* to "trackPageView" for "trackSiteSearch" pages.
                 * See http://developer.piwik.org/api-reference/tracking-javascript#tracking-internal-search-keywords-categories-and-no-result-search-keywords
                 * or http://piwik.org/docs/site-search/#track-site-search-using-the-javascript-tracksitesearch-function.
                 */
                return; // Do not add 'trackPageView'
            }
        }

        $this->paqs[] = ['trackPageView'];
    }
}
