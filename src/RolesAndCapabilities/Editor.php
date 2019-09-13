<?php


	namespace FredBradley\CranleighWPAdmin\RolesAndCapabilities;


	class Editor extends BaseCapabilities
	{

		public function handle(): void
		{
			$editor = get_role("editor");
			try {
				$this->givePermissionsToPostTypes(['faqs'], $editor);
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
