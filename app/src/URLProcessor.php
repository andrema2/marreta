<?php

namespace App;

use Inc\Language;
use Inc\URLAnalyzer;
use Inc\URLAnalyzer\URLAnalyzerException;
use Inc\Cache;

/**
 * URL Processor
 * Combines functionality for URL processing, handling both web and API responses
 */
class URLProcessor
{
    private $url;
    private $isApi;
    private $analyzer;

    /**
     * Constructor - initializes the processor with URL and mode
     * @param string $url The URL to process
     * @param bool $isApi Whether to return API response
     */
    public function __construct(string $url = '', bool $isApi = false)
    {
        require_once __DIR__ . '/../config.php';

        $this->url = $url;
        $this->isApi = $isApi;
        $this->analyzer = new URLAnalyzer();

        if ($isApi) {
            Language::init(LANGUAGE);
            header('Content-Type: application/json');
            header('Access-Control-Allow-Origin: *');
            header('Access-Control-Allow-Methods: GET');
        }
    }

    /**
     * Sends a JSON response for API requests
     */
    private function sendApiResponse(array $data, int $statusCode = 200): void
    {
        http_response_code($statusCode);
        $response = ['status' => $statusCode];

        if (isset($data['error'])) {
            $response['error'] = $data['error'];
        } else if (isset($data['url'])) {
            $response['url'] = $data['url'];
        }

        echo json_encode($response);
        exit;
    }

    /**
     * Handles web redirects
     */
    private function redirect(string $path, string $message = ''): void
    {
        $url = $message ? $path . '?message=' . $message : $path;
        header('Location: ' . $url);
        exit;
    }

    /**
     * Process the URL and return appropriate response
     */
    public function process(): void
    {
        try {
            // Check for redirects in web mode
            if (!$this->isApi) {
                $redirectInfo = $this->analyzer->checkStatus($this->url);
                if ($redirectInfo['hasRedirect'] && $redirectInfo['finalUrl'] !== $this->url) {
                    $this->redirect(SITE_URL . '/p/' . urlencode($redirectInfo['finalUrl']));
                }
            }

            // Process the URL
            $content = $this->analyzer->analyze($this->url);

            if ($this->isApi) {
                $this->sendApiResponse([
                    'url' => SITE_URL . '/p/' . urlencode($this->url)
                ]);
            } else {
                echo $content;
            }
        } catch (URLAnalyzerException $e) {
            $errorType = $e->getErrorType();
            $additionalInfo = $e->getAdditionalInfo();

            if ($this->isApi) {
                header('X-Error-Type: ' . $errorType);
                if ($additionalInfo) {
                    header('X-Error-Info: ' . $additionalInfo);
                }

                $this->sendApiResponse([
                    'error' => [
                        'type' => $errorType,
                        'message' => $e->getMessage(),
                        'details' => $additionalInfo ?: null
                    ]
                ], $e->getCode());
            } else {
                if ($errorType === URLAnalyzer::ERROR_BLOCKED_DOMAIN && $additionalInfo) {
                    $this->redirect(trim($additionalInfo), $errorType);
                } elseif ($errorType === URLAnalyzer::ERROR_DMCA_DOMAIN) {
                    // For DMCA domains, show the custom message directly instead of redirecting
                    Language::init(LANGUAGE);
                    $message = $e->getMessage();
                    $message_type = 'error';
                    $url = ''; // Initialize url variable for the view
                    
                    // Initialize cache for counting
                    $cache = new \Inc\Cache();
                    $cache_folder = $cache->getCacheFileCount();
                    
                    require __DIR__ . '/views/home.php';
                    exit;
                }
                $this->redirect(SITE_URL, $errorType);
            }
        } catch (\Exception $e) {
            if ($this->isApi) {
                $this->sendApiResponse([
                    'error' => [
                        'type' => URLAnalyzer::ERROR_GENERIC_ERROR,
                        'message' => Language::getMessage('GENERIC_ERROR')['message']
                    ]
                ], 500);
            } else {
                $this->redirect(SITE_URL, URLAnalyzer::ERROR_GENERIC_ERROR);
            }
        }
    }
}
