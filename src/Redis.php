<?php
declare(strict_types=1);

namespace App;

use Predis\Autoloader;
use Predis\Client;

class Redis
{
    private const PREFIX = 'game_';

    private readonly Client $client;

    public function __construct()
    {
        Autoloader::register();
        $this->client = new Client();
    }

    /**
     * @param string $key
     * @param mixed  $value
     *
     * @return void
     */
    public function set(string $key, mixed $value): void
    {
        $this->client->set($this::PREFIX.$key, json_encode($value));
    }

    /**
     * @param string $key
     *
     * @return mixed
     */
    public function get(string $key): mixed
    {
        return json_decode($this->client->get($this::PREFIX.$key) ?? '', true);
    }
}