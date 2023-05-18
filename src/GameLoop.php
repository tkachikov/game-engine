<?php
declare(strict_types=1);

namespace App;

class GameLoop
{
    public function run(): void
    {
        $items = [
            Ball::class,
            Action::class,
        ];
        while (true) {
            foreach (Player::getPlayers() as $id => $value) {
                (new Player($id))->run();
            }
            foreach ($items as $item) {
                (new $item)->run();
            }
            usleep(15000);
        }
    }
}