<?php
declare(strict_types=1);

namespace App;

class File
{
    private readonly string $name;

    private mixed $file;

    public function __construct(?string $name = null)
    {
        if ($name) {
            $this->name($name);
        }
    }

    /**
     * @param string $name
     *
     * @return $this
     */
    public function name(string $name): self
    {
        $this->name = "data/$name";

        return $this;
    }

    /**
     * @return bool
     */
    public function exists(): bool
    {
        return file_exists($this->name);
    }

    /**
     * @param mixed $data
     *
     * @return void
     */
    public function write(mixed $data): void
    {
        $this->getResource();
        ftruncate($this->file, 0);
        fwrite($this->file, json_encode($data));
        fflush($this->file);
        $this->closeResource();
    }

    /**
     * @return mixed
     */
    public function read(): mixed
    {
        $this->getResource();
        while (!($content = stream_get_contents($this->file))) {
            //
        }
        $this->closeResource();

        return json_decode($content, true);
    }

    /**
     * @return void
     */
    private function getResource(): void
    {
        $this->file = fopen($this->name, 'w+');
        flock($this->file, LOCK_EX | LOCK_SH);
    }

    /**
     * @return void
     */
    private function closeResource(): void
    {
        flock($this->file, LOCK_UN);
        fclose($this->file);
    }
}