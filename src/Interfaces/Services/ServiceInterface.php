<?php
/**
 * Service interface.
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
 * Service interface.
 *
 * @since 1.0.0
 */
interface ServiceInterface
{
	public function register();
	public function boot();
}
