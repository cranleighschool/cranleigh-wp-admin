<?php


	namespace FredBradley\CranleighWPAdmin\RolesAndCapabilities;


	class Personnel extends BaseCapabilities
	{

		public function handle(): void
		{
			remove_role('personnel');
			add_role('personnel', "Personnel Editor", array_merge(
				$this->create_post_type_permissions("staff"),
				$this->create_taxonomy_permissions("staff_cats"),
				$this->create_post_type_permissions("vacancy"),
				$this->create_taxonomy_permissions("job_type"),
				$this->generic_permissions()
			));
		}

	}
