<?php


	namespace FredBradley\CranleighWPAdmin\RolesAndCapabilities;


	/**
	 * Class BaseCapabilities
	 *
	 * @package FredBradley\CranleighWPAdmin\RolesAndCapabilities
	 */
	abstract class BaseCapabilities implements CapabilitiesInterface
	{

		public static function register() {
			$instance = new static();
			add_action( 'init', array($instance, 'handle'));
		}
		/**
		 * @return array
		 */
		protected function generic_permissions(): array
		{
			return [
				"read"         => true,
				"upload_files" => true
				//	"manage_categories" => true
			];
		}

		/**
		 * @param string $cap
		 *
		 * @return array
		 */
		protected function create_post_type_permissions(string $cap): array
		{

			return [
				"publish_" . $cap       => true,
				"edit_" . $cap          => true,
				"edit_others_" . $cap   => true,
				"delete_" . $cap        => true,
				"delete_others_" . $cap => true,
				'delete_others_' . $cap => true,
				'read_private_' . $cap  => true,
				'edit_' . $cap          => true,
				'delete_' . $cap        => true,
				'read_' . $cap          => true,
			];

		}

		/**
		 * @param string $cap
		 *
		 * @return array
		 */
		protected function create_taxonomy_permissions(string $cap): array
		{
			return [
				'edit_' . $cap   => true,
				'manage_' . $cap => true,
				'delete_' . $cap => true,
				'assign_' . $cap => true
			];
		}
	}
