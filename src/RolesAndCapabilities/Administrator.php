<?php


	namespace FredBradley\CranleighWPAdmin\RolesAndCapabilities;


	class Administrator extends BaseCapabilities
	{
		private $postTypesToAllow = [
			'cranleighmatters', 'faqs', 'headblogpost'
		];

		public function handle(): void
		{
			$role = get_role("administrator");

			try {
				$this->givePermissionsToPostTypes($this->postTypesToAllow, $role);
			} catch (\TypeError $exception) {
				error_log($exception->getMessage());
//				wp_die($exception->getMessage());
			}
		}

		private function givePermissionsToPostTypes(array $postTypes, \WP_Role $role): void
		{
			foreach ($postTypes as $postType) {
				foreach ($this->create_post_type_permissions($postType) as $cap => $true):
					$role->add_cap($cap);
				endforeach;
			}
		}

	}
