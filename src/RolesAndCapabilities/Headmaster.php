<?php


	namespace FredBradley\CranleighWPAdmin\RolesAndCapabilities;


	class Headmaster extends BaseCapabilities
	{

		public function handle(): void
		{
			remove_role('headmaster');
			add_role(
				'headmaster',
				'Headmaster',
				array_merge(
					$this->create_post_type_permissions("headblogpost"),
					$this->generic_permissions()
				)
			);
		}

	}
