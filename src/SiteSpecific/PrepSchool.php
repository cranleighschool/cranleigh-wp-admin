<?php

namespace FredBradley\CranleighWPAdmin\SiteSpecific;

class PrepSchool extends Controller {

	public function __construct( string $color = '#8cb7e8', string $bg_image = null, string $login_logo = 'cranprep_logo_small.png' ) {
		parent::__construct();

		$this->login_bg_color = $color;
		$this->login_bg_image = $bg_image;
		$this->login_logo     = $login_logo;

		add_action( 'login_head', array( $this, 'custom_login_logo' ) );
	}
}
