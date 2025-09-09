<?php
namespace App\Framework\DB;

use App\Framework\DB;

/**
 * Class Version
 *
 * Manages database versioning and migration scripts.
 */
class Version
{
    private string $table = 'db_version';
    const SCRIPTS_DIR = __DIR__ . '/../../sql/scripts/';

    /**
     * Runs the necessary migration scripts to update the database to the latest version.
     *
     * @return void
     */
    public function run()
    {
        // Get the current version from the database
        $currentVersion = $this->getCurrentVersion();
        $scripts = $this->_scriptsToRun($currentVersion);
        if (empty($scripts)) {
            return;
        }

        foreach ($scripts as $version => $script) {
            require_once $script;
            $this->_upVersion($version);
        }
    }

    /**
     * Scans the scripts directory and returns an array of scripts that need to be run
     * based on the current version.
     *
     * @param string $currentVersion
     * @return array
     */
    protected function _scriptsToRun(string $currentVersion): array
    {
        $files = scandir(self::SCRIPTS_DIR);
        $scripts = [];
        foreach ($files as $file) {
            if (pathinfo($file, PATHINFO_EXTENSION) === 'php') {
                $filename  = pathinfo($file, PATHINFO_FILENAME);
                $fileParts = explode('-', $filename, 2);
                $version = $fileParts[1];
                if (version_compare($version, $currentVersion, '<=') || $version === 'version') {
                    continue;
                }

                $scripts[$version] = self::SCRIPTS_DIR . $file;
            }
        }

        return $scripts;
    }

    /**
     * Retrieves the current database version from the version tracking table.
     *
     * @return string The current version, or '0.0.0' if the table does not exist
     */
    public function getCurrentVersion(): string
    {
        $db = $this->db();

        $stmt = $db->query("SHOW TABLES LIKE '$this->table'");
        $tableExists = $stmt->rowCount() > 0;
        if (! $tableExists) {
            return '0.0.0';
        }

        $stmt = $db->query("SELECT version FROM $this->table ORDER BY id DESC LIMIT 1");
        $version = $stmt->fetchColumn();

        return $version ?: '0.0.0';
    }

    /**
     * Inserts a new version record into the version tracking table.
     *
     * @param string $version The new version to record
     * @return void
     */
    private function _upVersion($version)
    {
        $db = $this->db();
        $stmt = $db->prepare("INSERT INTO $this->table (version, created_at, updated_at) VALUES (:version, NOW(), NOW())");
        $stmt->bindParam(':version', $version);
        $stmt->execute();
    }

    public function db()
    {
        return DB::getInstance();
    }
}