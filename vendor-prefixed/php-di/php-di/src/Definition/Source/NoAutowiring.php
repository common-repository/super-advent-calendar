<?php
/**
 * @license MIT
 *
 * Modified by verdantstudio on 31-October-2024 using {@see https://github.com/BrianHenryIE/strauss}.
 */

declare(strict_types=1);

namespace SuperAdventCalendar\Vendor_Prefixed\DI\Definition\Source;

use SuperAdventCalendar\Vendor_Prefixed\DI\Definition\Exception\InvalidDefinition;
use SuperAdventCalendar\Vendor_Prefixed\DI\Definition\ObjectDefinition;

/**
 * Implementation used when autowiring is completely disabled.
 *
 * @author Matthieu Napoli <matthieu@mnapoli.fr>
 */
class NoAutowiring implements Autowiring
{
    public function autowire(string $name, ObjectDefinition $definition = null)
    {
        throw new InvalidDefinition(sprintf(
            'Cannot autowire entry "%s" because autowiring is disabled',
            $name
        ));
    }
}
