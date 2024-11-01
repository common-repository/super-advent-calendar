<?php
/**
 * Bootstrap providers and containers.
 *
 * @package Super_Advent_Calendar
 * @author  Verdant Studio
 * @since   1.0.0
 */

namespace SuperAdventCalendar;

/**
 * Exit when accessed directly.
 */
if ( ! defined( 'ABSPATH' )) {
	exit;
}

use SuperAdventCalendar\Vendor_Prefixed\DI\ContainerBuilder;
use SuperAdventCalendar\Vendor_Prefixed\Psr\Container\ContainerInterface;
use SuperAdventCalendar\Interfaces\Providers\AppServiceProviderInterface;

require_once __DIR__ . '/helpers.php';

/**
 * Bootstrap providers and containers.
 */
final class Bootstrap
{
	/**
	 * Dependency Injection container.
	 *
	 * @since 1.0.0
	 *
	 * @var ContainerInterface
	 */
	private $container;

	/**
	 * Dependency providers.
	 *
	 * @since 1.0.0
	 *
	 * @var array
	 */
	private $providers;

	/**
	 * Plugin constructor.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		$this->container = $this->build_container();
		$this->providers = $this->get_providers();
		$this->register_providers();
		$this->boot_providers();
	}

	/**
	 * Gets all providers
	 *
	 * @since 1.0.0
	 *
	 * @return array
	 */
	protected function get_providers(): array {
		$providers = array(
			AppServiceProviderInterface::class,
		);
		foreach ( $providers as &$provider ) {
			$provider = $this->container->get( $provider );
		}
		return $providers;
	}

	/**
	 * Registers all providers.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	protected function register_providers(): void {
		foreach ( $this->providers as $provider ) {
			$provider->register();
		}
	}

	/**
	 * Boots all providers.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	protected function boot_providers(): void {
		foreach ( $this->providers as $provider ) {
			$provider->boot();
		}
	}

	/**
	 * Builds the container.
	 *
	 * @since 1.0.0
	 *
	 * @return ContainerInterface
	 */
	protected function build_container(): ContainerInterface {
		$builder = new ContainerBuilder();

		// Use DIRECTORY_SEPARATOR to ensure the path works on both Windows and Unix-like systems
		$config_path = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'php-di.php';

		// Add definitions using the correct path
		$builder->addDefinitions( $config_path );
		$builder->useAnnotations( true );
		$container = $builder->build();
		return $container;
	}
}
