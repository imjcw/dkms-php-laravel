<?php

namespace Lucky\Dkms\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static string encrypt(string $keyId, string $val)
 * @method static string decrypt(string $keyId, string $val)
 * @method static boolean isValidEncryptVal(string $val)
 * @throws \RuntimeException|\Exception
 */
class Dkms extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    public static function getFacadeAccessor()
    {
        return "dkms";
    }
}
