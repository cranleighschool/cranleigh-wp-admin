<?php

namespace FredBradley\CranleighWPAdmin;

use Puc_v4_Factory;

class PluginUpdateCheck

{
	public function __construct(string $plugin_name, string $user="cranleighschool")
	{
		$this->update_check($plugin_name, $user);
	}

	/**
	 * @param string $plugin_name
	 */
	private function update_check(string $plugin_name, string $user) {
		$updateChecker = Puc_v4_Factory::buildUpdateChecker(
			'https://github.com/'.$user.'/'.$plugin_name.'/',
			dirname(dirname(__FILE__)) . '/'.$plugin_name.'.php',
			$plugin_name
		);

		/* Add in option form for setting auth token*/
		//$updateChecker->setAuthentication(GITHUB_AUTH_TOKEN);

		$updateChecker->setBranch('develop');
	}
}
