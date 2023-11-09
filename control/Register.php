<?php 

require_once 'model/User.php';
class Register
{
    private $html;
    private $data;

    public function __construct()
    {
        $this->startSession();
        $this->html = file_get_contents("Layout/html/register.html");
    }
    public function startSession()
    {
        if(!isset($_SESSION)){
            session_start();
           
        }
        
        if(isset($_SESSION['user']))
        {
          return  header('Location: index.php?class=Dashboard');
        }
    }

    public function save($params)
    {
        try 
        {
            $pessoa = User::save($params);
            return header("Location: index.php?class=Login");
        } 
        catch (Exception $e) 
        {
            return print $e->getMessage();
        }  
    }

    public function show()  
    {
        print $this->html;
    }
}

