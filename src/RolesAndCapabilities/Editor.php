<?php


	namespace FredBradley\CranleighWPAdmin\RolesAndCapabilities;


	class Editor extends BaseCapabilities {

		public function handle(): void {
			$editor = get_role( "editor" );
			try {
				$this->givePermissionsToPostTypes( [ 'faqs', 'vacancy' ], $editor );
			} catch ( \TypeError $exception ) {
				error_log( $exception->getMessage() );
//				wp_die($exception->getMessage());
			}
		}

		private function givePermissionsToPostTypes( array $postTypes, $role ): void {
			if ( $role instanceof \WP_Role ) {
				foreach ( $postTypes as $postType ) {
					foreach ( $this->create_post_type_permissions( $postType ) as $cap => $true ):
						$role->add_cap( $cap );
					endforeach;
				}
			}
		}

	}
