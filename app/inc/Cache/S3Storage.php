<?php

namespace Inc\Cache;

use Aws\S3\S3Client;
use Aws\Exception\AwsException;

/**
 * AWS S3-based cache storage implementation
 * Provides cache storage functionality using Amazon S3 or compatible services
 */
class S3Storage implements CacheStorageInterface
{
    /**
     * @var S3Client AWS S3 Client
     */
    private $s3Client;

    /**
     * @var string S3 bucket name
     */
    private $bucket;

    /**
     * @var string Prefix for objects in the bucket (optional)
     */
    private $prefix;

    /**
     * @var string ACL for S3 objects
     */
    private $acl;

    /**
     * Class constructor
     * @param array $config AWS S3 configuration
     */
    public function __construct(array $config)
    {
        $clientConfig = [
            'version' => 'latest',
            'region'  => $config['region'] ?? 'us-east-1',
            'credentials' => [
                'key'    => $config['key'],
                'secret' => $config['secret'],
            ]
        ];

        // Add custom endpoint if provided
        if (!empty($config['endpoint'])) {
            $clientConfig['endpoint'] = $config['endpoint'];
            $clientConfig['use_path_style_endpoint'] = true;
        }

        $this->s3Client = new S3Client($clientConfig);
        
        $this->bucket = $config['bucket'];
        $this->prefix = $config['prefix'] ?? 'cache/';
        $this->acl = $config['acl'] ?? 'private';
    }

    /**
     * Generates the complete object key in S3
     * @param string $id Cache ID
     * @return string Complete S3 object key
     */
    private function getObjectKey(string $id): string
    {
        return $this->prefix . $id . '.gz';
    }

    /**
     * Checks if cache exists for a given ID
     * @param string $id Cache ID
     * @return bool True if cache exists, false otherwise
     */
    public function exists(string $id): bool
    {
        try {
            return $this->s3Client->doesObjectExist(
                $this->bucket,
                $this->getObjectKey($id)
            );
        } catch (AwsException $e) {
            return false;
        }
    }

    /**
     * Retrieves cached content
     * @param string $id Cache ID
     * @return string|null Cached content or null if not found
     */
    public function get(string $id): ?string
    {
        if (!$this->exists($id)) {
            return null;
        }

        try {
            $result = $this->s3Client->getObject([
                'Bucket' => $this->bucket,
                'Key'    => $this->getObjectKey($id)
            ]);

            $compressedContent = $result['Body']->getContents();
        
            if ($compressedContent === false) {
                return null;
            }
            
            $decodedContent = gzdecode($compressedContent);
            return $decodedContent === false ? null : $decodedContent;
        } catch (AwsException $e) {
            return null;
        }
    }

    /**
     * Stores content in cache
     * @param string $id Cache ID
     * @param string $content Content to be stored
     * @return bool True if successful, false otherwise
     */
    public function set(string $id, string $content): bool
    {
        try {
            $compressedContent = gzencode($content, 3);
            if ($compressedContent === false) {
                return false;
            }

            $this->s3Client->putObject([
                'Bucket' => $this->bucket,
                'Key'    => $this->getObjectKey($id),
                'Body'   => $compressedContent,
                'ACL'    => $this->acl,
                'ContentEncoding' => 'gzip',
                'CacheControl'    => 'max-age=31536000' // 1 year
            ]);

            return true;
        } catch (AwsException $e) {
            return false;
        }
    }
}