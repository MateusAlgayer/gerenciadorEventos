<?php

require_once 'src/core/validador.php';
require_once 'src/core/api.php';
require_once 'src/model/UsuariosModel.php';

class AcessoController {
  
  public static function fazLogin(){
    $usuarioLogado = AcessoController::fazLoginInterno();

    if($usuarioLogado['tipoUsuario'] <> 'A'){
      throw new Exception("O usuário informado não possui acesso a plataforma Web");
    }

    session_start();
    var_dump($_SESSION);
    $_SESSION['usuario'] = $usuarioLogado;
    header("location: /gerenciadorEventos/admin/");
  }

  public static function fazLoginAPI() : void {
    API::sendResponse(AcessoController::fazLoginInterno());
  }

  private static function fazLoginInterno() : array{
    if($_SERVER['REQUEST_METHOD'] !== 'POST'){
      throw new Exception("A requisição deve utilizar o método POST");
    }

    Validador::validaCampo('email');
    Validador::validaCampo('senha');

    $usuario = (new UsuariosModel())->getUsuario($_POST['email']);
    if(!isset($usuario) || !password_verify($_POST['senha'], $usuario['senha'])){
      throw new Exception("Usuário ou senha não estão corretos");
    }

    if($usuario['tipoUsuario'] <> 'A'){
      throw new Exception("O usuário informado não possui acesso a plataforma Web");
    }

    return $usuario;
  }
  
  public static function fazLogout(){
    session_destroy();
    header("location: /gerenciadorEventos");
  }
  
  static public function usuarioEstaLogado() : bool {
    session_start();
    return isset($_SESSION['usuario']);
  }
}

?>