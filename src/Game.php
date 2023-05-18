<?php
declare(strict_types=1);

namespace App;

use GdImage;

class Game
{
    private readonly GdImage $image;

    private readonly int $width;

    private readonly int $height;

    private readonly bool $binary;

    public function __construct(
        private readonly string $id,
    ) {
        $this->width = 1000;
        $this->height = 1000;
        $this->image = imagecreate($this->width, $this->height);
        $background = imagecolorallocate($this->image, 125, 125, 125);
    }

    /**
     * @param bool $binary
     *
     * @return $this
     */
    public function binary(bool $binary): self
    {
        $this->binary = $binary;

        return $this;
    }

    /**
     * @return void
     */
    public function getFrame(): void
    {
        foreach (Player::getPlayers() as $id => $value) {
            if ($id !== $this->id) {
                (new Player($id))->draw($this->image);
            }
        }
        (new Ball())->draw($this->image);
        (new Player($this->id))->draw($this->image);
        $this->out();
    }

    /**
     * @return void
     */
    public function out(): void
    {
        ob_start();
        imagepng($this->image);
        imagedestroy($this->image);
        $png = ob_get_contents();
        ob_clean();
        if ($this->binary) {
            echo base64_encode($png);
        } else {
            header('Content-Type: image/png');
            echo $png;
        }
    }
}