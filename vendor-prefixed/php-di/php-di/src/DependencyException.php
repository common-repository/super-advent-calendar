<?php
/**
 * @license MIT
 *
 * Modified by verdantstudio on 31-October-2024 using {@see https://github.com/BrianHenryIE/strauss}.
 */

declare(strict_types=1);

namespace SuperAdventCalendar\Vendor_Prefixed\DI;

use SuperAdventCalendar\Vendor_Prefixed\Psr\Container\ContainerExceptionInterface;

/**
 * Exception for the Container.
 */
class DependencyException extends \Exception implements ContainerExceptionInterface
{
}
