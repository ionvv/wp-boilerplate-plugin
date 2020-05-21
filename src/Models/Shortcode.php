<?php
namespace Wpbp\Models;

if (!defined('ABSPATH')) {
	exit;
}

/**
* class Shortcode
*
* @package Wpbp\Models
* @since 1.0.0
*/
class Shortcode
{

    /**
    * @var string
    */
    private $tableName;

    /**
    * @var string
    */
    private $tableVersion;

    /**
    * @var string
    */
    private $tableVersionSlug;

    /**
    * @var string
    */
    private $charsetCollate;

    /**
    * @var array
    */
    private $status = array(
        'valid' => 1,
        'deleted' => -1,
    );

    /**
    * Function construct
    */
    public function __construct()
    {
        global $wpdb;

        $this->tableName = $wpdb->prefix . 'wpbp_demo_table';
        $this->charsetCollate  = $wpdb->get_charset_collate();
        $this->tableVersion = WPBP_VERSION;
        $this->tableVersionSlug = $this->tableName . '_db_version';
    }

    /**
    * Function to get table version
    *
    * @return float
    */
    public function getTableVersion()
    {
        return $this->tableVersion;
    }

    /**
    * Function to get table version
    *
    * @return float
    */
    public function getTableName()
    {
        return $this->tableName;
    }

    /**
    * Function to create or update table
    */
    public function createOrUpdateTableOnPluginInstallOrUpdate()
    {
        if (get_option($this->tableVersionSlug) != $this->getTableVersion()) {
            require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

            $sql = "CREATE TABLE $this->tableName (
                id bigint NOT NULL AUTO_INCREMENT,
                shortcode_name varchar(255) NOT NULL,
                created_by bigint NOT NULL,
                timestamp bigint NOT NULL,
                status int DEFAULT 1 NULL,
                PRIMARY KEY (id)
            ) $this->charsetCollate;";

            dbDelta($sql);

            update_option($this->tableVersionSlug, $this->tableVersion);
        }
    }

    /**
    * Function to create new entry
    *
    * @param array $data that will be insterted
    */
    public function tableNeedsToBeUpdated()
    {
        if (get_option($this->tableVersionSlug) != $this->getTableVersion()) {
            $this->createOrUpdateTableOnPluginInstallOrUpdate();
        }
    }

    /**
    * Function to create new entry
    *
    * @param array $data that will be insterted
    */
    public function newEntry(array $data): int
    {
        global $wpdb;
        $res = $wpdb->insert($this->tableName, $data);

        return $wpdb->insert_id;
    }

    /**
    * Function to update row in db
    *
    * @param array $data that will be insterted
    * @param int $id of the entry to be updated
    *
    * @return bool success or not
    */
    public function updateEntry(array $data, int $id): bool
    {
        global $wpdb;
        $updated = $wpdb->update($this->tableName, $data, ['id' => $id]);

        return (bool) $updated;
    }

    /**
    * Function to update row in db
    *
    * @param array $data that will be insterted
    * @param int $id of the entry to be updated
    *
    * @return bool success or not
    */
    public function markShortcodeAsDeleted(int $id): bool
    {
        global $wpdb;
        $updated = $wpdb->update(
            $this->tableName,
            [
                'status' => $this->status['deleted']
            ],
            [
                'id' => $id
            ]
        );

        return (bool) $updated;
    }

    /**
    * Function to delete row in db
    *
    * @param int $id of the entry to be deleted
    *
    * @return bool success or not
    */
    public function deleteEntry(int $id): bool
    {
        global $wpdb;
        $deleted = $wpdb->delete($this->tableName, ['id' => $id]);
        return (bool) $deleted;
    }

    /**
    * Function to retrieve entry from db by entry id
    *
    * @param int $id of the entry to be retrieved
    *
    * @return array
    */
    public function getEntryById(int $id): array
    {
        global $wpdb;
        $sql = $wpdb->prepare("SELECT * FROM $this->tableName WHERE id = %d AND status = %d", $id, $this->status['valid']);
        $entry = $wpdb->get_row($sql, ARRAY_A);
        return $entry ?? [];
    }

    /**
    * Function to retrieve entry from db by entry id
    *
    * @param int $pageNr - page number
    * @param int $perPage - number of entries to be retrieved
    *
    * @return array
    */
    public function getEntries(int $pageNr = 1, int $perPage = 20): array
    {
        global $wpdb;
        $offset  = ($pageNr - 1) * $perPage;
        $sql = $wpdb->prepare("SELECT * FROM $this->tableName WHERE status = %d ORDER BY id DESC LIMIT %d, %d", $this->status['valid'], $offset, $perPage);
        $entries = $wpdb->get_results($sql, ARRAY_A);
        return $entries ?? [];
    }

    /**
    * Function to retrieve entry from db by entry id
    *
    * @param int $pageNr - page number
    * @param int $perPage - number of entries to be retrieved
    *
    * @return int
    */
    public function getEntriesPagesCount(int $perPage = 20): int
    {
        global $wpdb;
        $totalPages = 0;
        $sql = $wpdb->prepare("SELECT count(id) as total_entries FROM $this->tableName WHERE status = %d", $this->status['valid']);
        $entries = $wpdb->get_row($sql, ARRAY_A);

        if (0 < $entries['total_entries']) {
            $totalPages = ceil($entries['total_entries'] / $perPage);
        }
        return (int) $totalPages;
    }
}
