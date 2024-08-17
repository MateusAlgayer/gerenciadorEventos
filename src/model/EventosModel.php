<?php

require_once 'src/DAO/EventosDAO.php';

class EventosModel {
  public function getEventos() : array {
    return (new EventosDAO())->listar();
  }

  public function inserir(String $titulo, String $descricao, String $local, DateTimeImmutable $data) : bool {
    return (new EventosDAO())->inserir($titulo, $descricao, $local, $data);
  }

  public function alterar($id, String $titulo, String $descricao, String $local, DateTimeImmutable $data) : bool {
    return (new EventosDAO())->alterar($id, $titulo, $descricao, $local, $data);
  }

  public function excluir($id) : bool {
    return (new EventosDAO())->excluir($id);
  }
}

?>