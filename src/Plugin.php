<?php

	namespace FredBradley\CranleighWPAdmin;

	use FredBradley\CranleighWPAdmin\RolesAndCapabilities\Administrator;
	use FredBradley\CranleighWPAdmin\RolesAndCapabilities\Editor;
	use FredBradley\CranleighWPAdmin\RolesAndCapabilities\Headmaster;
	use FredBradley\CranleighWPAdmin\RolesAndCapabilities\LAndTGroup;
	use FredBradley\CranleighWPAdmin\RolesAndCapabilities\Personnel;

	/**
	 * Class Plugin
	 *
	 * @package FredBradley\CranleighWPAdmin
	 */
	class Plugin
	{

		public $plugin_uri;

		/**
		 * Plugin constructor.
		 */
		public function __construct()
		{

			$this->setPluginUri(plugins_url('/', dirname(__FILE__)));

			add_filter('auto_update_plugin', '__return_false');
			add_filter('auto_update_theme', '__return_false');
		}

		/**
		 * @return mixed
		 */
		public function getPluginUri()
		{

			return $this->plugin_uri;
		}

		/**
		 * @param mixed $plugin_uri
		 */
		public function setPluginUri($plugin_uri)
		{

			$this->plugin_uri = $plugin_uri;
		}

		/**
		 * @param string|null $image
		 *
		 * @return string
		 */
		public function getPluginImageURI(string $image = NULL)
		{
			$http = stripos($image, 'http');
			$https = stripos($image, 'https');

			if ($http !== false || $https !== false) {
				return $image;
			}
			if ($image !== NULL) {
				return $this->plugin_uri . 'images/' . $image;
			}
		}

		/**
		 * @return \FredBradley\CranleighWPAdmin\RemoveItems
		 */
		public function loadRemoves()
		{

			return new RemoveItems();
		}

		/**
		 * @return \FredBradley\CranleighWPAdmin\Style
		 */
		public function loadStyle()
		{

			return new Style();
		}

		/**
		 * @return \FredBradley\CranleighWPAdmin\Notices
		 */
		public function loadNotices()
		{

			return new Notices();
		}

		/**
		 * @return \FredBradley\CranleighWPAdmin\Footer
		 */
		public function loadFooter()
		{

			return new Footer();
		}

		/**
		 * @return \FredBradley\CranleighWPAdmin\OnlineUsersWidget
		 */
		public function loadOnlineUserWidget()
		{

			return new LastUserLogin();

		}

		public function loadChangeUserLoginLabel()
		{
			return new ChangeUserLoginLabel();
		}

		public function loadDownloadStatsWidget()
		{

			return new DownloadStats();

		}

		public function loadPostCountWidget()
		{
			return new CountPostsByMonth();
		}

		public function loadCustomRolesAndCapabilities()
		{
			add_action('jetpack_admin_menu', function () {
				if (!current_user_can('administrator')) {
					remove_menu_page('jetpack');
				}
			});

			Personnel::register();
			Headmaster::register();
			LAndTGroup::register();
			Editor::register();
			Administrator::register();
		}

		/**
		 * @return \FredBradley\CranleighWPAdmin\SiteSpecific\AbuDhabi|\FredBradley\CranleighWPAdmin\SiteSpecific\OCSociety|\FredBradley\CranleighWPAdmin\SiteSpecific\PrepSchool|\FredBradley\CranleighWPAdmin\SiteSpecific\SeniorSchool|null
		 */
		public function loadSiteSpecific()
		{

			$url = get_site_url();

			if (strpos($url, '.cranleigh.org')) {
				$load = new SiteSpecific\SeniorSchool();
			} elseif (strpos($url, '.cranprep.org')) {
				$load = new SiteSpecific\PrepSchool();
			} elseif (strpos($url, '.awesomebookawards.com')) {
				$load = new SiteSpecific\AwesomeBookAwards();
			} elseif (strpos($url, '.cranleigh.ae')) {
				$load = new SiteSpecific\AbuDhabi();
			} elseif (strpos($url, '.ocsociety.org') || strpos($url, 'club.org') || strpos($url, 'club.com')) {
				$load = new SiteSpecific\OCSociety();
			} elseif (strpos($url, '.cranleighactivities.org')) {
				$load = new SiteSpecific\Activities();
			} else {
				// Default
				$load = NULL;
			}

			return $load;

		}

	}
