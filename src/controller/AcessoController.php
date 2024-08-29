<?php

require_once 'src/core/validador.php';
require_once 'src/core/api.php';
require_once 'src/model/UsuariosModel.php';

class AcessoController {
  
  public static function fazLogin(){
    if($_SERVER['REQUEST_METHOD'] !== 'POST'){
      throw new Exception("A requisição deve utilizar o método POST");
    }
    
    $usuarioLogado = AcessoController::fazLoginInterno($_POST['email'], $_POST['senha']);

    if($usuarioLogado['TIPOUSUARIO'] <> 'A'){
      throw new Exception("O usuário informado não possui acesso a plataforma Web");
    }

    session_start();
    //var_dump($_SESSION);
    $_SESSION['usuario'] = $usuarioLogado;
    header("location: /gerenciadorEventos/admin/");
  }

  public static function fazLoginAPI() : void {
    if($_SERVER['REQUEST_METHOD'] !== 'POST'){
      throw new Exception("A requisição deve utilizar o método POST");
    }
    
    $dados = json_decode(file_get_contents("php://input"));
    $usuario = AcessoController::fazLoginInterno($dados->login, $dados->senha);
    API::sendResponse(
      array(
        'idUsuario' => $usuario['ID'],
        'nome' => $usuario['NOMEUSUARIO'],
        'email' => $usuario['EMAIL'],
        'login' => $usuario['EMAIL'],
        'senha' => $usuario['SENHA']
      )
    );
  }

  private static function fazLoginInterno(String $email, String $senha) : array{
    Validador::validaCampo('email', $email);
    Validador::validaCampo('senha', $senha);

    $usuario = (new UsuariosModel())->getUsuario($email);
    if(!isset($usuario) || !password_verify($senha, $usuario['SENHA'])){
      throw new Exception("Usuário ou senha não estão corretos");
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