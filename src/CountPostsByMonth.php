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

			add_meta_box(
				'cs_count_posts_by_month',
				"Posts by Month",
				[ $this, 'the_widget' ],
				'dashboard',
				'side',
				'high'
			);


	}
	private function count_posts_from_month($year, $month) {
		global $wpdb;

		$query = "SELECT MONTH(post_date) AS post_month, YEAR(post_date) as post_year, count(ID) AS post_count from"
				. " {$wpdb->posts} WHERE post_type = 'post' AND post_status = 'publish' AND YEAR(post_date) = %d"
				. " GROUP BY post_month";

		return $wpdb->get_results( $wpdb->prepare( $query, $year));
	}
	public function the_widget() {
		global $wpdb;
		$result = $this->timed_archives_count();
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

	/**
	 * Generate Dated Archive Post Count
	 * -----------------------------------------------------------------------------
	 * Generate the initial count of posts by year and month, and save it under the
	 * given options key. Generating this can be resource intensive, so it makes
	 * sense to store this as a variable.
	 *
	 * See: https://wordpress.stackexchange.com/questions/60859/post-count-per-day-month-year-since-blog-began
	 *
	 * @param   string      $option_name        Options key for the post count.
	 * @return  array       $counts             Returned counts for the
	 */

	function timed_archives_count() {
		global $wpdb;

		/* Get the year of the first post:
		 * -------------------------------------------------------------------------
		 * 1. Get 1 post in ascending order. This is the first post on the blog.
		 * 2. Extract the date of the post.
		 * 3. Parse that down to the year alone. */
		$from_date = preg_replace('/-.*/', '', get_posts(array(
			'posts_per_page' => 1,
			'order' => 'ASC'
		))[0]->post_date);

		for ($i = date('Y'); $i >= $from_date; $i--) {
			$counts[$i] = array();

			$month = $wpdb->get_results($wpdb->prepare(
				"SELECT MONTH(post_date) AS post_month, count(ID) AS post_count from"
				. " {$wpdb->posts} WHERE post_type = 'post' AND post_status = 'publish' AND YEAR(post_date) = %d"
				. " GROUP BY post_month;",
				$i
			), OBJECT_K);

			foreach ($month as $m) {
				$counts[$i][$this->get_month_from_number($m->post_month, $i)] = $m->post_count;
			}
		}

		return $counts;
	}
}