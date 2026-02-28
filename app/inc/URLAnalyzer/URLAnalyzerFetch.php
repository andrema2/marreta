<?php
/**
 * Fetches content using multiple strategies
 * Uses cURL, Wayback Machine, and Selenium
 */

namespace Inc\URLAnalyzer;

use Curl\Curl;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\Firefox\FirefoxOptions;
use Facebook\WebDriver\Firefox\FirefoxProfile;
use Facebook\WebDriver\Chrome\ChromeOptions;

class URLAnalyzerFetch extends URLAnalyzerBase
{
    /** @var URLAnalyzerError Handler for throwing formatted errors */
    private $error;

    /**
     * Sets up the fetch handler with error handling capability
     */
    /** @var array List of available proxies */
    private $proxyList = [];
    
    /** @var string Path to proxy cache file */
    private $proxyCachePath = '';
    
    public function __construct()
    {
        parent::__construct();
        $this->error = new URLAnalyzerError();
        $this->proxyCachePath = __DIR__ . '/../../cache/proxy_list.json';
        $this->loadProxyList();
    }
    
    /**
     * Loads proxy list from cache if available
     */
    private function loadProxyList()
    {
        if (isset($_ENV['PROXY_LIST']) && file_exists($this->proxyCachePath)) {
            $cachedList = file_get_contents($this->proxyCachePath);
            if (!empty($cachedList)) {
                $this->proxyList = json_decode($cachedList, true);
            }
        }
    }
    
    /**
     * Gets a random proxy from the list
     * @return string|null Random proxy URL or null if none available
     */
    private function getRandomProxy()
    {
        if (empty($this->proxyList)) {
            return null;
        }
        
        return $this->proxyList[array_rand($this->proxyList)];
    }

    /** 
     * Fetches content using cURL
     * Handles redirects and custom headers
     */
    /**
     * Modifies URL based on urlMods rules
     * @param string $url Original URL
     * @param array $domainRules Domain rules containing urlMods
     * @return string Modified URL
     */
    private function applyUrlModifications($url, $domainRules)
    {
        if (!isset($domainRules['urlMods'])) {
            return $url;
        }

        $urlParts = parse_url($url);
        
        if (isset($domainRules['urlMods']['query']) && is_array($domainRules['urlMods']['query'])) {
            $queryParams = [];
            
            if (isset($urlParts['query'])) {
                parse_str($urlParts['query'], $queryParams);
            }
            
            foreach ($domainRules['urlMods']['query'] as $queryMod) {
                if (isset($queryMod['key']) && isset($queryMod['value'])) {
                    $queryParams[$queryMod['key']] = $queryMod['value'];
                }
            }
            
            $urlParts['query'] = http_build_query($queryParams);
        }

        $modifiedUrl = '';
        
        if (isset($urlParts['scheme'])) {
            $modifiedUrl .= $urlParts['scheme'] . '://';
        }
        
        if (isset($urlParts['user'])) {
            $modifiedUrl .= $urlParts['user'];
            if (isset($urlParts['pass'])) {
                $modifiedUrl .= ':' . $urlParts['pass'];
            }
            $modifiedUrl .= '@';
        }
        
        if (isset($urlParts['host'])) {
            $modifiedUrl .= $urlParts['host'];
        }
        
        if (isset($urlParts['port'])) {
            $modifiedUrl .= ':' . $urlParts['port'];
        }
        
        if (isset($urlParts['path'])) {
            $modifiedUrl .= $urlParts['path'];
        }
        
        if (isset($urlParts['query'])) {
            $modifiedUrl .= '?' . $urlParts['query'];
        }
        
        if (isset($urlParts['fragment'])) {
            $modifiedUrl .= '#' . $urlParts['fragment'];
        }
        
        return $modifiedUrl;
    }

