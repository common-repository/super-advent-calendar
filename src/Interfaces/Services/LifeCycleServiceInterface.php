<?php
/**
 * Life cycle service interface.
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
 * Life cycle service interface.
 *
 * @since 1.0.0
 */
interface LifeCycleServiceInterface extends ServiceInterface
{
	public static function uninstall();
}
