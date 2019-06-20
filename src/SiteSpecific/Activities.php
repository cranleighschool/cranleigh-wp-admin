<?php
/**
 * Created by PhpStorm.
 * User: fredbradley
 * Date: 30/10/2017
 * Time: 10:57
 */

namespace FredBradley\CranleighWPAdmin\SiteSpecific;

class Activities extends Controller {
	public function __construct( string $color = '#388CC0', string $bg_image = null, string $login_logo = 'CranleighActivitiesLogo.jpg' ) {
		parent::__construct();

		$this->login_bg_color = $color;
		$this->login_bg_image = $bg_image;
		$this->login_logo     = $login_logo;

		add_action( 'login_head', array( $this, 'custom_login_logo' ) );
	}
}

