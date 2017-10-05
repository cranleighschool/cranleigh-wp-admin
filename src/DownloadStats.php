<?php
/**
 * Created by PhpStorm.
 * User: fredbradley
 * Date: 05/10/2017
 * Time: 11:43
 */

namespace FredBradley\CranleighWPAdmin;

class DownloadStats {

	public function __construct() {
		add_action( 'wp_dashboard_setup', [ $this, 'add_widget' ], 109999 );
	}

	public function add_widget() {
		if (is_plugin_active('download-monitor/download-monitor.php')) {

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
			return '<span style="color:red;">-'.$difference.'</span>';
		}
	}

	public function cs_show_dlm_download_stats_widget() {
		global $wpdb;
		$month = $wpdb->get_row("SELECT MONTHNAME(CURRENT_DATE - INTERVAL 1 MONTH) as curr_month, MONTHNAME(CURRENT_DATE - INTERVAL 2 MONTH) as prev_month");



		$downloads = $wpdb->get_results("SELECT download_id,sum(case when (MONTH(last_month.download_date) = MONTH(CURRENT_DATE - INTERVAL 1 MONTH) AND last_month.download_status='completed' ) then 1 else 0 end) as curr_month,sum(case when (MONTH(last_month.download_date) = MONTH(CURRENT_DATE - INTERVAL 2 MONTH) AND last_month.download_status='completed' ) then 1 else 0 end) as prev_month from {$wpdb->prefix}download_log as last_month group by download_id");
		echo '<p><strong>Showing all download logs for '.$month->curr_month.':</strong></p>';
		echo '<table class="table">';
		echo '<thead style="font-weight: bolder">';
		echo '<td>Item</td>';
		echo '<td>'.$month->curr_month.'</td>';
		echo '<td>'.$month->prev_month.'</td>';
		echo '<td>Diff</td>';
		echo '</thead>';
		$total = [
			"curr_month" => 0,
			"prev_month" => 0
		];
		foreach ($downloads as $download):
			$post = get_post($download->download_id);
			echo '<tr>';
			echo '<td><a href="'.get_edit_post_link($download->download_id).'">'.$post->post_title.'</a></td>';
			echo '<td style="text-align: center"><code>'.$download->curr_month.'</code></td>';
			echo '<td style="text-align: center"><code>'.$download->prev_month.'</code></td>';
			echo '<td style="text-align: center"><code>'.$this->getDifference($download->curr_month, $download->prev_month, true).'</code></td>';
			echo '</tr>';
			$total['curr_month'] = $total['curr_month'] + $download->curr_month;
			$total['prev_month'] = $total['prev_month'] + $download->prev_month;
		endforeach;
		echo '<tfoot style="font-style:italic;">';
		echo '<td><strong>Total Downloads</strong></td>';
		echo '<td style="text-align: center"><code>'.$total['curr_month'].'</code></td>';
		echo '<td style="text-align: center"><code>'.$total['prev_month'].'</code></td>';
		echo '<td style="text-align: center"><code>'.$this->getDifference($total['curr_month'], $total['prev_month'], true).'</code></td>';
		echo '</tfoot>';
		echo '</table>';

	}
}
