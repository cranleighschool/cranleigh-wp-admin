<?php
/**
 * Created by PhpStorm.
 * User: fredbradley
 * Date: 10/10/2017
 * Time: 09:24
 */

namespace FredBradley\CranleighWPAdmin;


class CountPostsByMonth {

	/**
	 * DownloadStats constructor.
	 */
	public function __construct() {
		add_action( 'wp_dashboard_setup', [ $this, 'add_widget' ], 109999 );
	}

	/**
	 * Function: add_widget
	 *
	 * This is the function that is called in the constructor.
	 * This in turn calls the `add_meta_box` function IF Download monitor is found as an active plugin
	 */
	public function add_widget() {
		$user = \wp_get_current_user();
		if ( in_array( 'administrator', (array) $user->roles ) ) {
			wp_add_dashboard_widget(
				'cs_count_posts_by_month',
				"News Posts by Month",
				[ $this, 'the_widget' ],
				[ $this, 'configure_widget' ]
			);
		}
	}
	public function configure_widget( $widget_id ) {

		// Get widget options
		$cs_wp_admin_widget_options = $this->howManyMonthsCountBack();

		// Update widget options
		if ( 'POST' == $_SERVER['REQUEST_METHOD'] && isset($_POST['cs_wp_admin_count_post_hidden']) ) {
			update_option( 'cs_wp_admin_monthly_post_count_back', $_POST['cs_wp_admin_count_post_monthsback'] );
			delete_transient('cs_fb_timed_archives_count');
		}
?>
		<p>
			<label for="cs_wp_admin_post_count"><?php _e('How Many Months Back to you want to search', 'cranleigh-2016'); ?></label>
			<input class="widefat" id="cs_wp_admin_post_count" name="cs_wp_admin_count_post_monthsback" type="number" value="<?php if( isset($cs_wp_admin_widget_options) ) echo $cs_wp_admin_widget_options; ?>" />
		</p>

		<input name="cs_wp_admin_count_post_hidden" type="hidden" value="1" />
		<?php
	}

	public function howManyMonthsCountBack() {
		if ( !$monthsback = get_option( 'cs_wp_admin_monthly_post_count_back' ) )
			$monthsback = 12;

		return $monthsback;
	}
	public function the_widget() {
		global $wpdb;

		$result = $this->fb_timed_archives_count($this->howManyMonthsCountBack());
		echo "<p>A table showing news posts per month for the last {$this->howManyMonthsCountBack()} months.</p>";
		echo "<table cellpadding='5' style='width:100%;border-collapse: collapse;'>";
		echo "<thead style='border-bottom: double 2px black'>";
		echo "<th style='text-align: left'>Month</th>";
		echo "<th># Posts</th>";
		echo "</thead>";
		foreach ($result as $year):

			foreach ($year as $month => $count):
				echo "<tr style='border-bottom:thin solid black; background-color: #ffffe0'>";
				echo "<td style='font-weight: bolder'><strong>$month</strong></td>";
				echo "<td style='text-align:center;'>$count</td>";
				echo "</tr>";
			endforeach;

		endforeach;
		echo "</table>";
	}
	/**
	 * Convert Number to Month
	 * -----------------------------------------------------------------------------
	 * See: https://stackoverflow.com/questions/18467669/convert-number-to-month-name-in-php
	 *
	 * @param  int          $number             The month of the year as a number.
	 * @param   int|null    $year               The Year
	 * @return  string                           The month as a word.
	 */

	function get_month_from_number($number, $year=null) {
		if ($year !==null) {
			return date_create_from_format("!m Y", ($number % 12)." ".$year)->format("F 'y");
		}
		return date_create_from_format('!m', $number % 12)->format('F');
	}

	function fb_timed_archives_count($monthsback=6) {
		global $wpdb;
			$month=[];
			$counts=[];
			if (!$month = get_transient('cs_fb_timed_archives_count')) {
				$month = $wpdb->get_results( $wpdb->prepare(
					"SELECT "
					. "MONTH(post_date) AS post_month,"
					. "YEAR(post_date) as post_year,"
					. "count(ID) AS post_count from"
					. " {$wpdb->posts} WHERE post_type = 'post' AND post_status = 'publish'"
					. " AND DATE(post_date) > DATE_SUB(now(), INTERVAL %d MONTH)"
					. " GROUP BY post_year,post_month", $monthsback ) );
				set_transient( 'cs_fb_timed_archives_count', $month, WEEK_IN_SECONDS );
			}

			foreach ($month as $m) {
				$counts[][$this->get_month_from_number($m->post_month, $m->post_year)] = $m->post_count;
			}


		return $counts;
	}

}
