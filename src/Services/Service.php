<?php
/**
 * Register base service.
 *
 * @package Super_Advent_Calendar
 * @author  Verdant Studio
 * @since   1.0.0
 */

namespace SuperAdventCalendar\Services;

/**
 * Exit when accessed directly.
 */
if ( ! defined( 'ABSPATH' )) {
	exit;
}

use SuperAdventCalendar\Interfaces\Services\ServiceInterface;

/**
 * Register base service.
 */
class Service implements ServiceInterface
{
	/**
	 * Register the service.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function register()
	{
	}

	/**
	 * Called when all services are registered.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function boot()
	{
	}
}
