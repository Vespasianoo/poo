<?php

abstract class TTransaction 
{
    private static $conn;

    public static function getConnection()
    {
        if(empty(self::$conn))
        {
            $conexao = parse_ini_file('config/selecao.ini');
            $host = $conexao['host'];
            $port = $conexao['port'];
            $name = $conexao['name'];
            $pass = $conexao['pass'];
            $user = $conexao['user'];
            
            $conn = new PDO("mysql:host={$host};port={$port};dbname={$name}", "{$user}", "{$pass}");
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            self::$conn = $conn;
        }
        return self::$conn;
    }

    public static function closeConnection()
    {
        if (self::$conn) {
            self::$conn = null;
        }   
    }

    public static function getTables()
    {
        $result = self::$conn->query("SHOW TABLES");
        return $result->fetchAll();
    }
}