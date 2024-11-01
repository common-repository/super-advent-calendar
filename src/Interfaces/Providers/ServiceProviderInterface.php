<?php
/**
 * Service provider interface.
 *
 * @package Super_Advent_Calendar
 * @author  Verdant Studio
 * @since   1.0.0
 */

namespace SuperAdventCalendar\Interfaces\Providers;

/**
 * Exit when accessed directly.
 */
if ( ! defined( 'ABSPATH' )) {
	exit;
}

/**
 * Service provider interface.
 *
 * @since 1.0.0
 */
interface ServiceProviderInterface
{
	/**
	 * Register provider.
	 *
	 * @since 1.0.0
	 */
	public function register();
}
