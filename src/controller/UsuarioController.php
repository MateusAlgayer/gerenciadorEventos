<?php

require_once 'src/utils/api.php';
require_once 'src/model/UsuariosModel.php';
require_once 'src/utils/validador.php';

class UsuariosController {
  // public static function formInserir(){
  //   $acao = '/mvc/carros/marca/inserir';
  //   include __DIR__.'/../view/marcaForm.php';
  // }

  public static function inserir() : void {
    UsuariosController::inserirInterno();
    //TODO: Chamar tela necessária.
  }
  
  public static function inserirAPI() : void {
    UsuariosController::inserirInterno();
    API::sendResponse($_POST);
  }

  public static function inserirInterno() : void {
    if($_SERVER['REQUEST_METHOD'] !== 'POST'){
      throw new Exception("A requisição deve utilizar o método POST");
    }

    Validador::validaCampo('nome');
    Validador::validaCampo('email');
    Validador::validaCampo('senha');
      
    $service = new UsuariosModel();
    if(!$service->inserir($_POST['nome'], $_POST['email'], $_POST['senha'])){
      throw new Exception("Ocorreu um erro ao inserir o usuário");
    }
  }

  // public static function alterar() : void {
  //   UsuariosController::alterarInterno();
  //   //TODO: Chamar a tela.
  // }

  // public static function alterarAPI() : void {
  //   UsuariosController::alterarInterno();
  //   API::sendResponse($_POST);
  // }

  // private static function alterarInterno() : void {
  //   if($_SERVER['REQUEST_METHOD'] !== 'POST'){
  //     throw new Exception("A requisição deve utilizar o método POST");
  //   }

  //   Validador::validaCampo('id');
  //   Validador::validaCampo('nome');
  //   Validador::validaCampo('email');
  //   Validador::validaCampo('senha');
      
  //   $service = new UsuariosModel();
  //   if(!$service->alterar($_POST['id'], $_POST['nome'], $_POST['email'], $_POST['senha'])){
  //     throw new Exception("Ocorreu um erro ao alterar o usuário");
  //   }
  // }

  // public static function excluir() : void {
  //   UsuariosController::excluirInterno();
  //   //TODO: Chamar a tela.
  // }

  // public static function excluirAPI() : void {
  //   UsuariosController::excluirInterno();
  //   API::sendResponse($_POST);
  // }

  // private static function excluirInterno() : void {
  //   if($_SERVER['REQUEST_METHOD'] !== 'POST'){
  //     throw new Exception("A requisição deve utilizar o método POST");
  //   }

  //   Validador::validaCampo('id');
  //   $service = new UsuariosModel();
  //   if(!$service->excluir($_POST['id'])){
  //     throw new Exception("Ocorreu um erro ao excluir o usuário");
  //   }
  // }
}

?>