<?php

require_once  'model/Pessoa.php';

class PessoaList
{
    private $data;

    public function __construct()
  {
    $this->data['html']  = file_get_contents('html/list.html');
    $this->data['items'] = '';
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
      $pessoas = Pessoa::all();
      // $items = ''; // ATR

      foreach ($pessoas as $pessoa)
      {
        $item = file_get_contents('html/item.html');

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
  
    public function __call($method, $values) 
    {
        print "O método {$method} não existe.";
    } 


  public function show()
  {
    $this->load();
    print $this->data['html'];
    return;
  }
}