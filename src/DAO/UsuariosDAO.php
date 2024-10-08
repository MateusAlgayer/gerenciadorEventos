<?php

  class UsuariosDAO {
    private $conexao;

    public function __construct(){
      include_once 'src/db/conexao.php';
      $this->conexao = conectarBaseDados();    
    }

    // public function listar(): array{
    //   $smt = $this->conexao->query("SELECT * FROM USUARIOS");
    //   return $smt->fetchAll(PDO::FETCH_ASSOC);
    // }

    public function inserir(String $nome, String $email, String $senha, String $tipoUsuario): bool {
      $smt = $this->conexao->prepare("INSERT INTO USUARIOS (NOMEUSUARIO, EMAIL, SENHA, TIPOUSUARIO) VALUES (?,?,?,?)");

      $smt->bindParam(1, $nome, PDO::PARAM_STR);
      $smt->bindParam(2, $email, PDO::PARAM_STR);
      $smt->bindParam(3, $senha, PDO::PARAM_STR);
      $smt->bindParam(4, $tipoUsuario, PDO::PARAM_STR);
      return $smt->execute();
    }

    public function alterar($id, String $nome, String $email, String $senha): bool {
      $smt = $this->conexao->prepare("UPDATE USUARIOS SET NOMEUSUARIO = ?, EMAIL = ?, SENHA = ? WHERE ID = ?");

      $smt->bindParam(1, $nome, PDO::PARAM_STR);
      $smt->bindParam(2, $email, PDO::PARAM_STR);
      $smt->bindParam(3, $senha, PDO::PARAM_STR);
      $smt->bindParam(4, $tipoUsuario, PDO::PARAM_STR);
      return $smt->execute();
    }

    // public function alterar($id, String $nome, String $email, String $senha): bool {
    //   $smt = $this->conexao->prepare("UPDATE USUARIOS SET NOME = ?, EMAIL = ?, SENHA = ? WHERE ID = ?");

    //   $smt->bindParam(1, $nome, PDO::PARAM_STR);
    //   $smt->bindParam(2, $email, PDO::PARAM_STR);
    //   $smt->bindParam(3, $senha, PDO::PARAM_STR);
    //   $smt->bindParam(4, $id, PDO::PARAM_INT);
    //   return $smt->execute();
    // }

    // public function excluir($id): bool {
    //   $smt = $this->conexao->prepare("DELETE FROM USUARIOS WHERE ID = ?");

    //   $smt->bindParam(1, $id, PDO::PARAM_INT);
    //   return $smt->execute();
    // }

    public function getUsuario(String $email){
      $smt = $this->conexao->prepare("SELECT ID, NOMEUSUARIO, SENHA, EMAIL, TIPOUSUARIO 
        FROM USUARIOS 
        WHERE EMAIL = ?
      ");

      $smt->bindParam(1, $email, PDO::PARAM_STR);
      if(!$smt->execute()){
        return [];
      }

      $usuarios = $smt->fetchAll(PDO::FETCH_ASSOC);
      if(count($usuarios) == 1){
        return $usuarios[0];
      }
      return [];
    }
  }

?>