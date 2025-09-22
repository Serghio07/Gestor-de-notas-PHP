<?php

namespace App;

use PDO;
use PDOException;

class Database
{
    private $host;
    private $dbname;
    private $username;
    private $password;
    private $charset;
    private $pdo;

    public function __construct(
        string $host = 'localhost',
        string $dbname = 'notes_app',
        string $username = 'root',
        string $password = 'root',
        string $charset = 'utf8mb4'
    ) {
        $this->host = $host;
        $this->dbname = $dbname;
        $this->username = $username;
        $this->password = $password;
        $this->charset = $charset;
    }

    public function connect(): PDO
    {
        if ($this->pdo === null) {
            $dsn = "mysql:host={$this->host};dbname={$this->dbname};charset={$this->charset}";
            
            try {
                $this->pdo = new PDO($dsn, $this->username, $this->password, [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false,
                ]);
            } catch (PDOException $e) {
                throw new PDOException("Error de conexión a la base de datos: " . $e->getMessage());
            }
        }

        return $this->pdo;
    }

    public static function fromConfig(array $config): self
    {
        return new self(
            $config['host'] ?? 'localhost',
            $config['dbname'] ?? 'notes_app',
            $config['username'] ?? 'root',
            $config['password'] ?? 'root',
            $config['charset'] ?? 'utf8mb4'
        );
    }
}