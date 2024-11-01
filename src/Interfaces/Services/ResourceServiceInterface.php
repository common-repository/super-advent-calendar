<?php
/**
 * Resource service interface.
 *
 * @package Super_Advent_Calendar
 * @author  Verdant Studio
 * @since   1.0.0
 */

namespace SuperAdventCalendar\Interfaces\Services;

/**
 * Exit when accessed directly.
 */
if ( ! defined( 'ABSPATH' )) {
	exit;
}

/**
 * Resource service interface.
 *
 * @since 1.0.0
 */
interface ResourceServiceInterface extends ServiceInterface
{
	public function render_advent_calendar_day_block( $block_attributes );
	public function register_block_scripts();
}
