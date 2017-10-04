<?php
/**
 * Created by PhpStorm.
 * User: fredbradley
 * Date: 04/10/2017
 * Time: 13:07
 */

namespace FredBradley\CranleighWPAdmin\SiteSpecific;


class AwesomeBookAwards extends Controller {

	public function __construct(string $color="#000000", string $bg_image="https://i.vimeocdn.com/video/657804990.jpg", string $login_logo="cranprep_logo_small.png") {
		parent::__construct();

		$logo= wp_get_attachment_image_src(get_theme_mod('custom_logo'), 'full');
		$login_logo = $logo[0];

		$this->login_bg_color = $color;
		$this->login_bg_image = $bg_image;
		$this->login_logo = $login_logo;

		add_action('login_head', array($this,'custom_login_logo'));
	}

}