<?php

class AdminController {
  public static function fazLogin(){
    if($_SERVER['REQUEST_METHOD'] !== 'POST'){
      throw new Exception("A requisição deve utilizar o método POST");
    }

    Validador::validaCampo('email');
    Validador::validaCampo('senha');

    $usuario = (new UsuariosModel())->getUsuario($_POST['email']);
    if(!isset($usuario) || !password_verify($_POST['senha'], $usuario['senha'])){
      throw new Exception("Usuário ou senha não estão corretos");
    }

    session_start();
    $_SESSION['usuario'] = $usuario;
    header("location: /gerenciadorEventos/admin/");
  }
  
  public static function fazLogout(){
    session_destroy();
    header("location: /gerenciadorEventos");
  }
}

?>