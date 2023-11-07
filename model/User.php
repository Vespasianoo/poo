<?php
require_once "database/TTransaction.php";

abstract class User 
{
    public static function save($data)
    {
        $conn = TTransaction::getConnection();

        if(empty($data['id']))
        {
            $userExist = $conn->prepare("SELECT * FROM user WHERE email = :email");
            $userExist = $conn->execute([":email" => $data["email"]]);
            
            if ($userExist->rowCount() == 0) 
            {
                $result = $conn->query("SELECT max(id) as next FROM user");
                $row = $result->fetch();
                $data['id'] = (int) $row['next'] + 1;
                $hashedPassword = md5($user['password']);

                $sql = "INSERT INTO users (id, name, email, password)
                            VALUES (:id, :name, :email, :password)";
            } else 
            {
                throw new Exception("Este e-mail já está cadastrado.");
            }
        } 

        $result = $conn->prepare($sql);
        $result->execute([
            ':id'       => $data['id'],
            ':name'     => $data['name'],
            ':email'    => $data['email'],
            ':password' => $hashedPassword
        ]);
        TTransaction::closeConnection();
        return;
    }
}