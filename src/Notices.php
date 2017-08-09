<?php
namespace FredBradley\CranleighWPAdmin;

class Notices {
	public function __construct() {
		add_action("admin_notices", array($this,"fb_admin_notice"), 999);
		add_action("network_admin_notices", array($this, "fb_admin_notice"), 999);
	}

	public function fb_admin_notice() {
	//	if (current_user_can('administrator')) {
			echo "<div class=\"header_buttons\"><span style=\"position:relative;height:1px;display:block;margin-top:5px;text-align:right\"><code style=\"color:#fff;background-color:rgba(140, 183, 232, 0.7);\">".gethostname().":".dirname(ABSPATH).":".DB_NAME."</code></span></div>";
	//	}

/*
		echo '<div id="fred-error" class="error" style="background:red;color:white;">
						<p style="font-size:18px"><i class="cranfont cranfont-2x cranfont-logo"></i><strong>Warning:</strong> The Cranleigh IT Dept are making changes to the Wordpress Database on Monday 4th January. Changes you make may be overwritten. When this notice is taken down you will be free to make changes again. Anything urgent please contact support on 01483 542019. Or email frb@cranleigh.org.</p>
					</div>';
*/
	}



}
