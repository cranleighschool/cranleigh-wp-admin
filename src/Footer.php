<?php
namespace FredBradley\CranleighWPAdmin;

class Footer {

	public function __construct() {

		add_filter( 'update_footer', array( $this, 'wp_version_footer' ), 12 );
		add_filter( 'admin_footer_text', array( $this, 'remove_footer_admin' ), 23 );

	}
	public function remove_footer_admin() {
		// The Left hand side of the Footer
		// echo 'WordPress v'.get_bloginfo('version').' | Cranleigh\'s Web Guy: <a href="mailto:frb@cranleigh.org" target="_blank">Fred</a> | Got a techy issue? <a href="mailto:helpdesk@cranleigh.org" target="_blank">Report It.</a></p>';
	}

	public function wp_version_footer() {
		// The Right hand Side of the Footer
		// return false;
		echo '<code>v' . get_bloginfo( 'version' ) . '</code> | Developer: <a href="mailto:frb@cranleigh.org" target="_blank">Fred Bradley</a> | Got an issue? <a href="mailto:helpdesk@cranleigh.org" target="_blank">helpdesk@cranleigh.org</a></p>';
	}

}
