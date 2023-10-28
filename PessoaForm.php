<?php

require_once "classes/Pessoa.php";
class PessoaForm 
{
  private $html;
  private $data;

  public function __construct()
  {
    $this->html = file_get_contents("html/form.html");
    $this->data = ['id'       => '',
                   'name'     => '',
                   'email'    => '',
                   'endereco' => '',
                   'bairro'   => '',
                   'tel'      => ''];
  }

  public function edit($params)  
  {
    try 
    {
      $id  = (int) $params['id'];
      $this->data = Pessoa::find($id);
    } 
    catch (Exception $e) 
    {
      return $e->getMessage();
    }  
  }

  public function save($params)
  {
    try 
    {
      $pessoa = Pessoa::save($params);
      $this->data = $pessoa;
      $result = "Pessoa salva com sucesso <br> <a href='index.php'>Volta para pagina inicial</a>";
      return  print $result; 
    } 
    catch (Exception $e) 
    {
      return $e->getMessage();
    }  
  }

  public function show()  
  {
    $this->html = str_replace('{id}',       $this->data['id'],       $this->html);
    $this->html = str_replace('{name}',     $this->data['name'],     $this->html);
    $this->html = str_replace('{email}',    $this->data['email'],    $this->html);
    $this->html = str_replace('{endereco}', $this->data['endereco'], $this->html);
    $this->html = str_replace('{bairro}',   $this->data['bairro'],   $this->html);
    $this->html = str_replace('{tel}',      $this->data['tel'],      $this->html);

    print $this->html;
  } 
}