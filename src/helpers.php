<?php
/**
 * Plugin helpers.
 *
 * @package Super_Advent_Calendar
 * @author  Verdant Studio
 * @since   1.0.0
 */

/**
 * Exit when accessed directly.
 */
if ( ! defined( 'ABSPATH' )) {
	exit;
}

/**
 * Add prefix for the given string.
 *
 * @param string $name - plugin name.
 *
 * @package Super_Advent_Calendar
 * @author  Verdant Studio
 * @since   1.0.0
 */
if ( ! function_exists( 'super_advent_calendar_prefix' )) {
	function super_advent_calendar_prefix($name )
	{
		return 'super-advent-calendar-' . $name;
	}
}

/**
 * Enforce correct plugin path.
 *
 * @param  string $path
 *
 * @package Super_Advent_Calendar
 * @author  Verdant Studio
 * @since   1.0.0
 */
if ( ! function_exists( 'super_advent_calendar_url' )) {
	function super_advent_calendar_url($path )
	{
		return SUPER_ADVENT_CALENDAR_PLUGIN_URL . $path;
	}
}

/**
 * Create asset url.
 *
 * @param   string $path
 *
 * @package Super_Advent_Calendar
 * @author  Verdant Studio
 * @since   1.0.0
 */
if ( ! function_exists( 'super_advent_calendar_asset_url' )) {
	function super_advent_calendar_asset_url($path )
	{
		return super_advent_calendar_url( 'dist/' . $path );
	}
}
