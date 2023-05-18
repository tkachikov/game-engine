<?php
declare(strict_types=1);

require_once('vendor/autoload.php');

session_start();

(new \App\Game($_GET['id'] ?? session_id()))
    ->binary(isset($_GET['binary']))
    ->getFrame();
