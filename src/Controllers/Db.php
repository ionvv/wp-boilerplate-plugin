<?php
namespace Wpbp\Controllers;

if (!defined('ABSPATH')) {
	exit;
}

use Wpbp\Models\Shortcode as ShortcodeModel;

/**
* Class Db
*
* @package Wpbp\Controllers
* @since 1.0.0
*/
final class Db
{
    /**
     * Function create tables on install
     * @since 1.0.0
     */
    public function createTablesOnInstall()
    {
        $shortcode_model = new ShortcodeModel();
        $shortcode_model->createOrUpdateTableOnPluginInstallOrUpdate();
    }

    /**
     * Function create tables on install
     * @since 1.0.0
     */
    public function updateTablesOnPluginsLoaded()
    {
        $shortcode_model = new ShortcodeModel();
        $shortcode_model->tableNeedsToBeUpdated();
    }
}
