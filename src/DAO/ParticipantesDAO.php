<?php

  class ParticipantesDAO {
    private $conexao;

    public function __construct(){
      include 'src/db/conexao.php';
      $this->conexao = conectarBaseDados();    
    }

    public function listar(): array{
      $smt = $this->conexao->query("SELECT * FROM PARTICIPANTES");
      return $smt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function inserir($idEvento, String $nome, String $email, String $telefone): bool {
      $smt = $this->conexao->prepare("INSERT INTO PARTICIPANTES (IDEVENTO, NOME, EMAIL, TELEFONE) VALUES (?,?,?,?)");

      $smt->bindParam(1, $idEvento, PDO::PARAM_INT);
      $smt->bindParam(2, $nome, PDO::PARAM_STR);
      $smt->bindParam(3, $email, PDO::PARAM_STR);
      $smt->bindParam(4, $telefone, PDO::PARAM_STR);
      return $smt->execute();
    }

    public function alterar($id, $idEvento, String $nome, String $email, String $telefone): bool {
      $smt = $this->conexao->prepare("UPDATE PARTICIPANTES SET NOME = ?, EMAIL = ?, TELEFONE = ? WHERE ID = ? AND IDEVENTO = ?");

      $smt->bindParam(1, $nome, PDO::PARAM_STR);
      $smt->bindParam(2, $email, PDO::PARAM_STR);
      $smt->bindParam(3, $telefone, PDO::PARAM_STR);
      $smt->bindParam(4, $id, PDO::PARAM_INT);
      $smt->bindParam(5, $idEvento, PDO::PARAM_INT);
      return $smt->execute();
    }

    public function excluir($id, $idEvento): bool {
      $smt = $this->conexao->prepare("DELETE FROM PARTICIPANTES WHERE ID = ? AND IDEVENTO = ?");

      $smt->bindParam(1, $id, PDO::PARAM_INT);
      $smt->bindParam(2, $idEvento, PDO::PARAM_INT);
      return $smt->execute();
    }
  }

?>