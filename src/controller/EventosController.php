<?php

require_once 'src/core/api.php';
require_once 'src/model/EventosModel.php';
require_once 'src/core/validador.php';

class EventosController {
  public static function listar() : array {
    $service = new EventosModel();
    return $service->getEventos();
  }

  public static function listarAPI() : void{
    $service = new EventosModel();
    API::sendResponse($service->getEventos());
  }

  // public static function formInserir(){
  //   $acao = '/mvc/carros/marca/inserir';
  //   include __DIR__.'/../view/marcaForm.php';
  // }

  public static function inserir() : void {
    EventosController::inserirInterno();
    header('location: /gerenciadorEventos/admin/');
  }
  
  // public static function inserirAPI() : void {
  //   EventosController::inserirInterno();
  //   API::sendResponse($_POST);
  // }

  public static function inserirInterno() : void {
    if($_SERVER['REQUEST_METHOD'] !== 'POST'){
      throw new Exception("A requisição deve utilizar o método POST");
    }

    Validador::validaCampo('titulo');
    Validador::validaCampo('descricao');
    Validador::validaCampo('local');
    Validador::validaCampo('dataEvento');
      
    $service = new EventosModel();
    if(!$service->inserir($_POST['titulo'], $_POST['descricao'], $_POST['local'], new DateTimeImmutable($_POST['dataEvento']))){
      throw new Exception("Ocorreu um erro ao inserir o evento");
    }
  }

  public static function alterar() : void {
    EventosController::alterarInterno();
    header('location: /gerenciadorEventos/admin/');
  }

  // public static function alterarAPI() : void {
  //   EventosController::alterarInterno();
  //   API::sendResponse($_POST);
  // }

  private static function alterarInterno() : void {
    if($_SERVER['REQUEST_METHOD'] !== 'POST'){
      throw new Exception("A requisição deve utilizar o método POST");
    }

    Validador::validaCampo('id');
    Validador::validaCampo('titulo');
    Validador::validaCampo('descricao');
    Validador::validaCampo('local');
    Validador::validaCampo('dataEvento');
      
    $service = new EventosModel();
    if(!$service->alterar($_POST['id'], $_POST['titulo'], $_POST['descricao'], $_POST['local'], new DateTimeImmutable($_POST['dataEvento']))){
      throw new Exception("Ocorreu um erro ao alterar o evento");
    }
  }

  public static function excluir() : void {
    EventosController::excluirInterno();
    header('location: /gerenciadorEventos/admin/');
  }

  // public static function excluirAPI() : void {
  //   EventosController::excluirInterno();
  //   API::sendResponse($_POST);
  // }

  private static function excluirInterno() : void {
    if($_SERVER['REQUEST_METHOD'] !== 'POST'){
      throw new Exception("A requisição deve utilizar o método POST");
    }

    Validador::validaCampo('id');
    $service = new EventosModel();
    if(!$service->excluir($_POST['id'])){
      throw new Exception("Ocorreu um erro ao excluir o evento");
    }
  }

  public static function getEventoPorId() : array{
    return EventosController::getEventoPorIdInterno();
  }

  public static function getEventoPorIdAPI() : void {
    API::sendResponse(EventosController::getEventoPorIdInterno());
  }

  public static function getEventoPorIdInterno() : array {
    if($_SERVER['REQUEST_METHOD'] !== 'POST'){
      throw new Exception("A requisição deve utilizar o método POST");
    }

    Validador::validaCampo('id');

    return (new EventosModel())->getEventoPorId($_POST['id']);
  }
}

?>