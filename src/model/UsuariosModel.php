<?php

require_once 'src/DAO/UsuariosDAO.php';

class UsuariosModel {
  // public function getUsuarios() : array {
  //   return (new UsuariosDAO())->listar();
  // }

  public function inserir(String $nome, String $email, String $senha, String $tipoUsuario) : bool {
    return (new UsuariosDAO())->inserir($nome, $email, $senha, $tipoUsuario);
  }

  // public function alterar($id, String $nome, String $email, String $senha) : bool {
  //   return (new UsuariosDAO())->alterar($id, $nome, $email, $senha);
  // }

  // public function excluir($id) : bool {
  //   return (new UsuariosDAO())->excluir($id);
  // }

  public function getUsuario(String $email) {
    return (new UsuariosDAO())->getUsuario($email);
  }
}

?>