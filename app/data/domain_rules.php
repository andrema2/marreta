<?php

/**
 * Specific rule configurations for individual domains
 * 
 * Domain rule structure / Estrutura das regras por domínio:
 * - userAgent: Define custom User-Agent for the domain
 * - headers: Custom HTTP headers for requests
 * - idElementRemove: Array of HTML IDs to be removed
 * - classElementRemove: Array of HTML classes to be removed
 * - scriptTagRemove: Array of scripts to be removed (partial match)
 * - cookies: Associative array of cookies to be set (null removes cookie)
 * - classAttrRemove: Array of classes to be removed from elements
 * - customCode: String containing custom JavaScript code
 * - customStyle: String containing custom CSS code
 * - proxy: Enable proxy in Guzzle or Selenium requests
 * - excludeGlobalRules: Associative array of global rules to exclude for this domain
 *   Example:
 *   'excludeGlobalRules' => [
 *       'scriptTagRemove' => ['gtm.js', 'ga.js'],
 *       'classElementRemove' => ['subscription']
 *   ]
 * - fetchStrategies: String indicating which fetch strategy to use. Available values:
 *   - fetchContent: Use standard fetch with domain rules
 *   - fetchFromWaybackMachine: Try to fetch from Internet Archive
 *   - fetchFromSelenium: Use Selenium for extraction
 * - socialReferrers: Add random social media headers
 * - fromGoogleBot: Adds simulation of request coming from Google Bot
 * - removeElementsByTag: Remove specific elements via DOM
 * - removeCustomAttr: Remove custom attributes from elements
 * - cookiePrefixRemove: Remove cookies by name prefix before fetch (e.g. "__utp", "_pc_")
 * - urlMods: Modify the URL before fetching content.
 *     Example:
 *     'urlMods' => [
 *         'query' => [
 *             [
 *                 'key' => 'amp',
 *                 'value' => '1'
 *             ]
 *         ]
 *     ]
 */
