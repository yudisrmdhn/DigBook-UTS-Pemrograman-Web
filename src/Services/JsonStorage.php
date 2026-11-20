<?php

declare(strict_types=1);

namespace App\Services;

class JsonStorage
{
    private string $filePath;

    public function __construct(string $fileName)
    {
        $this->filePath = DATA_PATH . '/' . $fileName;

        if (!file_exists($this->filePath)) {
            file_put_contents($this->filePath, json_encode([]));
        }
    }

    public function read(): array
    {
        $content = file_get_contents($this->filePath);

        $data = json_decode($content ?: '[]', true);

        return is_array($data) ? $data : [];
    }

    public function write(array $data): bool
    {
        $json = json_encode(
            $data,
            JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE
        );

        if ($json === false) {
            return false;
        }

        return file_put_contents($this->filePath, $json) !== false;
    }
}
