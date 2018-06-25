<?php
/**
 * Created by PhpStorm.
 * User: fredbradley
 * Date: 05/10/2017
 * Time: 11:43
 */

namespace FredBradley\CranleighWPAdmin;

/**
 * Class DownloadStats
 *
 * @package FredBradley\CranleighWPAdmin
 */
class DownloadStats {

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
			if ( is_plugin_active( 'download-monitor/download-monitor.php' ) ) {

				add_meta_box(
					'cs_dlm_download_stats',
					"Last Month's Download Stats",
					[ $this, 'cs_show_dlm_download_stats_widget' ],
					'dashboard',
					'side',
					'high'
				);

			}
		}
	}

	/**
	 * Function: getDifference
	 *
	 * This works out how the difference between this month and last month.
	 * (Yes I developed this function in September, and didn't change the variable names!)
	 *
	 * @param int  $september
	 * @param int  $august
	 * @param bool $format
	 *
	 * @return int|string
	 */
	private function getDifference(int $september, int $august, $format = false) {

		$difference = $september - $august;

		if ($format===false) {
			return $difference;
		}

		if ($format==="%") {
			$difference = $difference."%";
		}

		if ($difference > 0) {
			return '<span style="color:green;">+'.$difference.'</span>';
		} elseif ($difference == 0) {
			return '<span>'.$difference.'</span>';
		} else {
			return '<span style="color:red;">'.$difference.'</span>';
		}
	}

	/**
	 * Function: cs_show_dlm_download_stats_widget
	 *
	 * This is the function that actually display content on the dashboard widget.
	 * For now, everything is written all in this function (except the `getDifference` function)
	 * For clarity I could separate this out later.
	 */
	public function cs_show_dlm_download_stats_widget() {
		global $wpdb;

		if (!get_transient('cs_download_stats_widget')) {
			ob_start();

			// Get the names of the month from SQL rather than PHP as that's what we'll be using in a query further down.
			$month = $wpdb->get_row( "SELECT MONTHNAME(CURRENT_DATE - INTERVAL 1 MONTH) as curr_month, MONTHNAME(CURRENT_DATE - INTERVAL 2 MONTH) as prev_month" );

			// Do the SQL query on Wordpress database.
			$downloads = $wpdb->get_results( "
				SELECT 
					download_id
					,sum(case when (MONTH(download_date) = MONTH(CURRENT_DATE - INTERVAL 1 MONTH) AND download_status='completed' ) then 1 else 0 end) as curr_month
					,sum(case when (MONTH(download_date) = MONTH(CURRENT_DATE - INTERVAL 2 MONTH) AND download_status='completed' ) then 1 else 0 end) as prev_month
				FROM {$wpdb->prefix}download_log
				GROUP BY download_id
				ORDER BY curr_month DESC
			" );

			echo '<p><strong>Showing all download logs for ' . $month->curr_month . ':</strong></p>';
			echo '<table class="table" style="display:block;max-height:375px;overflow-y: scroll;">';
			echo '<thead style="font-weight: bolder">';
			echo '<td>Item</td>';
			echo '<td style="text-align: center">' . $month->curr_month . '</td>';
			//		echo '<td style="text-align: center">'.$month->prev_month.'</td>';
			echo '<td style="text-align:center">Diff (' . substr( $month->prev_month, 0, 3 ) . ')</td>';
			echo '</thead>';

			// Set current totals to Zero!
			$total = [
				"curr_month" => 0,
				"prev_month" => 0
			];

			foreach ( $downloads as $download ):
				$post = get_post( $download->download_id );
				if (!is_object($post)) {
					error_log("Could not find Post for Download: ".$download->download_id.", skipping...");
					continue;
				}
				echo '<tr>';
				echo '<td>';
				echo '<a href="' . get_edit_post_link( $download->download_id ) . '">';
				echo $post->post_title;
				echo '</a>';
				echo '</td>';
				echo '<td style="text-align: center"><code>' . $download->curr_month . '</code></td>';
				//	echo '<td style="text-align: center"><code>'.$download->prev_month.'</code></td>';
				echo '<td style="text-align: center"><code>' . $this->getDifference( $download->curr_month,
						$download->prev_month, true ) . '</code></td>';
				echo '</tr>';
				$total[ 'curr_month' ] = $total[ 'curr_month' ] + $download->curr_month;
				$total[ 'prev_month' ] = $total[ 'prev_month' ] + $download->prev_month;
			endforeach;
			echo '</table>';
			echo '<hr />';
			echo '<table>';
			echo '<thead style="font-weight: bolder">';
			echo '<td></td>';
			echo '<td>' . $month->curr_month . '</td>';
			echo '<td>' . $month->prev_month . '</td>';
			echo '<td>Diff</td>';
			echo '</thead>';
			echo '<tfoot style="font-style:italic;">';
			echo '<td><strong>Total Downloads</strong></td>';
			echo '<td style="text-align: center"><code>' . $total[ 'curr_month' ] . '</code></td>';
			echo '<td style="text-align: center"><code>' . $total[ 'prev_month' ] . '</code></td>';
			echo '<td style="text-align: center"><code>' . $this->getDifference( $total[ 'curr_month' ],
					$total[ 'prev_month' ], true ) . '</code></td>';
			echo '</tfoot>';
			echo '</table>';

			$content = ob_get_contents();
			ob_end_clean();
			set_transient('cs_download_stats_widget', $content, 2 * WEEK_IN_SECONDS);
			echo $content;
		} else {
			echo get_transient('cs_download_stats_widget');
		}

	}
}
