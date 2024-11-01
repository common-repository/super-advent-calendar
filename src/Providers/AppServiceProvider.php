<?php
/**
 * App service provider (registers general plugins functionality).
 *
 * @package Super_Advent_Calendar
 * @author  Verdant Studio
 * @since   1.0.0
 */

namespace SuperAdventCalendar\Providers;

/**
 * Exit when accessed directly.
 */
if ( ! defined( 'ABSPATH' )) {
	exit;
}

use SuperAdventCalendar\Interfaces\Controllers\ApiControllerInterface;
use SuperAdventCalendar\Interfaces\Providers\AppServiceProviderInterface;
use SuperAdventCalendar\Interfaces\Services\ResourceServiceInterface;
use SuperAdventCalendar\Interfaces\Services\LifeCycleServiceInterface;

/**
 * App service provider (registers general plugins functionality).
 *
 * @since 1.0.0
 */
class AppServiceProvider extends ServiceProvider implements AppServiceProviderInterface
{
	public function __construct(
		ApiControllerInterface $api,
		LifeCycleServiceInterface $life_cycle_service,
		ResourceServiceInterface $resource_service
	) {
		$this->services = array(
			'api'        => $api,
			'life_cycle' => $life_cycle_service,
			'resource'   => $resource_service,
		);

		$this->register_hooks();
	}

	protected function register_hooks() {
		vs_sac_fs()->add_filter( 'connect_message_on_update', array( $this, 'vs_sac_fs_connect_message_update' ), 10, 6 );
		vs_sac_fs()->add_filter( 'connect_message', array( $this, 'vs_sac_fs_connect_message_update' ), 10, 6 );
	}

	/**
	 * Customize the Freemius opt-in message.
	 *
	 * @since 1.0.0
	 *
	 * @return string
	 */
	public function vs_sac_fs_connect_message_update(
		$message,
		$user_first_name,
		$plugin_title,
		$user_login,
		$site_link,
		$freemius_link
	) {
		return sprintf(
			/* translators: %2$s: Super Advent Calendar */
			__( 'Please help us improve the plugin by securely sharing some basic WordPress environment info. If you skip this, that\'s okay! %2$s will still work just fine.', 'super-advent-calendar' ),
			$user_first_name,
			$plugin_title,
			$user_login,
			$site_link,
			$freemius_link
		);
	}
}
