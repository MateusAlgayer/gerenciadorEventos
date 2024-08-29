<?php

require_once 'src/core/api.php';
require_once 'src/model/ParticipantesModel.php';
require_once 'src/core/validador.php';

class ParticipantesController {

  public static function geraTabelaParticipante() : String {
    if($_SERVER['REQUEST_METHOD'] !== 'POST'){
      throw new Exception("A requisição deve utilizar o método POST");
    }
    
    $lista = ParticipantesController::listarInterno($_POST['id']);

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
    if($_SERVER['REQUEST_METHOD'] !== 'POST'){
      throw new Exception("A requisição deve utilizar o método POST");
    }
    
    $dados = json_decode(file_get_contents("php://input"));

    $result = [];
    foreach (ParticipantesController::listarInterno($dados->id) as $participante) {
      $result[] = array(
        'nomeParticipante' => $participante['NOMEUSUARIO'],
        'emailParticipante' => $participante['EMAIL'],
      );
    }

    API::sendResponse($result);
  }

  private static function listarInterno($id) : array {
    Validador::validaCampo('id', $id);
    
    $service = new ParticipantesModel();
    return $service->getParticipantes($id);
  }

  public static function inserirAPI() : void {
    if($_SERVER['REQUEST_METHOD'] !== 'POST'){
      throw new Exception("A requisição deve utilizar o método POST");
    }
    
    $dados = json_decode(file_get_contents("php://input"));
    ParticipantesController::inserirInterno($dados->idUsuario, $dados->idEvento);
    API::sendResponse($dados);
  }

  public static function inserirInterno($idUsuario, $idEvento) : void {
    Validador::validaCampo('idUsuario', $idUsuario);
    Validador::validaCampo('idEvento', $idEvento);
      
    $service = new ParticipantesModel();
    if(!$service->inserir($idUsuario, $idEvento)){
      throw new Exception("Ocorreu um erro ao inserir o participante");
    }
  }

  public static function excluirAPI() : void {
    if($_SERVER['REQUEST_METHOD'] !== 'POST'){
      throw new Exception("A requisição deve utilizar o método POST");
    }
    
    $dados = json_decode(file_get_contents("php://input"));
    ParticipantesController::excluirInterno($dados->idUsuario, $dados->idEvento);
    API::sendResponse($dados);
  }

  private static function excluirInterno($idUsuario, $idEvento) : void {
    Validador::validaCampo('idUsuario', $idUsuario);
    Validador::validaCampo('idEvento', $idEvento);
    $service = new ParticipantesModel();
    if(!$service->excluir($idUsuario, $idEvento)){
      throw new Exception("Ocorreu um erro ao excluir o participante");
    }
  }
}

?>