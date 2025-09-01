<?php

declare(strict_types=1);

namespace EnvLib;

class EnvManager
{
    protected array $data = [];

    public function __construct(string $filePath = null)
    {
        if ($filePath) {
            $this->load($filePath);
        }
    }

    public function load(string $filePath): void
    {
        if (!file_exists($filePath)) {
            throw new \RuntimeException("Env file not found: $filePath");
        }

        $lines = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        foreach ($lines as $line) {
            $line = trim($line);

            // Ignore comments
            if ($line === '' || str_starts_with($line, '#') || str_starts_with($line, ';')) {
                continue;
            }

            if (strpos($line, '=') !== false) {
                [$key, $value] = explode('=', $line, 2);

                $key = trim($key);
                $value = trim($value);

                // Remove quotes
                if (
                    (str_starts_with($value, '"') && str_ends_with($value, '"')) ||
                    (str_starts_with($value, "'") && str_ends_with($value, "'"))
                ) {
                    $value = substr($value, 1, -1);
                }

                $this->data[$key] = $this->castValue($value);
            }
        }
    }

    protected function castValue(string $value): mixed
    {
        $lower = strtolower($value);
        return match (true) {
            $lower === 'true'   => true,
            $lower === 'false'  => false,
            $lower === 'null'   => null,
            is_numeric($value)  => $value + 0,
            default             => $value,
        };
    }

    public function get(string $key, mixed $default = null): mixed
    {
        return $this->data[$key] ?? $default;
    }

    public function has(string $key): bool
    {
        return array_key_exists($key, $this->data);
    }

    public function all(): array
    {
        return $this->data;
    }

    public function set(string $key, mixed $value): void
    {
        $this->data[$key] = $value;
    }

    public function save(string $filePath): void
    {
        $lines = [];
        foreach ($this->data as $key => $value) {
            if (is_bool($value)) {
                $value = $value ? 'true' : 'false';
            } elseif ($value === null) {
                $value = 'null';
            }
            $lines[] = "$key=$value";
        }
        file_put_contents($filePath, implode(PHP_EOL, $lines));
    }
}
