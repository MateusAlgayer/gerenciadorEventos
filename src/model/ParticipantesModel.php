<?php

  require_once 'src/DAO/ParticipantesDAO.php';

  class ParticipantesModel {
    public function getParticipantes($id) : array {
      return (new ParticipantesDAO())->listar($id);
    }
  
    public function inserir($idUsuario, $idEvento) : bool {
      return (new ParticipantesDAO())->inserir($idUsuario, $idEvento);
    }
  
    public function excluir($idUsuario, $idEvento) : bool {
      return (new ParticipantesDAO())->excluir($idUsuario, $idEvento);
    }
  }

?>