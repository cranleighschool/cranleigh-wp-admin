<?php
namespace FredBradley\CranleighWPAdmin;

class Style {

	public function __construct() {
		add_action( 'wp_enqueue_scripts', array( $this, 'cranleigh_style_admin_toolbar' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'cranleigh_style_admin_toolbar' ) );
	}

	public function cranleigh_style_admin_toolbar() {

		if ( is_user_logged_in() ) :
			wp_enqueue_style( 'cranleigh-wp-admin', plugins_url( 'style.css', dirname( __FILE__ ) ) );
			wp_enqueue_style( 'cranfont', '//cdn.cranleigh.org/cranfont/style.css' );
		endif;
	}

}
