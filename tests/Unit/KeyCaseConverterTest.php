<?php

namespace Tests\Unit;

use App\Services\KeyCaseConverter;
use PHPUnit\Framework\TestCase;

class KeyCaseConverterTest extends TestCase
{
    public function test_convert_camel_to_snake_case(): void
    {
        $data = [
            'id' => 1,
            'firstName' => 'John',
            'lastName' => 'Doe',
            'email' => 'john.doe@example.com',
            'dateOfBirth' => '2000-01-01',
            'address' => [
                'streetAddress' => '123 Main St',
                'city' => 'Anytown',
                'state' => 'CA',
                'postalCode' => '12345',
                'country' => 'USA',
                'geo' => [
                    'lat' => -37.3159,
                    'lng' => 81.1496,
                ],
            ],
            'company' => [
                'name' => 'Acme Corporation',
                'position' => 'Software Engineer',
                'department' => 'Engineering',
                'catch_phrase' => 'Multi-layered client-server neural-net',
            ],
        ];

        $this->assertEquals([
            'id' => 1,
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john.doe@example.com',
            'date_of_birth' => '2000-01-01',
            'address' => [
                'street_address' => '123 Main St',
                'city' => 'Anytown',
                'state' => 'CA',
                'postal_code' => '12345',
                'country' => 'USA',
                'geo' => [
                    'lat' => -37.3159,
                    'lng' => 81.1496,
                ],
            ],
            'company' => [
                'name' => 'Acme Corporation',
                'position' => 'Software Engineer',
                'department' => 'Engineering',
                'catch_phrase' => 'Multi-layered client-server neural-net',
            ],
        ], KeyCaseConverter::toSnakeCase($data));
    }

    public function test_convert_snake_to_camel_case(): void
    {
        $data = [
            'id' => 1,
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john.doe@example.com',
            'date_of_birth' => '2000-01-01',
            'address' => [
                'street_address' => '123 Main St',
                'city' => 'Anytown',
                'state' => 'CA',
                'postal_code' => '12345',
                'country' => 'USA',
                'geo' => [
                    'lat' => -37.3159,
                    'lng' => 81.1496,
                ],
            ],
            'company' => [
                'name' => 'Acme Corporation',
                'position' => 'Software Engineer',
                'department' => 'Engineering',
                'catch_phrase' => 'Multi-layered client-server neural-net',
            ],
        ];

        $this->assertEquals([
            'id' => 1,
            'firstName' => 'John',
            'lastName' => 'Doe',
            'email' => 'john.doe@example.com',
            'dateOfBirth' => '2000-01-01',
            'address' => [
                'streetAddress' => '123 Main St',
                'city' => 'Anytown',
                'state' => 'CA',
                'postalCode' => '12345',
                'country' => 'USA',
                'geo' => [
                    'lat' => -37.3159,
                    'lng' => 81.1496,
                ],
            ],
            'company' => [
                'name' => 'Acme Corporation',
                'position' => 'Software Engineer',
                'department' => 'Engineering',
                'catchPhrase' => 'Multi-layered client-server neural-net',
            ],
        ], KeyCaseConverter::toCamelCase($data));
    }
}
