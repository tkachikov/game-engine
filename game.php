<?php
declare(strict_types=1);

require_once('vendor/autoload.php');

$image = imagecreate(1000, 1000);
$background = imagecolorallocate($image, 125, 125, 125);
(new App\Ball)->draw($image);
(new \App\Player())->draw($image);

if (isset($_GET['binary'])) {
    ob_start();
    imagepng($image);
    imagedestroy($image);
    $png = ob_get_contents();
    ob_clean();
    echo base64_encode($png);
} else {
    header('Content-Type: image/png');
    imagepng($image);
    imagedestroy($image);
}

