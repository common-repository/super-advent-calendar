<?php
/**
 * @license MIT
 *
 * Modified by verdantstudio on 31-October-2024 using {@see https://github.com/BrianHenryIE/strauss}.
 */

namespace SuperAdventCalendar\Vendor_Prefixed\Laravel\SerializableClosure\Exceptions;

use Exception;

class InvalidSignatureException extends Exception
{
    /**
     * Create a new exception instance.
     *
     * @param  string  $message
     * @return void
     */
    public function __construct($message = 'Your serialized closure might have been modified or it\'s unsafe to be unserialized.')
    {
        parent::__construct($message);
    }
}
