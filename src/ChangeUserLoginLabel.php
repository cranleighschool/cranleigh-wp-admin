<?php

namespace FredBradley\CranleighWPAdmin;

class ChangeUserLoginLabel {

	public function __construct() {

		add_action( 'login_head', [ $this, 'login_function' ] );

	}

	public function login_function() {

		add_filter( 'gettext', [ $this, 'username_change' ], 20, 3 );
		add_filter( 'gettext_with_context', [ $this, 'custom_login_text' ] );
	}

	public function username_change( $translated_text, $text, $domain ) {

		if ( $text === 'Username or Email Address' ) {
			$translated_text = 'Email Address';
		}
		if ( $text == '&larr; Back to %s' ) {
			$translated_text = "Magic Phrase";
		}

		return $translated_text;
	}

	function custom_login_text( $text ) {

		if ( in_array( $GLOBALS[ 'pagenow' ], [ 'wp-login.php', 'wp-register.php' ] ) ) {

			if ( $text == '&larr; Back to %s' ) {
				$text = '&larr; Back to the %s Website';
			}

			return $text;

		}

	}


}
