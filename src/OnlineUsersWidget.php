<?php

namespace FredBradley\CranleighWPAdmin;

use WP_User_Query;

class OnlineUsersWidget {

	public function __construct( int $time_to_keep ) {
		$this->time_to_keep = $time_to_keep;

			// The user has the "author" role
			add_action( 'wp_dashboard_setup', [ $this, 'add_widget' ], 109999 );
			add_action( 'wp_network_dashboard_setup', [ $this, 'cs_add_network_dashboard_widgets' ] );

	}

	public function add_widget() {
		$user = \wp_get_current_user();
		if ( in_array( 'administrator', (array) $user->roles ) ) {
			add_meta_box(
				'cs_users_online_widget',
				'Online Users',
				[ $this, 'cs_show_users_online_widget' ],
				'dashboard',
				'side',
				'high'
			);
		}

	}

	public function cs_add_network_dashboard_widgets() {
		$user = \wp_get_current_user();
		if ( in_array( 'administrator', (array) $user->roles ) ) {
			wp_add_dashboard_widget(
				'cs_users_online_widget',
				'Online Users Across the Network',
				[ $this, 'cs_show_users_online_widget' ]
			);
		}
	}

	public function cs_show_users_online_widget() {

		$logged_in_users = get_site_transient( 'CS_online_status' );
		if ( ! empty( $logged_in_users ) ) :
			echo '<p>The following users have been logged on within the last ' . $this->time_to_keep . ' minutes:</p>';
			echo '<ul>';
			foreach ( $logged_in_users as $key => $value ) :
				$user = get_user_by( 'id', $key );

				echo '<li>' . $user->display_name . ' (<a href="' . get_edit_user_link( $user->ID ) . '">' . $user->user_email . '</a>) (' . date(
					'g:i:sa',
					$value
				) . ')</li>';
			endforeach;
			echo '</ul>';

			$user_args = [
				'meta_key'     => 'wp-last-login',
				'meta_compare' => '>',
				'meta_value'   => ( current_time( 'timestamp' ) - ( 5 * WEEK_IN_SECONDS ) ),
				'count_total'  => true,
				'number'       => 1000,
				'fields'       => [ 'ID', 'user_login', 'display_name', 'user_email' ],
				'orderby'      => 'meta_value',
				'order'        => 'DESC',
			];
			if ( current_user_can( 'administrator' ) ) :
				echo '<hr />';

				$users = new WP_User_Query( $user_args );
				if ( ! empty( $users->results ) ) :
					echo '<table><tbody>';
					foreach ( $users->results as $user ) :
						$last_login_timstamp = get_user_meta( $user->ID, 'wp-last-login', true );

						$pretty_date = date( 'D jS M Y g:i:sa', $last_login_timstamp );
						$ago_date    = $this->ago( $last_login_timstamp );
						echo '<tr>';
						echo '<td><a href="' . get_edit_user_link( $user->ID ) . '">' . $user->user_login . '</a></td>';
						$user_info = get_userdata( $user->ID );
						echo '<td>';
						if ( empty( $user_info->first_name ) || empty( $user_info->last_name ) ) :
							echo $user->display_name;
						else :
							echo $user_info->first_name . ' ' . $user_info->last_name;
						endif;
						echo '</td>';
						echo '<td>';
						echo '<span title="' . $pretty_date . '">' . $ago_date . '</span>';
						echo '</td>';
						echo '</tr>';
					endforeach;
					echo '</tbody></table>';
				endif;

			endif;

			else :
				echo 'No user is logged in.';
		endif;

	}

	/**
	 * @param $time
	 *
	 * @return string
	 */
	private function ago( $time ) {

		$periods = [ 'second', 'minute', 'hour', 'day', 'week', 'month', 'year', 'decade' ];
		$lengths = [ '60', '60', '24', '7', '4.35', '12', '10' ];

		$now        = current_time( 'timestamp' );
		$difference = $now - $time;
		$tense      = 'ago';

		for ( $j = 0; $difference >= $lengths[ $j ] && $j < count( $lengths ) - 1; $j ++ ) {
			$difference /= $lengths[ $j ];
		}

		$difference = round( $difference );

		if ( $difference != 1 ) {
			$periods[ $j ] .= 's';
		}

		return "$difference $periods[$j] ago ";
	}
}