    /**
     * Parses a Cookie header string into a name => value map.
     */
    private function parseCookieHeader(string $cookieHeader): array
    {
        $cookies = [];
        $pairs = explode(';', $cookieHeader);

        foreach ($pairs as $pair) {
            $pair = trim($pair);
            if ($pair === '' || strpos($pair, '=') === false) {
                continue;
            }

            [$name, $value] = explode('=', $pair, 2);
            $name = trim($name);
            $value = trim($value);

            if ($name !== '') {
                $cookies[$name] = $value;
            }
        }

        return $cookies;
    }

    /**
     * Builds and sanitizes the outgoing Cookie header based on domain rules.
     * Supports exact cookie overrides/removals and prefix-based removals.
     */
    private function buildCookieHeaderFromRules(array $domainRules): ?string
    {
        $cookies = [];

        if (
            isset($domainRules['headers']) &&
            is_array($domainRules['headers']) &&
            isset($domainRules['headers']['Cookie']) &&
            is_string($domainRules['headers']['Cookie'])
        ) {
            $cookies = $this->parseCookieHeader($domainRules['headers']['Cookie']);
        }

        if (isset($domainRules['cookies']) && is_array($domainRules['cookies'])) {
            foreach ($domainRules['cookies'] as $name => $value) {
                if ($value === null) {
                    unset($cookies[$name]);
                    continue;
                }

                $cookies[$name] = (string)$value;
            }
        }

        if (isset($domainRules['cookiePrefixRemove']) && is_array($domainRules['cookiePrefixRemove'])) {
            foreach (array_keys($cookies) as $cookieName) {
                foreach ($domainRules['cookiePrefixRemove'] as $prefix) {
                    if ($prefix !== '' && str_starts_with($cookieName, (string)$prefix)) {
                        unset($cookies[$cookieName]);
                        break;
                    }
                }
            }
        }

        if (empty($cookies)) {
            return null;
        }

        $cookiePairs = [];
        foreach ($cookies as $name => $value) {
            $cookiePairs[] = $name . '=' . $value;
        }

        return implode('; ', $cookiePairs);
    }

    public function fetchContent($url)
    {
        $curl = new Curl();

        $host = parse_url($url, PHP_URL_HOST);
        if (!$host) {
            $this->error->throwError(self::ERROR_INVALID_URL);
        }
        $host = preg_replace('/^www\./', '', $host);
        $domainRules = $this->getDomainRules($host);
        
        $url = $this->applyUrlModifications($url, $domainRules);

        $curl->setOpt(CURLOPT_FOLLOWLOCATION, true);
        $curl->setOpt(CURLOPT_MAXREDIRS, 2);
        $curl->setOpt(CURLOPT_TIMEOUT, 10);
        $curl->setOpt(CURLOPT_SSL_VERIFYPEER, VERIFY_SSL);
        $curl->setOpt(CURLOPT_SSL_VERIFYHOST, VERIFY_SSL ? 2 : 0);
        $curl->setOpt(CURLOPT_DNS_SERVERS, implode(',', $this->dnsServers));
        $curl->setOpt(CURLOPT_ENCODING, '');
        
        if (isset($domainRules['proxy']) && $domainRules['proxy'] === true) {
            $proxy = $this->getRandomProxy();
            if ($proxy) {
                $curl->setOpt(CURLOPT_PROXY, $proxy);
            }
        }

        $curl->setHeaders([
            'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8',
            'Accept-Language' => 'en-US,en;q=0.5',
            'Cache-Control' => 'no-cache',
            'Pragma' => 'no-cache',
            'DNT' => '1'
        ]);

        if (isset($domainRules['fromGoogleBot'])) {
            $curl->setUserAgent($this->getRandomUserAgent(true));
            $curl->setHeaders([
                'X-Forwarded-For' => '66.249.' . rand(64, 95) . '.' . rand(1, 254),
                'From' => 'googlebot(at)googlebot.com'
            ]);
        }

        if (isset($domainRules['headers'])) {
            $curl->setHeaders($domainRules['headers']);
        }

        $cookieHeader = $this->buildCookieHeaderFromRules($domainRules);
        if ($cookieHeader !== null) {
            $curl->setHeader('Cookie', $cookieHeader);
        }

        $curl->get($url);

        if ($curl->error) {
            $errorMessage = $curl->errorMessage;
            if (strpos($errorMessage, 'DNS') !== false) {
                $this->error->throwError(self::ERROR_DNS_FAILURE);
            } elseif (strpos($errorMessage, 'CURL') !== false) {
                $this->error->throwError(self::ERROR_CONNECTION_ERROR);
            } elseif ($curl->httpStatusCode === 404) {
                $this->error->throwError(self::ERROR_NOT_FOUND);
            } else {
                $this->error->throwError(self::ERROR_HTTP_ERROR);
            }
        }

        if ($curl->httpStatusCode !== 200 || empty($curl->response)) {
            $this->error->throwError(self::ERROR_HTTP_ERROR);
        }

        return $curl->response;
    }

