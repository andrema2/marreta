<?php

namespace Inc\Cache;

use PDO;
use PDOException;

/**
 * SQLite-based cache storage implementation
 * Provides file counting functionality using SQLite
 * Delegates actual cache storage to DiskStorage
 */
class SQLiteStorage implements CacheStorageInterface
{
    /**
     * @var PDO|null SQLite connection
     */
    private $db;

    /**
     * @var string Cache directory for file counting
     */
    private $cacheDir;

    /**
     * @var string Path to SQLite database file
     */
    private $dbPath;

    /**
     * @var DiskStorage Disk storage for cache entries
     */
    private $diskStorage;

    /**
     * Class constructor
     * @param string $cacheDir Base directory for cache storage
     */
    public function __construct(string $cacheDir)
    {
        $this->cacheDir = $cacheDir;
        $this->diskStorage = new DiskStorage($cacheDir);
        
        // Ensure database directory exists
        $dbDir = $cacheDir . '/database';
        if (!is_dir($dbDir)) {
            mkdir($dbDir, 0755, true);
        }
        
        $this->dbPath = $dbDir . '/.sqlite';
        
        // Try to initialize SQLite connection
        try {
            $this->db = new PDO('sqlite:' . $this->dbPath);
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            // Create tables if they don't exist
            $this->initDatabase();
            
            // If database file was just created, count cache files
            if (!file_exists($this->dbPath) || filesize($this->dbPath) < 1024) {
                $this->countCacheFiles();
            }
        } catch (PDOException $e) {
            $this->db = null;
        }
    }
    
    /**
     * Initialize database tables
     */
    private function initDatabase(): void
    {
        $this->db->exec("
            CREATE TABLE IF NOT EXISTS stats (
                key TEXT PRIMARY KEY,
                value INTEGER NOT NULL
            )
        ");
    }

    /**
     * Counts the number of files in the cache directory
     * @return int Number of files in the cache directory
     */
    public function countCacheFiles(): int
    {
        if ($this->db !== null) {
            try {
                $stmt = $this->db->query("SELECT value FROM stats WHERE key = 'count'");
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                
                if ($result) {
                    return (int)$result['value'];
                }
            } catch (PDOException $e) {
                // Continue to count files if query fails
            }
        }

        $fileCount = 0;
        $iterator = new \FilesystemIterator($this->cacheDir);
        foreach ($iterator as $file) {
            if ($file->isFile() && $file->getExtension() === 'gz') {
                $fileCount++;
            }
        }

        if ($this->db !== null) {
            $this->updateCacheFileCount($fileCount);
        }

        return $fileCount;
    }

    /**
     * Updates the file count in SQLite
     * @param int $count Number of files
     */
    public function updateCacheFileCount(int $count): void
    {
        if ($this->db !== null) {
            try {
                $stmt = $this->db->prepare("
                    INSERT OR REPLACE INTO stats (key, value)
                    VALUES ('count', :count)
                ");
                $stmt->bindParam(':count', $count, PDO::PARAM_INT);
                $stmt->execute();
            } catch (PDOException $e) {
                // Silently fail if update fails
            }
        }
    }

    /**
     * Checks if cache exists for a given ID
     * Delegates to DiskStorage
     * @param string $id Cache ID
     * @return bool True if cache exists, false otherwise
     */
    public function exists(string $id): bool
    {
        return $this->diskStorage->exists($id);
    }

    /**
     * Retrieves cached content
     * Delegates to DiskStorage
     * @param string $id Cache ID
     * @return string|null Cached content or null if not found
     */
    public function get(string $id): ?string
    {
        return $this->diskStorage->get($id);
    }

    /**
     * Stores content in cache
     * Delegates to DiskStorage and updates file count
     * @param string $id Cache ID
     * @param string $content Content to be stored
     * @return bool True if successful, false otherwise
     */
    public function set(string $id, string $content): bool
    {
        $alreadyExists = $this->diskStorage->exists($id);
        $result = $this->diskStorage->set($id, $content);
        
        if ($result && !$alreadyExists) {
            // Increment cache file count
            $currentCount = $this->countCacheFiles();
            $this->updateCacheFileCount($currentCount + 1);
        }
        
        return $result;
    }
}