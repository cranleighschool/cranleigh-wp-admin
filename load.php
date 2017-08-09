<?php
/*
Plugin Name: Cranleigh WP Admin
Plugin URI: https://www.github.com/cranleighschool/
Description: Creates a couple of dashboard widgets, and tidies default Wordpress guff away to a nice tidy admin theme display
Version: 1.0
Author: Fred Bradley <hello@fredbradley.co.uk>
Author URI: https://www.fredbradley.co.uk
License: MIT
*/

namespace FredBradley\CranleighWPAdmin;

if ( ! defined( 'WPINC' ) ) {
    die;
}
require_once plugin_dir_path( __FILE__ ) . 'vendor/autoload.php';

$plugin = new Plugin();

$plugin->loadRemoves();
$plugin->loadFooter();
$plugin->loadNotices();
$plugin->loadOnlineUserWidget();
$plugin->loadStyle();

$plugin->loadSiteSpecific();

