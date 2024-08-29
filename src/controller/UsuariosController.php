<?php

require_once 'src/core/api.php';
require_once 'src/model/UsuariosModel.php';
require_once 'src/core/validador.php';

class UsuariosController {
  public static function inserir() : void {
    if($_SERVER['REQUEST_METHOD'] !== 'POST'){
      throw new Exception("A requisição deve utilizar o método POST");
    }
    
    UsuariosController::inserirInterno($_POST['nome'], $_POST['email'], $_POST['senha'], 'A');
    header('location: /gerenciadorEventos/');
  }
  
  public static function inserirAPI() : void {
    if($_SERVER['REQUEST_METHOD'] !== 'POST'){
      throw new Exception("A requisição deve utilizar o método POST");
    }

    $dados = json_decode(file_get_contents("php://input"));
    UsuariosController::inserirInterno($dados->nome, $dados->email, $dados->senha, 'U');
    API::sendResponse($dados);
  }

  public static function inserirInterno($nome, $email, $senha, String $tipoUsuario) : void {
    Validador::validaCampo('nome', $nome);
    Validador::validaCampo('email', $email);
    Validador::validaCampo('senha', $senha);

    $senhaCripto = password_hash($senha, PASSWORD_BCRYPT);
    $service = new UsuariosModel();
    if(!$service->inserir($nome, $email, $senhaCripto, $tipoUsuario)){
      throw new Exception("Ocorreu um erro ao inserir o usuário");
    }
  }
}

?>