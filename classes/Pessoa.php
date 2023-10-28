<?php

class Pessoa
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

  public static function save($pessoa)
  {
    $conn = self::getConnection();
  
    if(empty($pessoa['id']))
    {
      $result = $conn->query("SELECT max(id) as next FROM pessoa");
      $row = $result->fetch();
      $pessoa['id'] = (int) $row['next'] + 1; 
      $sql = "INSERT INTO pessoa (id, name, email, endereco, bairro, tel)
              VALUES (:id, 
                      :name,
                      :email,
                      :endereco,
                      :bairro,
                      :tel)";
    }
    else
    {
      $sql = "UPDATE pessoa SET 
              name     = :name,
              email    = :email,
              endereco = :endereco,
              bairro   = :bairro,
              tel      = :tel
              WHERE id = :id";
    } 
    $result = $conn->prepare($sql);
    $result->execute([':id'=>       $pessoa['id'],
                      ':name'=>     $pessoa['name'],                  
                      ':email'=>     $pessoa['email'],                  
                      ':endereco'=> $pessoa['endereco'],                  
                      ':bairro'=>   $pessoa['bairro'],                  
                      ':tel'=>      $pessoa['tel']]);
    return $pessoa;
  }

  public static function find($id)
  {
    $conn = self::getConnection();
    $result = $conn->prepare("SELECT * FROM pessoa WHERE id =:id");
    $result->execute([':id' => $id]);
    return $result->fetch();
  }

  public static function delete($id)
  {
    $conn = self::getConnection();
    $result = $conn->prepare("DELETE FROM pessoa WHERE id =:id");
    $result->execute([':id' => $id]);
    return $result;
  }

  public static function all()
  {
    $conn = self::getConnection();
    $result = $conn->query('SELECT * FROM pessoa ORDER BY id');
    return $result->fetchAll();
  }
}