return [
    'nsctotal.com.br' => [
        'userAgent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36'
    ],
    'elcorreo.com' => [
        'idElementRemove' => ['didomi-popup', 'engagement-top'],
        'classElementRemove' => ['content-exclusive-bg'],
        'classAttrRemove' => ['didomi-popup-open', 'paywall'],
        'fromGoogleBot' => true,
        'removeElementsByTag' => ['style'],
        'removeCustomAttr' => ['hidden', 'data-*']
    ],
    'wired.com' => [
        'scriptTagRemove' => ['.js'],
    ],
    'newyorker.com' => [
        'scriptTagRemove' => ['.js'],
    ],
    'globo.com' => [
        'idElementRemove' => ['cookie-banner-lgpd', 'paywall-cpt', 'mc-read-more-wrapper', 'paywall-cookie-content', 'paywall-cpt', 'piano-offer', 'piano-inline', 'piano-modal', 'paywall-container', 'paywall-overlay', 'paywall-wrapper', 'paywall-notification', 'piano-container'],
        'classElementRemove' => ['banner-lgpd', 'article-related-link__title', 'article-related-link__picture', 'paywall-denied', 'banner-subscription', 'piano-offer', 'piano-inline', 'piano-modal', 'paywall-container', 'paywall-overlay', 'paywall-wrapper', 'paywall-notification', 'piano-content', 'piano-iframe', 'piano-adblock', 'piano-blocked', 'piano-subscription', 'piano-premium', 'piano-paywall'],
        'containsElementRemove' => ['paywall', 'piano', 'tinypass', 'subscription', 'metered', 'premium'],
        'scriptTagRemove' => ['tiny.js', 'signup.js', 'paywall.js', 'piano.js', 'tinypass.js', 'tp.min.js', 'piano-'],
        'cookies' => [
            'piano_d' => null,
            'piano_if' => null,
            'piano_user_id' => null,
            'piano_id' => null,
            'piano_privacy' => null,
            'piano_consent' => null
        ],
        'classAttrRemove' => ['wall', 'protected-content', 'cropped-block', 'piano-', 'paywall-'],
        'customStyle' => '.piano-container, .piano-offer, .piano-modal, .piano-inline, .paywall-container, .paywall-overlay, .paywall-wrapper { display: none !important; }',
        'customCode' => 'setTimeout(() => { document.querySelectorAll("[class*=\\"piano\\"], [class*=\\"paywall\\"], [id*=\\"piano\\"], [id*=\\"paywall\\"]").forEach(el => el.remove()); }, 1000);'
    ],
    'valor.globo.com' => [
        'idElementRemove' => ['paywall-desktop'],
        'classElementRemove' => ['wall', 'protected-content', 'paywall', 'hide-all-content', 'mc-column', 'fade-top'],
        'containsElementRemove' => ['paywall', 'piano', 'tinypass'],
        'scriptTagRemove' => [
            'static.infoglobo.com.br/paywall/js/tiny.js',
            'static.infoglobo.com.br/paywall/js/1.tiny.js',
            'static.infoglobo.com.br/paywall/js/21.tiny.js',
            'experience.tinypass.com/xbuilder/experience/load?aid=VnaP3rYVKc'
        ],
        'cookiePrefixRemove' => ['__utp', '_pc_']
    ],
    'gauchazh.clicrbs.com.br' => [
        'idElementRemove' => ['paywallTemplate'],
        'classAttrRemove' => ['m-paid-content', 'paid-content-apply'],
        'scriptTagRemove' => ['vendors-9','vendors-10','vendors-11'],
        'excludeGlobalRules' => [
            'classElementRemove' => ['paid-content']
        ],
        'proxy' => true,
    ],
    'reuters.com' => [
        'classElementRemove' => ['leaderboard__container'],
        'fetchStrategies' => 'fetchFromSelenium',
    ],
    'cnn.com' => [
        'fetchStrategies' => 'fetchFromSelenium',
    ],
    'lepoint.fr' => [
        'classElementRemove' => ['paywall'],
    ],
    'gamestar.de' => [
        'classElementRemove' => ['plus-teaser'],
        'classAttrRemove' => ['plus-'],
        'idElementRemove' => ['commentReload']
    ],
    'heise.de' => [
        'classAttrRemove' => ['curtain__purchase-container'],
        'removeElementsByTag' => ['a-gift']
    ],
    'fortune.com' => [
        'classElementRemove' => ['latest-popular-module', 'own', 'drawer-menu'],
        'fetchStrategies' => 'fetchFromSelenium',
        'browser' => 'chrome',
        'scriptTagRemove' => ['queryly.com'],
    ],
    'diplomatique.org.br' => [
        'idElementRemove' => ['cboxOverlay'],
        'fetchStrategies' => 'fetchFromSelenium',
    ],
    'oantagonista.com.br' => [
        'fetchStrategies' => 'fetchFromSelenium',
    ],
    'jornaldebrasilia.com.br' => [
        'fetchStrategies' => 'fetchFromSelenium',
    ],
    'npr.org' => [
        'classElementRemove' => ['onetrust-pc-dark-filter'],
        'fetchStrategies' => 'fetchFromSelenium',
    ],
    'opopular.com.br' => [
        'fetchStrategies' => 'fetchFromSelenium',
    ],
    'businessinsider.com' => [
        'fetchStrategies' => 'fetchFromSelenium',
    ],
    'leparisien.fr' => [
        'idElementRemove' => ['didomi-popup'],
        'classAttrRemove' => ['paywall-article-section'],
        'fetchStrategies' => 'fetchFromSelenium',
    ],
    'foreignaffairs.com' => [
        'customCode' => 'document.addEventListener(\'DOMContentLoaded\', function() {
            const dropcapDiv = document.querySelector(\'.article-dropcap\');
            if (dropcapDiv) {
                dropcapDiv.style.height = \'auto\';
            }
        });'
    ],
    'latercera.com' => [
        'classElementRemove' => ['pw-frontier'],
        'customStyle' => '.pw-frontier {
            display: none !important;
        }
        .container-all {
            position: inherit !important;
            top: inherit;
        }
        .main-header .top-menu, .main-header .alert-news, .main-header .alert-news.sticky {
            position:inherit !important;
        }'
    ],
    'folha.uol.com.br' => [
        'idElementRemove' => ['paywall-flutuante', 'paywall', 'paywall-signup'],
        'classElementRemove' => ['banner-assinatura', 'paywall-container'],
        'scriptTagRemove' => ['paywall.js', 'content-gate.js'],
        'cookies' => [
            'paywall_visit' => null,
            'folha_id' => null,
            'paywall_access' => 'true'
        ]
    ],
    'ftm.nl' => [
        'fetchStrategies' => 'fetchFromSelenium',
        'removeCustomAttr' => ['dialog', 'iframe'],
        'classElementRemove' => ['modal'],
        'scriptTagRemove' => ['footer.min', 'diffuser.js', 'insight.ftm.nl'],
        'classAttrRemove' => ['hasBlockingOverlay', 'localstorage']
    ],
    'denikn.cz' => [
        'idElementRemove' => ['e_lock__hard']
    ],
    'dtest.cz' => [
        'fetchStrategies' => 'fetchFromSelenium',
        'classAttrRemove' => ['is-hidden-compare'],
        'classElementRemove' => ['cc-window']
    ],
    'uol.com.br' => [
        'scriptTagRemove' => ['me.jsuol.com.br', 'c.jsuol.com.br'],
        'classElementRemove' => ['header-top-wrapper'],
    ],
    'stcatharinesstandard.ca' => [
        'fetchStrategies' => 'fetchFromSelenium',
    ],
    'cartacapital.com.br' => [
        'fetchStrategies' => 'fetchFromSelenium',
    ],
    'nzherald.co.nz' => [
        'fetchStrategies' => 'fetchFromSelenium',
    ],
    'onetz.de' => [
        'idElementRemove' => ['checkout-container'],
        'classElementRemove' => ['tp-backdrop','dm-nobg'],
        'classAttrRemove' => ['field-dnt-body-pp'],
        'scriptTagRemove' => ['.js'],
    ],
    'opovo.com.br' => [
        'classElementRemove' => ['screen-loading', 'overlay-advise']
    ],
    'crusoe.com.br' => [
        'cookies' => [
            'crs_subscriber' => '1'
        ]
    ],
    'theverge.com' => [
        'scriptTagRemove' => 'zephr',
        'classElementRemove' => 'zephr'
    ],
    'nytimes.com' => [
        'idElementRemove' => ['gateway-content', 'site-index', 'complianceOverlay'],
        'customCode' => '
            setTimeout(function() {
                const walk = document.createTreeWalker(
                    document.body,
                    NodeFilter.SHOW_TEXT,
                    null,
                    false
                );
                let node;
                while (node = walk.nextNode()) {
                    node.textContent = node.textContent
                        .replace(/&rsquo;/g, "\\u2019")    /* right single quotation */
                        .replace(/&lsquo;/g, "\\u2018")    /* left single quotation */
                        .replace(/&rdquo;/g, "\\u201D")    /* right double quotation */
                        .replace(/&ldquo;/g, "\\u201C")    /* left double quotation */
                        .replace(/&mdash;/g, "\\u2014")    /* em dash */
                        .replace(/&ndash;/g, "\\u2013")    /* en dash */
                        .replace(/&hellip;/g, "\\u2026")   /* horizontal ellipsis */
                        .replace(/&bull;/g, "\\u2022")     /* bullet */
                        .replace(/&amp;/g, "&")            /* ampersand */
                        .replace(/&nbsp;/g, " ")           /* non-breaking space */
                        .replace(/&quot;/g, "\\"")         /* quotation mark */
                        .replace(/&apos;/g, "\'")          /* apostrophe */
                        .replace(/&lt;/g, "<")             /* less than */
                        .replace(/&gt;/g, ">")             /* greater than */
                        .replace(/&agrave;/g, "\\u00E0")   /* lowercase a with grave accent */
                        .replace(/&ntilde;/g, "\\u00F1");  /* lowercase n with tilde */
                }
            }, 3000);
        ',
        'customStyle' => '
            .vi-gateway-container {
                position: inherit !important;
                overflow: inherit !important;
                height: inherit !important;
            }
            #gateway-content {
                display: none !important;
                width: 1px !important;
                height: 1px !important;
                overflow: hidden !important;
                visibility: hidden !important;
            }
            #site-index {
                height: 100% !important;
                position: relative !important;
            }
        ',
        'fetchStrategies' => 'fetchFromWaybackMachine',
        'excludeGlobalRules' => [
            'scriptTagRemove' => [
                'gtm.js',
                'ga.js',
                'fbevents.js',
                'pixel.js',
                'chartbeat',
                'analytics.js',
                'cmp.js',
                'wall.js',
                'paywall.js',
                'subscriber.js',
                'piano.js',
                'tiny.js',
                'pywll.js',
                'content-gate.js',
                'signwall.js',
                'pw.js',
                'pw-',
                'piano-',
                'tinypass',
                'tp.min.js',
                'premium.js',
                'amp-access-0.1.js',
                'zephrBarriersScripts',
                'leaky-paywall',
                'cookie',
                'gdpr',
                'lgpd',
                'push',
                'sw.js',
                'stats.js',
                'piano.io',
                'onesignal.com',
                'getsitecontrol.com',
                'navdmp.com',
                'getblue.io',
                'smartocto.com',
                'cdn.pn.vg'
            ]
        ]
    ],
    'correio24horas.com.br' => [
        'idElementRemove' => ['paywall'],
        'classElementRemove' => ['paywall'],
        'classAttrRemove' => ['hide', 'is-active'],
        'cookies' => [
            'premium_access' => '1'
        ]
    ],
    'abril.com.br' => [
        'cookies' => [
            'paywall_access' => 'true'
        ],
        'classElementRemove' => ['piano-offer-overlay'],
        'classAttrRemove' => ['disabledByPaywall'],
        'idElementRemove' => ['piano_offer']
    ],
    'foreignpolicy.com' => [
        'idElementRemove' => ['paywall_bg'],
        'classAttrRemove' => ['overlay-no-scroll', 'overlay-no-scroll']
    ],
    'dgabc.com.br' => [
        'customCode' => '
                var email = "colaborador@dgabc.com.br";
                $(".NoticiaExclusivaNaoLogado").hide();
                $(".NoticiaExclusivaLogadoSemPermissao").hide();
                $(".linhaSuperBanner").show();
                $(".footer").show();
                $(".NoticiaExclusivaLogado").show();
            '
    ],
    'forbes.com' => [
        'classElementRemove' => ['zephr-backdrop', 'zephr-generic-modal'],
        'excludeGlobalRules' => [
            'classElementRemove' => ['premium-article'],
        ],
        'fetchStrategies' => 'fetchFromSelenium',
    ],
    'cmjornal.pt' => [
        'classAttrRemove' => ['bloco_bloqueio_premium'],
        'fetchStrategies' => 'fetchFromSelenium',
    ],
    'sabado.pt' => [
        'classElementRemove' => ['bloco_bloqueio'],
        'fetchStrategies' => 'fetchFromSelenium',
    ],
    'seudinheiro.com' => [
        'idElementRemove' => ['premium-paywall']
    ],
    'technologyreview.com' => [
        'cookies' => [
            'xbc' => null,
            '_pcid' => null,
            '_pcus' => null,
            '__tbc' => null,
            '__pvi' => null,
            '_pctx' => null
        ]
    ],
    'thestar.com' => [
        'classElementRemove' => ['subscriber-offers', 'subscriber-only', 'subscription-required', 'redacted-overlay', 'subscriber-hide', 'tnt-ads-container'],
        'customCode' => '
            window.localStorage.clear();
            document.addEventListener("DOMContentLoaded", () => {
                const paywall = document.querySelectorAll(\'div.subscriber-offers\');
                paywall.forEach(el => { el.remove(); });
                const subscriber_only = document.querySelectorAll(\'div.subscriber-only\');
                for (const elem of subscriber_only) {
                    if (elem.classList.contains(\'encrypted-content\') && typeof DOMPurify !== \'undefined\' && typeof unscramble !== \'undefined\') {
                        const parser = new DOMParser();
                        const doc = parser.parseFromString(\'<div>\' + DOMPurify.sanitize(unscramble(elem.innerText)) + \'</div>\', \'text/html\');
                        const content_new = doc.querySelector(\'div\');
                        elem.parentNode.replaceChild(content_new, elem);
                    }
                    elem.removeAttribute(\'style\');
                    elem.removeAttribute(\'class\');
                }
                const banners = document.querySelectorAll(\'div.subscription-required, div.redacted-overlay, div.subscriber-hide, div.tnt-ads-container\');
                banners.forEach(el => { el.remove(); });
                const ads = document.querySelectorAll(\'div.tnt-ads-container, div[class*="adLabelWrapper"]\');
                ads.forEach(el => { el.remove(); });
                const recommendations = document.querySelectorAll(\'div[id^="tncms-region-article"]\');
                recommendations.forEach(el => { el.remove(); });
            });
        '
    ],
    'niagarafallsreview.ca' => [
        'classElementRemove' => ['subscriber-offers', 'subscriber-only', 'subscription-required', 'redacted-overlay', 'subscriber-hide', 'tnt-ads-container'],
        'customCode' => '
            window.localStorage.clear();
            document.addEventListener("DOMContentLoaded", () => {
                const paywall = document.querySelectorAll(\'div.subscriber-offers\');
                paywall.forEach(el => { el.remove(); });
                const subscriber_only = document.querySelectorAll(\'div.subscriber-only\');
                for (const elem of subscriber_only) {
                    if (elem.classList.contains(\'encrypted-content\') && typeof DOMPurify !== \'undefined\' && typeof unscramble !== \'undefined\') {
                        const parser = new DOMParser();
                        const doc = parser.parseFromString(\'<div>\' + DOMPurify.sanitize(unscramble(elem.innerText)) + \'</div>\', \'text/html\');
                        const content_new = doc.querySelector(\'div\');
                        elem.parentNode.replaceChild(content_new, elem);
                    }
                    elem.removeAttribute(\'style\');
                    elem.removeAttribute(\'class\');
                }
                const banners = document.querySelectorAll(\'div.subscription-required, div.redacted-overlay, div.subscriber-hide, div.tnt-ads-container\');
                banners.forEach(el => { el.remove(); });
                const ads = document.querySelectorAll(\'div.tnt-ads-container, div[class*="adLabelWrapper"]\');
                ads.forEach(el => { el.remove(); });
                const recommendations = document.querySelectorAll(\'div[id^="tncms-region-article"]\');
                recommendations.forEach(el => { el.remove(); });
            });
        '
    ],
    'thepeterboroughexaminer.com' => [
        'classElementRemove' => ['subscriber-offers', 'subscriber-only', 'subscription-required', 'redacted-overlay', 'subscriber-hide', 'tnt-ads-container'],
        'customCode' => '
            window.localStorage.clear();
            document.addEventListener("DOMContentLoaded", () => {
                const paywall = document.querySelectorAll(\'div.subscriber-offers\');
                paywall.forEach(el => { el.remove(); });
                const subscriber_only = document.querySelectorAll(\'div.subscriber-only\');
                for (const elem of subscriber_only) {
                    if (elem.classList.contains(\'encrypted-content\') && typeof DOMPurify !== \'undefined\' && typeof unscramble !== \'undefined\') {
                        const parser = new DOMParser();
                        const doc = parser.parseFromString(\'<div>\' + DOMPurify.sanitize(unscramble(elem.innerText)) + \'</div>\', \'text/html\');
                        const content_new = doc.querySelector(\'div\');
                        elem.parentNode.replaceChild(content_new, elem);
                    }
                    elem.removeAttribute(\'style\');
                    elem.removeAttribute(\'class\');
                }
                const banners = document.querySelectorAll(\'div.subscription-required, div.redacted-overlay, div.subscriber-hide, div.tnt-ads-container\');
                banners.forEach(el => { el.remove(); });
                const ads = document.querySelectorAll(\'div.tnt-ads-container, div[class*="adLabelWrapper"]\');
                ads.forEach(el => { el.remove(); });
                const recommendations = document.querySelectorAll(\'div[id^="tncms-region-article"]\');
                recommendations.forEach(el => { el.remove(); });
            });
        '
    ],
    'therecord.com' => [
        'classElementRemove' => ['subscriber-offers', 'subscriber-only', 'subscription-required', 'redacted-overlay', 'subscriber-hide', 'tnt-ads-container'],
        'customCode' => '
            window.localStorage.clear();
            document.addEventListener("DOMContentLoaded", () => {
                const paywall = document.querySelectorAll(\'div.subscriber-offers\');
                paywall.forEach(el => { el.remove(); });
                const subscriber_only = document.querySelectorAll(\'div.subscriber-only\');
                for (const elem of subscriber_only) {
                    if (elem.classList.contains(\'encrypted-content\') && typeof DOMPurify !== \'undefined\' && typeof unscramble !== \'undefined\') {
                        const parser = new DOMParser();
                        const doc = parser.parseFromString(\'<div>\' + DOMPurify.sanitize(unscramble(elem.innerText)) + \'</div>\', \'text/html\');
                        const content_new = doc.querySelector(\'div\');
                        elem.parentNode.replaceChild(content_new, elem);
                    }
                    elem.removeAttribute(\'style\');
                    elem.removeAttribute(\'class\');
                }
                const banners = document.querySelectorAll(\'div.subscription-required, div.redacted-overlay, div.subscriber-hide, div.tnt-ads-container\');
                banners.forEach(el => { el.remove(); });
                const ads = document.querySelectorAll(\'div.tnt-ads-container, div[class*="adLabelWrapper"]\');
                ads.forEach(el => { el.remove(); });
                const recommendations = document.querySelectorAll(\'div[id^="tncms-region-article"]\');
                recommendations.forEach(el => { el.remove(); });
            });
        '
    ],
    'thespec.com' => [
        'classElementRemove' => ['subscriber-offers', 'subscriber-only', 'subscription-required', 'redacted-overlay', 'subscriber-hide', 'tnt-ads-container'],
        'customCode' => '
            window.localStorage.clear();
            document.addEventListener("DOMContentLoaded", () => {
                const paywall = document.querySelectorAll(\'div.subscriber-offers\');
                paywall.forEach(el => { el.remove(); });
                const subscriber_only = document.querySelectorAll(\'div.subscriber-only\');
                for (const elem of subscriber_only) {
                    if (elem.classList.contains(\'encrypted-content\') && typeof DOMPurify !== \'undefined\' && typeof unscramble !== \'undefined\') {
                        const parser = new DOMParser();
                        const doc = parser.parseFromString(\'<div>\' + DOMPurify.sanitize(unscramble(elem.innerText)) + \'</div>\', \'text/html\');
                        const content_new = doc.querySelector(\'div\');
                        elem.parentNode.replaceChild(content_new, elem);
                    }
                    elem.removeAttribute(\'style\');
                    elem.removeAttribute(\'class\');
                }
                const banners = document.querySelectorAll(\'div.subscription-required, div.redacted-overlay, div.subscriber-hide, div.tnt-ads-container\');
                banners.forEach(el => { el.remove(); });
                const ads = document.querySelectorAll(\'div.tnt-ads-container, div[class*="adLabelWrapper"]\');
                ads.forEach(el => { el.remove(); });
                const recommendations = document.querySelectorAll(\'div[id^="tncms-region-article"]\');
                recommendations.forEach(el => { el.remove(); });
            });
        '
    ],
    'wellandtribune.ca' => [
        'classElementRemove' => ['subscriber-offers', 'subscriber-only', 'subscription-required', 'redacted-overlay', 'subscriber-hide', 'tnt-ads-container'],
        'customCode' => '
            window.localStorage.clear();
            document.addEventListener("DOMContentLoaded", () => {
                const paywall = document.querySelectorAll(\'div.subscriber-offers\');
                paywall.forEach(el => { el.remove(); });
                const subscriber_only = document.querySelectorAll(\'div.subscriber-only\');
                for (const elem of subscriber_only) {
                    if (elem.classList.contains(\'encrypted-content\') && typeof DOMPurify !== \'undefined\' && typeof unscramble !== \'undefined\') {
                        const parser = new DOMParser();
                        const doc = parser.parseFromString(\'<div>\' + DOMPurify.sanitize(unscramble(elem.innerText)) + \'</div>\', \'text/html\');
                        const content_new = doc.querySelector(\'div\');
                        elem.parentNode.replaceChild(content_new, elem);
                    }
                    elem.removeAttribute(\'style\');
                    elem.removeAttribute(\'class\');
                }
                const banners = document.querySelectorAll(\'div.subscription-required, div.redacted-overlay, div.subscriber-hide, div.tnt-ads-container\');
                banners.forEach(el => { el.remove(); });
                const ads = document.querySelectorAll(\'div.tnt-ads-container, div[class*="adLabelWrapper"]\');
                ads.forEach(el => { el.remove(); });
                const recommendations = document.querySelectorAll(\'div[id^="tncms-region-article"]\');
                recommendations.forEach(el => { el.remove(); });
            });
        '
    ],
    'time.com' => [
        'headers' => [
            'User-Agent' => 'Mozilla/5.0 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)',
            'Cookie' => 'nyt-a=; nyt-gdpr=0; nyt-geo=DE; nyt-privacy=1',
            'Referer' => 'https://www.google.com/'
        ],
        'customCode' => '
            window.localStorage.clear();
            document.addEventListener("DOMContentLoaded", () => {
                const banners = document.querySelectorAll(\'div[data-testid="inline-message"], div[id^="ad-"], div[id^="leaderboard-"], div.expanded-dock, div.pz-ad-box, div[id="top-wrapper"], div[id="bottom-wrapper"]\');
                banners.forEach(el => { el.remove(); });
            });
        '
    ],
    'architecturaldigest.com' => [
        'customCode' => '
            document.addEventListener("DOMContentLoaded", () => {
                const banners = document.querySelectorAll(\'.paywall-bar, div[class^="MessageBannerWrapper-"\');
                banners.forEach(el => { el.remove(); });
            });
        '
    ],
    'bonappetit.com' => [
        'customCode' => '
            document.addEventListener("DOMContentLoaded", () => {
                const banners = document.querySelectorAll(\'.paywall-bar, div[class^="MessageBannerWrapper-"\');
                banners.forEach(el => { el.remove(); });
            });
        '
    ],
    'cntraveler.com' => [
        'customCode' => '
            document.addEventListener("DOMContentLoaded", () => {
                const banners = document.querySelectorAll(\'.paywall-bar, div[class^="MessageBannerWrapper-"\');
                banners.forEach(el => { el.remove(); });
            });
        '
    ],
    'epicurious.com' => [
        'customCode' => '
            document.addEventListener("DOMContentLoaded", () => {
                const banners = document.querySelectorAll(\'.paywall-bar, div[class^="MessageBannerWrapper-"\');
                banners.forEach(el => { el.remove(); });
            });
        '
    ],
    'gq.com' => [
        'customCode' => '
            document.addEventListener("DOMContentLoaded", () => {
                const banners = document.querySelectorAll(\'.paywall-bar, div[class^="MessageBannerWrapper-"\');
                banners.forEach(el => { el.remove(); });
            });
        '
    ],
    'vanityfair.com' => [
        'customCode' => '
            document.addEventListener("DOMContentLoaded", () => {
                const banners = document.querySelectorAll(\'.paywall-bar, div[class^="MessageBannerWrapper-"\');
                banners.forEach(el => { el.remove(); });
            });
        '
    ],
    'vogue.com' => [
        'customCode' => '
            document.addEventListener("DOMContentLoaded", () => {
                const banners = document.querySelectorAll(\'.paywall-bar, div[class^="MessageBannerWrapper-"\');
                banners.forEach(el => { el.remove(); });
            });
        '
    ],
    'americanbanker.com' => [
        'customCode' => '
            document.addEventListener("DOMContentLoaded", () => {
                const inlineGate = document.querySelector(\'.inline-gate\');
                if (inlineGate) {
                    inlineGate.classList.remove(\'inline-gate\');
                    const inlineGated = document.querySelectorAll(\'.inline-gated\');
                    for (const elem of inlineGated) { elem.classList.remove(\'inline-gated\'); }
                }
            });
        '
    ],
    'washingtonpost.com' => [
        'classElementRemove' => ['paywall-overlay'],
        'fetchStrategies' => 'fetchFromSelenium',
        'customCode' => '
            document.addEventListener("DOMContentLoaded", () => {
                let paywall = document.querySelectorAll(\'div[data-qa$="-ad"], div[id="leaderboard-wrapper"], div[data-qa="subscribe-promo"]\');
                paywall.forEach(el => { el.remove(); });
                const images = document.querySelectorAll(\'img\');
                images.forEach(image => { image.parentElement.style.filter = \'\'; });
                const headimage = document.querySelectorAll(\'div .aspect-custom\');
                headimage.forEach(image => { image.style.filter = \'\'; });
            });
        ',
        'idElementRemove' => ['wall-bottom-drawer-container']
    ],
    'usatoday.com' => [
        'customCode' => '
            document.addEventListener("DOMContentLoaded", () => {
                const banners = document.querySelectorAll(\'div.roadblock-container, .gnt_nb, [aria-label="advertisement"], div[id="main-frame-error"]\');
                banners.forEach(el => { el.remove(); });
            });
        '
    ],
    'stcatharinesstandard.ca' => [
        'proxy' => true,
        'idElementRemove' => 'access-offers-modal',
        'classElementRemove' => 'modal-backdrop',
        'classAttrRemove' => ' modal-open'
    ],
    'medium.com' => [
        'headers' => [
            'Referer' => 'https://t.co/x?amp=1',
            'X-Forwarded-For' => 'none',
            'User-Agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/119.0.0.0 Safari/537.36',
            'Content-Security-Policy' => 'script-src \'self\';'
        ]
    ],
    'tagesspiegel.de' => [
        'headers' => [
            'Content-Security-Policy' => 'script-src \'self\';',
            'User-Agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/119.0.0.0 Safari/537.36'
        ],
        'urlMods' => [
            'query' => [
                [
                    'key' => 'amp',
                    'value' => '1'
                ]
            ]
        ]
    ],
    'nzz.ch' => [
        'customCode' => '
            document.addEventListener("DOMContentLoaded", () => {
                const paywall = document.querySelector(\'.dynamic-regwall\');
                if (paywall) {
                    paywall.remove();
                }
            });
        '
    ],
    'demorgen.be' => [
        'headers' => [
            'Cookie' => 'isBot=true; authId=1',
            'User-Agent' => 'Mozilla/5.0 AppleWebKit/537.36 (KHTML, like Gecko; compatible; Googlebot/2.1; Googlebot-News; +http://www.google.com/bot.html) Chrome/121.0.6140.0 Safari/537.36',
            'X-Forwarded-For' => 'none',
            'Referer' => 'https://news.google.com'
        ],
        'customCode' => '
            document.addEventListener("DOMContentLoaded", () => {
                // remove paywall items
                let paywall = document.querySelectorAll(\'script[src*="advertising-cdn.dpgmedia.cloud"], div[data-temptation-position="ARTICLE_BOTTOM"]\');
                paywall.forEach(el => { el.remove(); });
                // remove empty advert
                const advert = document.querySelector(\'div[data-advert-placeholder-collapses]\');
                if (advert) {
                    advert.remove();
                }
            });
        '
    ],
    'ft.com' => [
        'cookies' => [
            'next-flags' => null,
            'next:ads' => null
        ],
        'fromGoogleBot' => true,
        'headers' => [
            'Referer' => 'https://t.co/x?amp=1'
        ],
        'customCode' => '
            document.addEventListener("DOMContentLoaded", () => {
                const styleTags = document.querySelectorAll(\'link[rel="stylesheet"]\');
                styleTags.forEach(el => {
                    const href = el.getAttribute(\'href\');
                    if (href && href.substring(0, 1) === \'/\') {
                        const updatedHref = href.substring(1).replace(/(https?:\\/\\/.+?)\\/{2,}/, \'$1/\');
                        el.setAttribute(\'href\', updatedHref);
                    }
                });
                setTimeout(() => {
                    const cookie = document.querySelectorAll(\'.o-cookie-message, .js-article-ribbon, .o-ads, .o-banner, .o-message, .article__content-sign-up\');
                    cookie.forEach(el => { el.remove(); });
                }, 1000);
            })
        '
    ]
];
