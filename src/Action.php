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
     * @param string $id
     * @param string $code
     * @param int $x
     * @param int $y
     *
     * @return void
     */
    public function add(string $id, string $code, int $x, int $y): void
    {
        $this->data[$id][] = [
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
        $data = $this->data;
        $this->redis->set('actions', $this->data = []);
        foreach ($data as $id => $actions) {
            foreach ($actions as $action) {
                switch ($action['code']) {
                    case 'ArrowRight':
                        (new Player($id))->move(x: 1);
                        break;
                    case 'ArrowLeft':
                        (new Player($id))->move(x: -1);
                        break;
                    case 'ArrowUp':
                        (new Player($id))->move(y: -1);
                        break;
                    case 'ArrowDown':
                        (new Player($id))->move(y: 1);
                        break;
                }
            }
        }
    }
}