<?php

require_once  'model/Pessoa.php';
// TODO - criar sessao class e instancia ela aq
class PessoaList
{
    private $data;

    public function __construct()
    {
        $this->startSession();
        $this->data['html']  = file_get_contents('Layout/html/list.html');
        $this->data['items'] = '';
    }


    public function logout()
    {
        if(!isset($_SESSION)){
            session_start();
        }

        session_destroy();
        header("Location: index.php?class=Login");
    }

    public function delete($params)
    {
        try
        {
            $id = (int) $params['id'];
            Pessoa::delete($id);
            return header("Location: index.php");
        }
        catch (Exception $e)
        {
            return print $e->getMessage();
        }
    }

    public function load()
    {
        try
        {
            $id_user = $_SESSION['user']; 
            $pessoas = Pessoa::all($id_user);

            foreach ($pessoas as $pessoa)
            {
                $item = file_get_contents('Layout/html/item.html');

                $item = str_replace('{id}',       $pessoa['id'],       $item);
                $item = str_replace('{name}',     $pessoa['name'],     $item);
                $item = str_replace('{email}',    $pessoa['email'],    $item);
                $item = str_replace('{endereco}', $pessoa['endereco'], $item);
                $item = str_replace('{bairro}',   $pessoa['bairro'],   $item);
                $item = str_replace('{tel}',      $pessoa['tel'],      $item);

                $this->data['items'] .= $item;
            }

            return $this->data['html'] = str_replace('{items}', $this->data['items'], $this->data['html']);
        }
        catch (Exception $e)
        {
            return print $e->getMessage();
        }
    }

    public function show()
    {
        $this->load();
        print $this->data['html'];
        return;
    }

    public function __call($method, $values) 
    {
       return print "O método {$method} não existe.";
    }
    
    public function __get($propriedade)
    {
       return print "Tentou acessar '{$propriedade}' inacessível.";
    }

    public function __set($propriedade, $valor) 
    {
       return print "Tentou gravar {$propriedade} = {$valor} mas a propriedade {$propiedade} não existe.";
    }

    public function __isset($propiedade)
    {
        return isset($this->data[$propiedade]);
    }

    // public function __unset($propiedade)
    // {
    //     unset($this->data[$propriedade]);
    // }

    public function startSession()
    {
        if(!isset($_SESSION)){
            session_start();
        }

        if(!isset($_SESSION['user']))
        {
          header("Location: index.php?class=Login");
        }
    }
}