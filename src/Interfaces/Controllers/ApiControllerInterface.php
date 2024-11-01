<?php
/**
 * Api controller interface.
 *
 * @package Super_Advent_Calendar
 * @author  Verdant Studio
 * @since   1.3.0
 */

namespace SuperAdventCalendar\Interfaces\Controllers;

/**
 * Exit when accessed directly.
 */
if ( ! defined( 'ABSPATH' )) {
	exit;
}

/**
 * Api controller interface.
 *
 * @since 1.3.0
 */
interface ApiControllerInterface
{
	public function register();
	public function register_routes();
	public function get_day_block_settings( $request );
	public function get_options_permission( \WP_REST_Request $request );
}
