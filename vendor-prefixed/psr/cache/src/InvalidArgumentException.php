<?php
/**
 * @license MIT
 *
 * Modified by verdantstudio on 31-October-2024 using {@see https://github.com/BrianHenryIE/strauss}.
 */

namespace SuperAdventCalendar\Vendor_Prefixed\Psr\Cache;

/**
 * Exception interface for invalid cache arguments.
 *
 * Any time an invalid argument is passed into a method it must throw an
 * exception class which implements SuperAdventCalendar\Vendor_Prefixed\Psr\Cache\InvalidArgumentException.
 */
interface InvalidArgumentException extends CacheException
{
}