    /** 
     * Fetches from Wayback Machine archive
     * Used when direct access fails
     */
    public function fetchFromWaybackMachine($url)
    {
        $domainHost = parse_url($url, PHP_URL_HOST);
        if ($domainHost) {
            $domainHost = preg_replace('/^www\./', '', $domainHost);
            $domainRules = $this->getDomainRules($domainHost);
            $url = $this->applyUrlModifications($url, $domainRules);
        }
        
        $url = preg_replace('#^https?://#', '', $url);
        $availabilityUrl = "https://archive.org/wayback/available?url=" . urlencode($url);

        $curl = new Curl();
        $curl->setOpt(CURLOPT_FOLLOWLOCATION, true);
        $curl->setOpt(CURLOPT_TIMEOUT, 10);
        $curl->setOpt(CURLOPT_SSL_VERIFYPEER, VERIFY_SSL);
        $curl->setOpt(CURLOPT_SSL_VERIFYHOST, VERIFY_SSL ? 2 : 0);
        $curl->setUserAgent($this->getRandomUserAgent());
        
        if (isset($domainRules['proxy']) && $domainRules['proxy'] === true) {
            $proxy = $this->getRandomProxy();
            if ($proxy) {
                $curl->setOpt(CURLOPT_PROXY, $proxy);
            }
        }

        $curl->get($availabilityUrl);

        if ($curl->error) {
            if (strpos($curl->errorMessage, 'DNS') !== false) {
                $this->error->throwError(self::ERROR_DNS_FAILURE);
            } elseif (strpos($curl->errorMessage, 'CURL') !== false) {
                $this->error->throwError(self::ERROR_CONNECTION_ERROR);
            } else {
                $this->error->throwError(self::ERROR_HTTP_ERROR);
            }
        }

        $data = $curl->response;
        if (!isset($data->archived_snapshots->closest->url)) {
            $this->error->throwError(self::ERROR_NOT_FOUND);
        }

        $archiveUrl = $data->archived_snapshots->closest->url;
        $curl = new Curl();
        $curl->setOpt(CURLOPT_FOLLOWLOCATION, true);
        $curl->setOpt(CURLOPT_TIMEOUT, 10);
        $curl->setOpt(CURLOPT_SSL_VERIFYPEER, VERIFY_SSL);
        $curl->setOpt(CURLOPT_SSL_VERIFYHOST, VERIFY_SSL ? 2 : 0);
        $curl->setUserAgent($this->getRandomUserAgent());
        
        if (isset($domainRules['proxy']) && $domainRules['proxy'] === true) {
            $proxy = $this->getRandomProxy();
            if ($proxy) {
                $curl->setOpt(CURLOPT_PROXY, $proxy);
            }
        }

        $curl->get($archiveUrl);

        if ($curl->error || $curl->httpStatusCode !== 200 || empty($curl->response)) {
            $this->error->throwError(self::ERROR_HTTP_ERROR);
        }

        $content = $curl->response;

        $content = preg_replace('/<!-- BEGIN WAYBACK TOOLBAR INSERT -->.*?<!-- END WAYBACK TOOLBAR INSERT -->/s', '', $content);
        $content = preg_replace('/https?:\/\/web\.archive\.org\/web\/\d+im_\//', '', $content);

        return $content;
    }

