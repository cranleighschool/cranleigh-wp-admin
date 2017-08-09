<?php

namespace FredBradley\CranleighWPAdmin\SiteSpecific;

use FredBradley\CranleighWPAdmin\Plugin;

/**
 * Class Controller
 *
 * @package FredBradley\CranleighWPAdmin\SiteSpecific
 */
abstract class Controller {

	public $login_bg_color;
	public $login_bg_image;
	public $login_logo;

	/**
	 * Controller constructor.
	 */
	public function __construct() {
		$this->plugin = new Plugin();
	}

	/**
	 *
	 */
	public function custom_login_logo() {

		echo '<style type="text/css">
	#login>p>a {
		color: #fff !important;
	}
	body.login{
		background-color: '.$this->login_bg_color.';
		';
		if ($this->login_bg_image) {
			echo '

		background-image: url(\''.$this->plugin->getPluginImageURI($this->login_bg_image).'\');
		background-repeat: no-repeat;
		background-attachment: scroll;
		background-position: 0 0;
        ';
        } // endif
        echo '
        }
        ';


		if ($this->login_logo) {
			echo '.login h1 a {
                width: 270px;
                background-size: 270px; 58px;
			}';
        	echo 'h1 a {
        		background-image:url('.$this->plugin->getPluginImageURI($this->login_logo).') !important;
        	}';

        }

echo '</style>';
    }


}
