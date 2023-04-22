<?php

namespace App\Http\ApiClients;

abstract class ApiClientBase implements WalletApiClientInterface
{
    private static array $instances;

    final private function __construct()
    {
        // singleton
    }

    public static function getInstance(): self
    {
        if (!isset(self::$instances[static::class])) {
            $client = new static();

            $client->init();

            self::$instances[static::class] = $client;
        }

        return self::$instances[static::class];
    }

    abstract protected function init();
}
