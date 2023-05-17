<?php
declare(strict_types=1);

require_once('vendor/autoload.php');

use App\File;

$name = 'test';
$file = new File($name);
while (true) {
    $data = $file->read();
    echo "{$data['ts']} {$data['index']}\r\n";
    usleep(15000);
}