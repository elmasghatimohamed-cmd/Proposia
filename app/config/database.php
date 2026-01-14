<?php

namespace App\Config;
use PDO;
use PDOException;
use Exception;
class Database
{
    private string $host = "localhost";
    private int $port = 3307;
    private string $dbName = "proposia_db";
    private string $username = "root";
    private string $password = "";
    private ?PDO $conn;

    private static ?Database $instance = null;


    public function __construct()
    {
        try {
            $this->conn = new PDO("mysql:host={$this->host};port={$this->port};dbname={$this->dbName}", $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $exception) {
            echo "Connection error: " . $exception->getMessage();
        } catch (Exception $e) {
            echo "General error: " . $e->getMessage();
        }
    }

    public static function getInstance(): Database
    {
        if (self::$instance === null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    public function getConnection(): ?PDO
    {
        return $this->conn;
    }
}

?>