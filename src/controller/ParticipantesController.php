<?php

require_once 'src/utils/api.php';
require_once 'src/model/ParticipantesModel.php';
require_once 'src/utils/validador.php';

class ParticipantesController {
  public static function listar() : void{
    $service = new ParticipantesModel();
    $lista = $service->getParticipantes();

    //TODO: Revisar
    include __DIR__.'/../view/marcaView.php';
  }

  public static function listarAPI() : void{
    $service = new ParticipantesModel();
    $lista = $service->getParticipantes();

    API::sendResponse($lista);
  }

  // public static function formInserir(){
  //   $acao = '/mvc/carros/marca/inserir';
  //   include __DIR__.'/../view/marcaForm.php';
  // }

  public static function inserir() : void {
    ParticipantesController::inserirInterno();
    //TODO: Chamar tela necessária.
  }
  
  public static function inserirAPI() : void {
    ParticipantesController::inserirInterno();
    API::sendResponse($_POST);
  }

  public static function inserirInterno() : void {
    if($_SERVER['REQUEST_METHOD'] !== 'POST'){
      throw new Exception("A requisição deve utilizar o método POST");
    }

    Validador::validaCampo('idEvento');
    Validador::validaCampo('nome');
    Validador::validaCampo('email');
    Validador::validaCampo('telefone');
      
    $service = new ParticipantesModel();
    if(!$service->inserir($_POST['idEvento'], $_POST['nome'], $_POST['email'], $_POST['telefone'])){
      throw new Exception("Ocorreu um erro ao inserir o participante");
    }
  }

  public static function alterar() : void {
    ParticipantesController::alterarInterno();
    //TODO: Chamar a tela.
  }

  public static function alterarAPI() : void {
    ParticipantesController::alterarInterno();
    API::sendResponse($_POST);
  }

  private static function alterarInterno() : void {
    if($_SERVER['REQUEST_METHOD'] !== 'POST'){
      throw new Exception("A requisição deve utilizar o método POST");
    }

    Validador::validaCampo('id');
    Validador::validaCampo('idEvento');
    Validador::validaCampo('nome');
    Validador::validaCampo('email');
    Validador::validaCampo('telefone');
      
    $service = new ParticipantesModel();
    if(!$service->alterar($_POST['id'], $_POST['idEvento'], $_POST['nome'], $_POST['email'], $_POST['telefone'])){
      throw new Exception("Ocorreu um erro ao alterar o participante");
    }
  }

  public static function excluir() : void {
    ParticipantesController::excluirInterno();
    //TODO: Chamar a tela.
  }

  public static function excluirAPI() : void {
    ParticipantesController::excluirInterno();
    API::sendResponse($_POST);
  }

  private static function excluirInterno() : void {
    if($_SERVER['REQUEST_METHOD'] !== 'POST'){
      throw new Exception("A requisição deve utilizar o método POST");
    }

    Validador::validaCampo('id');
    Validador::validaCampo('idEvento');
    $service = new ParticipantesModel();
    if(!$service->excluir($_POST['id'], $_POST['idEvento'])){
      throw new Exception("Ocorreu um erro ao excluir o evento");
    }
  }
}

?>