<?php

require_once 'src/core/api.php';
require_once 'src/model/ParticipantesModel.php';
require_once 'src/core/validador.php';

class ParticipantesController {

  public static function geraTabelaParticipante() : String {
    $lista = ParticipantesController::listarInterno();

    $table = "";
    foreach ($lista as $participantes) {
      $table = $table."<tr>
        <td>{$participantes['NOMEUSUARIO']}</td>
        <td>{$participantes['EMAIL']}</td>
      </tr>";
    }

    return $table;
  }

  public static function listarAPI() : void{
    API::sendResponse(ParticipantesController::listarInterno());
  }

  private static function listarInterno() : array {
    if($_SERVER['REQUEST_METHOD'] !== 'POST'){
      throw new Exception("A requisição deve utilizar o método POST");
    }

    Validador::validaCampo('id');
    
    $service = new ParticipantesModel();
    return $service->getParticipantes($_POST['id']);
  }

  // public static function formInserir(){
  //   $acao = '/mvc/carros/marca/inserir';
  //   include __DIR__.'/../view/marcaForm.php';
  // }

  // public static function inserir() : void {
  //   ParticipantesController::inserirInterno();
  //   //TODO: Chamar tela necessária.
  // }
  
  public static function inserirAPI() : void {
    ParticipantesController::inserirInterno();
    API::sendResponse($_POST);
  }

  public static function inserirInterno() : void {
    if($_SERVER['REQUEST_METHOD'] !== 'POST'){
      throw new Exception("A requisição deve utilizar o método POST");
    }

    Validador::validaCampo('idUsuario');
    Validador::validaCampo('idEvento');
      
    $service = new ParticipantesModel();
    if(!$service->inserir($_POST['idUsuario'], $_POST['idEvento'])){
      throw new Exception("Ocorreu um erro ao inserir o participante");
    }
  }

  // public static function excluir() : void {
  //   ParticipantesController::excluirInterno();
  //   //TODO: Chamar a tela.
  // }

  public static function excluirAPI() : void {
    ParticipantesController::excluirInterno();
    API::sendResponse($_POST);
  }

  private static function excluirInterno() : void {
    if($_SERVER['REQUEST_METHOD'] !== 'POST'){
      throw new Exception("A requisição deve utilizar o método POST");
    }

    Validador::validaCampo('idUsuario');
    Validador::validaCampo('idEvento');
    $service = new ParticipantesModel();
    if(!$service->excluir($_POST['idUsuario'], $_POST['idEvento'])){
      throw new Exception("Ocorreu um erro ao excluir o participante");
    }
  }
}

?>