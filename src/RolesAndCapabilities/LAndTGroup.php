<?php


	namespace FredBradley\CranleighWPAdmin\RolesAndCapabilities;


	class LAndTGroup extends BaseCapabilities
	{

		public function handle(): void
		{
			remove_role('landtgroup');
			add_role(
				'landtgroup',
				'Learning & Teaching Group',
				array_merge(
					$this->create_post_type_permissions("landtblog"),
					$this->generic_permissions()
				)
			);
		}

	}
