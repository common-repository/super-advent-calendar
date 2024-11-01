<?php
/**
 * PHP DI.
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

use SuperAdventCalendar\Controllers\ApiController;
use SuperAdventCalendar\Interfaces\Controllers\ApiControllerInterface;
use SuperAdventCalendar\Interfaces\Providers\AppServiceProviderInterface;
use SuperAdventCalendar\Interfaces\Services\LifeCycleServiceInterface;
use SuperAdventCalendar\Interfaces\Services\ResourceServiceInterface;
use SuperAdventCalendar\Providers\AppServiceProvider;
use SuperAdventCalendar\Services\LifeCycleService;
use SuperAdventCalendar\Services\ResourceService;

return array(
	// Controllers.
	ApiControllerInterface::class      => SuperAdventCalendar\Vendor_Prefixed\DI\autowire( ApiController::class ),

	// Providers.
	AppServiceProviderInterface::class => SuperAdventCalendar\Vendor_Prefixed\DI\autowire( AppServiceProvider::class ),

	// Services.
	LifeCycleServiceInterface::class   => SuperAdventCalendar\Vendor_Prefixed\DI\autowire( LifeCycleService::class ),
	ResourceServiceInterface::class    => SuperAdventCalendar\Vendor_Prefixed\DI\autowire( ResourceService::class ),
);