    /** 
     * Fetches using Selenium for JS-heavy sites
     * Supports Firefox and Chrome
     */
    public function fetchFromSelenium($url, $browser = 'firefox')
    {
        $host = 'http://'.SELENIUM_HOST.'/wd/hub';
        
        $domainHost = parse_url($url, PHP_URL_HOST);
        if ($domainHost) {
            $domainHost = preg_replace('/^www\./', '', $domainHost);
            $domainRules = $this->getDomainRules($domainHost);
            $url = $this->applyUrlModifications($url, $domainRules);
        }

        $useProxy = isset($domainRules['proxy']) && $domainRules['proxy'] === true;
        $proxy = $useProxy ? $this->getRandomProxy() : null;

        if ($browser === 'chrome') {
            $options = new ChromeOptions();
            $arguments = [
                '--headless',
                '--disable-gpu',
                '--no-sandbox',
                '--disable-dev-shm-usage',
                '--disable-images',
                '--blink-settings=imagesEnabled=false'
            ];
            
            if ($useProxy && $proxy) {
                $arguments[] = '--proxy-server=' . $proxy;
            }
            
            $options->addArguments($arguments);

            $capabilities = DesiredCapabilities::chrome();
            $capabilities->setCapability(ChromeOptions::CAPABILITY, $options);
        } else {
            $profile = new FirefoxProfile();
            $profile->setPreference("permissions.default.image", 2);
            $profile->setPreference("javascript.enabled", true);
            $profile->setPreference("network.http.referer.defaultPolicy", 0);
            $profile->setPreference("network.http.referer.defaultReferer", "https://www.google.com");
            $profile->setPreference("network.http.referer.spoofSource", true);
            $profile->setPreference("network.http.referer.trimmingPolicy", 0);
            
            if ($useProxy && $proxy) {
                $proxyParts = parse_url($proxy);
                if (isset($proxyParts['host']) && isset($proxyParts['port'])) {
                    $profile->setPreference("network.proxy.type", 1);
                    $profile->setPreference("network.proxy.http", $proxyParts['host']);
                    $profile->setPreference("network.proxy.http_port", $proxyParts['port']);
                    $profile->setPreference("network.proxy.ssl", $proxyParts['host']);
                    $profile->setPreference("network.proxy.ssl_port", $proxyParts['port']);
                    
                    if (isset($proxyParts['user']) && isset($proxyParts['pass'])) {
                        $profile->setPreference("network.proxy.username", $proxyParts['user']);
                        $profile->setPreference("network.proxy.password", $proxyParts['pass']);
                    }
                }
            }

            $options = new FirefoxOptions();
            $options->setProfile($profile);

            $capabilities = DesiredCapabilities::firefox();
            $capabilities->setCapability(FirefoxOptions::CAPABILITY, $options);
        }

        try {
            $driver = RemoteWebDriver::create($host, $capabilities);
            $driver->manage()->timeouts()->pageLoadTimeout(10);
            $driver->manage()->timeouts()->setScriptTimeout(5);

            $driver->get($url);

            $htmlSource = $driver->executeScript("return document.documentElement.outerHTML;");

            $driver->quit();

            if (empty($htmlSource)) {
                $this->error->throwError(self::ERROR_CONTENT_ERROR);
            }

            return $htmlSource;
        } catch (\Exception $e) {
            if (isset($driver)) {
                $driver->quit();
            }

            $message = $e->getMessage();
            if (strpos($message, 'DNS') !== false) {
                $this->error->throwError(self::ERROR_DNS_FAILURE);
            } elseif (strpos($message, 'timeout') !== false) {
                $this->error->throwError(self::ERROR_CONNECTION_ERROR);
            } elseif (strpos($message, 'not found') !== false) {
                $this->error->throwError(self::ERROR_NOT_FOUND);
            } else {
                $this->error->throwError(self::ERROR_HTTP_ERROR);
            }
        }
    }
}
