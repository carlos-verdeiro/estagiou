<?php
class Database
{
    private $host = 'localhost';
    private $db_name;
    private $username;
    private $password;
    private $conn;

    public function __construct($db_name, $username, $password)
    {
        $this->db_name = $db_name;
        $this->username = $username;
        $this->password = $password;
    }

    public function connect()
    {
        $this->conn = null;
        try {
            $this->conn = new PDO('mysql:host=' . $this->host . ';dbname=' . $this->db_name, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo 'Erro de Conexão: ' . $e->getMessage();
        }
        return $this->conn;
    }
}
?>