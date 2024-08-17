<?php

  require_once 'src/DAO/ParticipantesDAO.php';

  class ParticipantesModel {
    public function getParticipantes() : array {
      return (new ParticipantesDAO())->listar();
    }
  
    public function inserir($idEvento, String $nome, String $email, String $telefone) : bool {
      return (new ParticipantesDAO())->inserir($idEvento, $nome, $email, $telefone);
    }
  
    public function alterar($id, $idEvento, String $nome, String $email, String $telefone) : bool {
      return (new ParticipantesDAO())->alterar($id, $idEvento, $nome, $email, $telefone);
    }
  
    public function excluir($id, $idEvento) : bool {
      return (new ParticipantesDAO())->excluir($id, $idEvento);
    }
  }

?>