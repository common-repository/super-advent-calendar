<?php
/**
 * Register life cycle service.
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

use SuperAdventCalendar\Interfaces\Services\LifeCycleServiceInterface;

/**
 * Register life cycle service.
 *
 * @since 1.0.0
 */
class LifeCycleService extends Service implements LifeCycleServiceInterface
{
	/**
	 * @inheritDoc
	 */
	public function register()
	{
		register_uninstall_hook(
			SUPER_ADVENT_CALENDAR_FILE,
			array( __CLASS__, 'uninstall' )
		);
	}

	/**
	 * Plugin uninstall callback.
	 *
	 * @since 1.0.0
	 *
	 * @return void;
	 */
	public static function uninstall()
	{
		vs_sac_fs()->add_action( 'after_uninstall', 'vs_sac_fs_uninstall_cleanup' );
	}
}
