<?php
/*
Plugin Name: Cranleigh WP Admin
Plugin URI: https://www.github.com/cranleighschool/cranleigh-wp-admin
Description: Creates a couple of dashboard widgets, and tidies default WordPress guff away to a nice tidy admin theme display
Version: 1.7.15
Author: Fred Bradley <hello@fredbradley.co.uk>
Author URI: https://www.fredbradley.co.uk
License: MIT
Network: true
*/

namespace FredBradley\CranleighWPAdmin;

use FredBradley\CranleighSchool\Person;
use FredBradley\CranleighWPAdmin\RolesAndCapabilities\Personnel;

if ( ! defined( 'WPINC' ) ) {
	die;
}
require_once plugin_dir_path( __FILE__ ) . 'vendor/autoload.php';

$updates = new PluginUpdateCheck( 'cranleigh-wp-admin' );

$plugin = new Plugin();

$plugin->loadRemoves();
$plugin->loadFooter();
$plugin->loadNotices();
$plugin->loadOnlineUserWidget();
$plugin->loadStyle();
$plugin->loadDownloadStatsWidget();
$plugin->loadPostCountWidget();
$plugin->loadSiteSpecific();
$plugin->loadChangeUserLoginLabel();

$plugin->loadCustomRolesAndCapabilities();
