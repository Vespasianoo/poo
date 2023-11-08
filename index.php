<?php 

spl_autoload_register(function($class) 
{
    if(file_exists('control/' . $class . '.php'))
    {
        require_once 'control/' .  $class . '.php';
    }
});


$class = isset($_REQUEST['class']) ? $_REQUEST['class'] : 'Login'; 
$method = isset($_REQUEST['method']) ? $_REQUEST['method'] : null;

if(class_exists($class))
{
    $pagina = new $class($_REQUEST);
    if(!empty($method) and method_exists($class, $method))
    {
        $pagina->$method($_REQUEST);
    }
    $pagina->show();
} else 
{
    $error404 = "<h1>404</h1> <br> <a href='index.php?class=PessoaList'>Ir para o inicio</a>";
    print $error404;
}

// TODO - fazer o register
// TODO - fazer o md5 no login
// TODO - tratamento de erros nos models
