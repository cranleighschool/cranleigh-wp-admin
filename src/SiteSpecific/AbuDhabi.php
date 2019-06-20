<?php

namespace FredBradley\CranleighWPAdmin\SiteSpecific;

class AbuDhabi extends Controller {

	public function __construct( string $color = '#8cb7e8', string $bg_image = null, string $login_logo = 'ae_logo_small.png' ) {

		parent::__construct();

		$this->login_bg_color = $color;
		$this->login_bg_image = $bg_image;
		$this->login_logo     = $login_logo;

		add_action( 'login_head', array( $this, 'custom_login_logo' ) );
	}
	function custom_login_logo() {
		echo '<style type="text/css">
			#login>p>a {
				color: #fff !important;
				float:right;
			}
			body,html {
				background: url(\'' . $this->plugin->getPluginImageURI( 'abu-dhabi/footer-wave.png' ) . '\') no-repeat center 400px scroll transparent !important;
				height:auto;
			}
			body.login{
				background: url(\'' . $this->plugin->getPluginImageURI( 'abu-dhabi/header-wave.png' ) . '\') no-repeat center -350px scroll transparent !important;
				padding-bottom:75px;
			}/*8CB7E8 */
			#login {
				padding:10px 0 0;
			}
			#loginform {
				margin-top:50px;
				margin-bottom:70px;
			}
			.login h1 a {
				width: 270px;
				background-size: 270px; 58px;
			}
			.wp-core-ui .button-primary.focus, .wp-core-ui .button-primary.hover, .wp-core-ui .button-primary:focus, .wp-core-ui .button-primary:hover {
				background: #FFC627;
				color:#8cb7e8;
			}
			.wp-core-ui .button-primary {
				background: ' . $this->login_bg_color . ';
				border:none;
				border-color: none;
				-webkit-box-shadow: none;
				box-shadow: none;
				color: #fff;
				text-decoration: none;
				text-shadow: none;
			}
			';

		echo 'h1 a {
        		background-image:url(' . $this->plugin->getPluginImageURI( 'abu-dhabi/' . $this->login_logo ) . ') !important;
        	}';
		echo '</style>';
	}
}
