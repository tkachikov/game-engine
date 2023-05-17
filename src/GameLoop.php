<?php
declare(strict_types=1);

namespace App;

class GameLoop
{
    public function run(): void
    {
        $items = [
            Ball::class,
            Player::class,
            Action::class,
        ];
        while (true) {
            foreach ($items as $item) {
                (new $item)->run();
            }
            usleep(15000);
        }
    }
}