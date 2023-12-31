<?php
require_once "database/TTransaction.php";
class Pessoa
{
  public static function save($pessoa)
  {
    $conn = TTransaction::getConnection();
  
    if(empty($pessoa['id']))
    {
      $result = $conn->query("SELECT max(id) as next FROM pessoa");
      $row = $result->fetch();
      $pessoa['id'] = (int) $row['next'] + 1; 
      $sql = "INSERT INTO pessoa (id, name, email, endereco, bairro, tel, id_user)
              VALUES (:id, 
                      :name,
                      :email,
                      :endereco,
                      :bairro,
                      :tel,
                      :id_user)";
    }
    else
    {
      $sql = "UPDATE pessoa SET 
              name     = :name,
              email    = :email,
              endereco = :endereco,
              bairro   = :bairro,
              tel      = :tel,
              id_user  = :id_user
              WHERE id = :id";
    } 
    $result = $conn->prepare($sql);
    $data = $result->execute([':id'         =>  $pessoa['id'],
                              ':name'       =>  $pessoa['name'],                  
                              ':email'      =>  $pessoa['email'],                  
                              ':endereco'   =>  $pessoa['endereco'],                  
                              ':bairro'     =>  $pessoa['bairro'],                  
                              ':tel'        =>  $pessoa['tel'],
                              ':id_user'    =>  $pessoa['id_user']]);
    TTransaction::closeConnection();
    return $pessoa;
  }

  public static function find($id)
  {
    $conn = TTransaction::getConnection();
    $result = $conn->prepare("SELECT * FROM pessoa WHERE id =:id");
    $result->execute([':id' => $id]);
    $data = $result->fetch(); 
    TTransaction::closeConnection();
    return $data;
  }

  public static function delete($id)
  {
    $conn = TTransaction::getConnection();
    $result = $conn->prepare("DELETE FROM pessoa WHERE id =:id");
    $data = $result->execute([':id' => $id]);
    TTransaction::closeConnection();
    return $data;
  }

  public static function all($id_user)
  {
    $conn = TTransaction::getConnection();
    $result = $conn->query("SELECT * FROM pessoa WHERE id_user = {$id_user};");
    $data = $result->fetchAll();
    TTransaction::closeConnection();
    return $data;
  }
}