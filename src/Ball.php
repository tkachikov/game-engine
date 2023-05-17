<?php
declare(strict_types=1);

namespace App;

use App\File;

class Ball
{
    private readonly Redis $redis;

    private array $data;

    public function __construct()
    {
        $this->redis = new Redis();
        $this->data = $this->redis->get('ball') ?? $this->newData();
    }

    public function __destruct()
    {
        $this->redis->set('ball', $this->data);
    }

    /**
     * @param string $key
     *
     * @return mixed
     */
    public function __get(string $key): mixed
    {
        return $this->data[$key] ?? null;
    }

    /**
     * @return array
     */
    public function newData(): array
    {
        return [
            'x' => 50,
            'y' => 50,
            'width' => 100,
            'height' => 100,
            'speed' => 10,
            'timing' => 0.012,
            'lastAction' => microtime(true),
            'color' => [0, 0, 200],
        ];
    }

    /**
     * @return void
     */
    public function run(): void
    {
        $now = microtime(true);
        if ($now - $this->data['lastAction'] >= $this->data['timing']) {
            $this->data['x'] += $this->data['speed'];
            $this->data['y'] += $this->data['speed'];
            if ($this->data['x'] > 950 || $this->data['x'] < 50) {
                $this->data['speed'] *= -1;
            }
            $this->data['lastAction'] = $now;
        }
    }

    /**
     * @param $image
     *
     * @return void
     */
    public function draw($image): void
    {
        $color = imagecolorallocate($image, ...$this->color);
        imagefilledellipse($image, $this->x, $this->y, $this->width, $this->height, $color);
    }
}