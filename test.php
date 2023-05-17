<?php
declare(strict_types=1);

require_once('vendor/autoload.php');

use App\File;

$index = 0;
$lastTime = time();
$name = 'test';
$file = new File($name);
while (true) {
    $data = [
        'ts' => date('Y-m-d H:i:s'),
        'index' => $index++,
    ];
    $file->write($data);
    echo "{$data['ts']} {$data['index']}\r\n";
    $newTime = time();
    if ($newTime - $lastTime > 0) {
        $index = 0;
    }
    $lastTime = $newTime;
    usleep(15000);
}