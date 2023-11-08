<?php

class Session
{
    public static function set($data)
    {
        if(!isset($_SESSION)) 
        {
            session_start();
        }

        $_SESSION['user']  = $data['id'];
        $_SESSION['email'] = $data['email'];
        $_SESSION['name']  = $data['name'];
        
    }

    public static function remove()
    {
        if(!isset($_SESSION)){
            session_start();
        }

        session_destroy();
    }

    public static function isValid()
    {
         if(!isset($_SESSION)){
            session_start();
        }

        if(!isset($_SESSION['user']))
        {
            throw new Exception ("Você não esta"); 
            // die("Você não está auth <a href='index.php?class=Login'>Faça o Login</a>");
        }
    }

}
