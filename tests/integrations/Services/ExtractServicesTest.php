<?php

use PHPUnit\Framework\TestCase;
$dotenv = Dotenv\Dotenv::createUnsafeImmutable(__DIR__.'\..\..\..\\', '.env.test');
$dotenv->load();

class ExtractServicesTest extends TestCase
{
    private function connection()
    {
        $conn = [
            $_ENV['DB_HOST'],
            $_ENV['DB_DATABASE'],
            $_ENV['DB_USER'],
            $_ENV['DB_PASS']
        ];
        return $conn;
    }

    
}