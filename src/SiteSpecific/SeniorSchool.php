<?php

namespace FredBradley\CranleighWPAdmin\SiteSpecific;

class SeniorSchool extends Controller {

	public function __construct( string $color = '#0c223f', string $bg_image = 'seniorcrest.png', string $login_logo = 'cranleigh_logo_small.png' ) {
		parent::__construct();

		$this->login_bg_color = $color;
		$this->login_bg_image = $bg_image;
		$this->login_logo     = $login_logo;

		add_action( 'login_head', array( $this, 'custom_login_logo' ) );
	}
}
