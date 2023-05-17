<?php
declare(strict_types=1);

namespace App;

class Action
{
    private readonly Redis $redis;

    private array $data;

    public function __construct()
    {
        $this->redis = new Redis();
        $this->data = $this->redis->get('actions') ?? [];
    }

    public function __destruct()
    {
        $this->redis->set('actions', $this->data);
    }

    /**
     * @param string $code
     * @param int    $x
     * @param int    $y
     *
     * @return void
     */
    public function add(string $code, int $x, int $y): void
    {
        $this->data[] = [
            'code' => $code,
            'x' => $x,
            'y' => $y,
        ];
    }

    /**
     * @return void
     */
    public function run(): void
    {
        $actions = $this->data;
        $this->redis->set('actions', $this->data = []);
        foreach ($actions as $action) {
            switch ($action['code']) {
                case 'ArrowRight':
                    (new Player())->move(x: 1);
                    break;
                case 'ArrowLeft':
                    (new Player())->move(x: -1);
                    break;
                case 'ArrowUp':
                    (new Player())->move(y: -1);
                    break;
                case 'ArrowDown':
                    (new Player())->move(y: 1);
                    break;
            }
        }
    }
}