<?php

use Brunosribeiro\WalletApi\Infra\DBConnection;
use Brunosribeiro\WalletApi\Repository\ExtractRepository;
use PHPUnit\Framework\TestCase;
$dotenv = Dotenv\Dotenv::createUnsafeImmutable(__DIR__.'\..\..\..\\', '.env.test');
$dotenv->load();

class ExtractRepositoryTest extends TestCase
{
    private function connection()
    {
        $conn = new DBConnection(
            $_ENV['DB_HOST'],
            $_ENV['DB_DATABASE'],
            $_ENV['DB_USER'],
            $_ENV['DB_PASS']
        );
        return $conn;
    }

    public function testPerPeriod()
    {
        $id = 3;
        $extractRepo = new ExtractRepository($this->connection());
        $finalDate = date('Y-m-d');
        $initialDate = date('Y-m-d', strtotime("-30 days",strtotime($finalDate))); 
        $result = $extractRepo->perPeriod($id, $initialDate, $finalDate);
        $this->assertEquals('Walter White', $result[0]['name']);
    }

    public function testPerPeriodComIdInexistente()
    {
        $id = 5464456465;
        $extractRepo = new ExtractRepository($this->connection());
        $initialDate = date('Y-m-d');
        $finalDate = date('Y-m-d', strtotime("-360 days",strtotime($initialDate))); 
        $result = $extractRepo->perPeriod($id, $initialDate, $finalDate);
        $this->assertEmpty($result);
    }

    
    public function testPerPeriodComIdExcluido()
    {
        $id = 2;
        $extractRepo = new ExtractRepository($this->connection());
        $initialDate = date('Y-m-d');
        $finalDate = date('Y-m-d', strtotime("-360 days",strtotime($initialDate))); 
        $result = $extractRepo->perPeriod($id, $initialDate, $finalDate);
        $this->assertEmpty($result);
    }
}