<?php
namespace FredBradley\CranleighWPAdmin;

class Style {

	public function __construct() {
		add_action( 'wp_enqueue_scripts', array($this, 'cranleigh_style_admin_toolbar') );
		add_action( 'admin_enqueue_scripts', array($this, 'cranleigh_style_admin_toolbar') );
	}

	public function cranleigh_style_admin_toolbar() {
		wp_enqueue_style("cranleigh_font_css", plugins_url('style.css', dirname(__FILE__)));
	}

}
