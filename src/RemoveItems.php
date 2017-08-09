<?php

namespace FredBradley\CranleighWPAdmin;

class RemoveItems {
	public function __construct() {
		define( 'DISALLOW_FILE_EDIT', true );

		add_action( 'wp_dashboard_setup', array($this,'remove_dash_widgets'), 99999);
		add_filter('gettext', array($this,'howdy_message'), 10, 3);
		add_action("admin_bar_menu", array($this,'remove_wp_logo'), 9999999999);
		add_action( 'admin_head', array($this,'hide_update_notice_to_all_but_admin_users'), 1 );
		add_action('admin_head', array($this,'hide_help'));
		add_action('admin_bar_menu', array($this,'my_admin_bar_menu'), 9999);
		add_action('wp_network_dashboard_setup', array($this, 'remove_dash_widgets'),999999);
	}

	public function remove_dash_widgets() {
		global $wp_meta_boxes;
		unset($wp_meta_boxes['dashboard-network']['side']['core']['dashboard_primary']);
		unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_quick_press']); // Quick Draft
		unset($wp_meta_boxes['dashboard']['normal']['core']['photocrati_admin_dashboard_widget']);
		unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins']);
		unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_recent_drafts']);
		unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_comments']);
		unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']); // Wordpress News
		unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary']);
		unset($wp_meta_boxes['dashboard']['normal']['advanced']['dashboard_range']);
		unset($wp_meta_boxes['dashboard']['normal']['core']['wpseo-dashboard-overview']);

		if (!current_user_can( 'administrator' )) {
			unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_right_now']);
			unset($wp_meta_boxes['dashboard']['normal']['core']['rg_forms_dashboard']);
			unset($wp_meta_boxes['dashboard']['normal']['core']['dlm_popular_downloads']);
			unset($wp_meta_boxes['dashboard']['normal']['core']['simple_history_dashboard_widget']);
		}
	}

	public function my_admin_bar_menu() {
		global $wp_admin_bar;

		if ( !is_admin_bar_showing() )
			return;

		$wp_admin_bar->add_menu(
			array(
				'id' => 'my-sites',
				'title' => __( 'Sites'),
				'href' => FALSE,
				'meta' => array("class" => "cranleigh-icon icon-cranleigh-crest")
			)
		);



	}

	/**
	 * @param $translated_text
	 * @param $text
	 * @param $domain
	 *
	 * @return mixed
	 */
	public function howdy_message($translated_text, $text, $domain) {
		$new_message = str_replace('Howdy, ', '', $text);

	    return $new_message;
	}


	/**
	 * @param $wp_admin_bar
	 */
	public function remove_wp_logo($wp_admin_bar) {
		$wp_admin_bar->remove_node('ngg-menu');
		$wp_admin_bar->remove_node('wpseo-menu');
		$wp_admin_bar->remove_node('comments');
		$wp_admin_bar->remove_node('wp-logo');
	}


	public function hide_update_notice_to_all_but_admin_users() {
	    if (!current_user_can('update_core')) {
	        remove_action( 'admin_notices', 'update_nag', 3 );
	    }
	}

	/**
	 *
	 */
	public function hide_help() {
	    echo "<style type=\"text/css\">
	            #contextual-help-link-wrap { display: none !important; }
	          </style>";
	}


}
