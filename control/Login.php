<?php
require_once "model/User.php";
require_once "Session/Session.php";

class Login
{
    private $html;
    private $data;

    public function __construct()
    {
        $this->startSession();
        $this->html = file_get_contents("Layout/html/login.html");
        $this->data = ['id'      => '',
                       'login'   => '',
                       'email'   => ''];
    }

    public function startSession()
    {
        if(!isset($_SESSION)){
            session_start();
           
        }
        
        if(isset($_SESSION['user']))
        {
          return  header('Location: index.php?class=PessoaList');
        }
    }

    public function signIn($params)
    {   
        try 
        {
            if(isset($params['email']) and isset($params['password']))
            {
                if(strlen($params['email']) == 0)
                {
                    print "Preecha o email";
                } elseif ((strlen($params['password']) == 0))
                {
                    print "Preecha a senha";
                } else 
                {
                    $res =  User::authenticate($params);
                    Session::set($res);
                    
                    header("Location: index.php?class=PessoaList");
                } 
            }
        } catch (Exception $e) 
        {
            return print $e->getMessage();
        }
    }

    public function show()  
    {
        return print $this->html;
    }
}