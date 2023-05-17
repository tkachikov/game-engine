<?php
declare(strict_types=1);

require_once('vendor/autoload.php');

$data = json_decode(file_get_contents('php://input'), true);

(new \App\Action())->add($data['code'], $data['x'] ?? 0, $data['y'] ?? 0);