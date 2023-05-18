<?php
declare(strict_types=1);

namespace App;

class Player
{
    private readonly Redis $redis;

    private array $data;

    public function __construct(
        private readonly string $id,
    ) {
        $this->redis = new Redis();
        $this->data = $this->redis->get('player-'.$this->id) ?? $this->newData();
    }

    public function __destruct()
    {
        $this->redis->set('player-'.$this->id, $this->data);
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
            'color' => $this->getColor(),
        ];
    }

    /**
     * @return array
     */
    public function getColor(): array
    {
        return [rand(0, 255), rand(0, 255), rand(0, 255)];
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

    /**
     * @param string $id
     *
     * @return void
     */
    public static function setPlayers(string $id): void
    {
        $redis = new Redis();
        $players = self::getPlayers();
        $players[$id] = true;
        $redis->set('players', $players);
    }

    /**
     * @return array
     */
    public static function getPlayers(): array
    {
        return (new Redis())->get('players') ?? [];
    }
}