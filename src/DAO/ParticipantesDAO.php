<?php

  class ParticipantesDAO {
    private $conexao;

    public function __construct(){
      include_once 'src/db/conexao.php';
      $this->conexao = conectarBaseDados();    
    }

    public function listar($idEvento): array{
      $smt = $this->conexao->prepare('
        SELECT P.IDUSUARIO, P.IDEVENTO, U.NOMEUSUARIO, U.EMAIL, U.REGISTROCRIADO
        FROM PARTICIPANTES P
          LEFT OUTER JOIN USUARIOS U ON P.IDUSUARIO = U.ID
        WHERE P.IDEVENTO = ?
      ');

      $smt->bindParam(1, $idEvento, PDO::PARAM_INT);
      if(!$smt->execute()){
        return [];
      }

      return $smt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function inserir($idUsuario, $idEvento): bool {
      $smt = $this->conexao->prepare("INSERT INTO PARTICIPANTES (IDUSUARIO, IDEVENTO) VALUES (?,?)");

      $smt->bindParam(1, $idUsuario, PDO::PARAM_INT);
      $smt->bindParam(2, $idEvento, PDO::PARAM_INT);
      return $smt->execute();
    }

    public function excluir($idUsuario, $idEvento): bool {
      $smt = $this->conexao->prepare("DELETE FROM PARTICIPANTES WHERE IDUSUARIO = ? AND IDEVENTO = ?");

      $smt->bindParam(1, $idUsuario, PDO::PARAM_INT);
      $smt->bindParam(2, $idEvento, PDO::PARAM_INT);
      return $smt->execute();
    }
  }

?>