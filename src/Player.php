<?php
declare(strict_types=1);

namespace App;

class Player
{
    private readonly Redis $redis;

    private array $data;

    public function __construct()
    {
        $this->redis = new Redis();
        $this->data = $this->redis->get('player') ?? $this->newData();
    }

    public function __destruct()
    {
        $this->redis->set('player', $this->data);
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
            'x' => 500,
            'y' => 500,
            'width' => 100,
            'height' => 100,
            'speed' => 50,
            'color' => [0, 200, 0],
        ];
    }

    /**
     * @param int $x
     * @param int $y
     *
     * @return void
     */
    public function move(int $x = 0, int $y = 0): void
    {
        $this->data['x'] += $x * $this->speed;
        $this->data['y'] += $y * $this->speed;
    }

    /**
     * @return void
     */
    public function run(): void
    {
        //
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