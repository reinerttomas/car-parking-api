<?php
declare(strict_types=1);

namespace App\Services;

use Illuminate\Support\Str;

final class KeyCaseConverter
{
    public static function toSnakeCase(array $data): array
    {
        $result = [];

        foreach ($data as $key => $value) {
            $result[Str::snake($key)] = is_array($value)
                ? KeyCaseConverter::toSnakeCase($value)
                : $value;
        }

        return $result;
    }

    public static function toCamelCase(array $data): array
    {
        $result = [];

        foreach ($data as $key => $value) {
            $result[Str::camel($key)] = is_array($value)
                ? KeyCaseConverter::toCamelCase($value)
                : $value;
        }

        return $result;
    }
}
