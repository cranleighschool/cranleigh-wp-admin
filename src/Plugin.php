<?php

namespace FredBradley\CranleighWPAdmin;

/**
 * Class Plugin
 *
 * @package FredBradley\CranleighWPAdmin
 */
class Plugin {

	public $plugin_uri;

	/**
	 * Plugin constructor.
	 */
	public function __construct() {

		$this->setPluginUri( plugins_url( '/', dirname( __FILE__ ) ) );

		new PluginUpdateCheck("cranleigh-wp-admin");

	}

	/**
	 * @return mixed
	 */
	public function getPluginUri() {

		return $this->plugin_uri;
	}

	/**
	 * @param mixed $plugin_uri
	 */
	public function setPluginUri( $plugin_uri ) {

		$this->plugin_uri = $plugin_uri;
	}

	/**
	 * @param string|null $image
	 *
	 * @return string
	 */
	public function getPluginImageURI( string $image = null ) {

		if ( $image !== null ) {
			return $this->plugin_uri . "images/" . $image;
		}
	}

	/**
	 * @return \FredBradley\CranleighWPAdmin\RemoveItems
	 */
	public function loadRemoves() {

		return new RemoveItems();
	}

	/**
	 * @return \FredBradley\CranleighWPAdmin\Style
	 */
	public function loadStyle() {

		return new Style();
	}

	/**
	 * @return \FredBradley\CranleighWPAdmin\Notices
	 */
	public function loadNotices() {

		return new Notices();
	}

	/**
	 * @return \FredBradley\CranleighWPAdmin\Footer
	 */
	public function loadFooter() {

		return new Footer();
	}

	/**
	 * @return \FredBradley\CranleighWPAdmin\OnlineUsersWidget
	 */
	public function loadOnlineUserWidget() {

		$load = new LastUserLogin();

		return new OnlineUsersWidget();
	}

	/**
	 * @return \FredBradley\CranleighWPAdmin\SiteSpecific\AbuDhabi|\FredBradley\CranleighWPAdmin\SiteSpecific\OCSociety|\FredBradley\CranleighWPAdmin\SiteSpecific\PrepSchool|\FredBradley\CranleighWPAdmin\SiteSpecific\SeniorSchool|null
	 */
	public function loadSiteSpecific() {

		$url = get_site_url();

		if ( strpos( $url, ".cranleigh.org" ) ) {
			$load = new SiteSpecific\SeniorSchool();
		} elseif ( strpos( $url, ".cranprep.org" ) ) {
			$load = new SiteSpecific\PrepSchool();
		} elseif ( strpos( $url, ".cranleigh.ae" ) ) {
			$load = new SiteSpecific\AbuDhabi();
		} elseif ( strpos( $url, ".ocsociety.org" ) || strpos( $url, "club.org" ) || strpos( $url, "club.com" ) ) {
			$load = new SiteSpecific\OCSociety();
		} else {
			// Default
			$load = null;
		}
		return $load;

	}


}
