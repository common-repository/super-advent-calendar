<?php
/**
 * Register service provider.
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

use SuperAdventCalendar\Interfaces\Providers\ServiceProviderInterface;
use SuperAdventCalendar\Interfaces\Services\ServiceInterface;

/**
 * Register service provider.
 *
 * @since 1.0.0
 */
class ServiceProvider implements ServiceProviderInterface
{
	protected $services = array();

	/**
	 * Registers the services.
	 *
	 * @return void
	 */
	public function register(): void {
		foreach ( $this->services as $service ) {
			$service->register();
		}
	}

	/**
	 * Boots the services.
	 *
	 * @return void
	 */
	public function boot(): void {
		foreach ( $this->services as $service ) {
			if ( false === $service instanceof ServiceInterface ) {
				continue;
			}
			$service->boot();
		}
	}
}
