<?php

class EventosDAO {
  private $conexao;

  public function __construct(){
    include 'src/db/conexao.php';
    $this->conexao = conectarBaseDados();    
  }

  public function listar(): array{
    $smt = $this->conexao->query("SELECT * FROM EVENTOS");
    return $smt->fetchAll(PDO::FETCH_ASSOC);
  }

  public function inserir(String $titulo, String $descricao, String $local, DateTimeImmutable $data): bool {
    $smt = $this->conexao->prepare("INSERT INTO EVENTOS (TITULO, DESCRICAO, LOCAL, DATAEVENTO) VALUES (?,?,?,?)");

    $dataAsString = $data->format(DateTimeInterface::ATOM);
    $smt->bindParam(1, $titulo, PDO::PARAM_STR);
    $smt->bindParam(2, $descricao, PDO::PARAM_STR);
    $smt->bindParam(3, $local, PDO::PARAM_STR);
    $smt->bindParam(4, $dataAsString, PDO::PARAM_STR);
    return $smt->execute();
  }

  public function alterar($id, String $titulo, String $descricao, String $local, DateTimeImmutable $data): bool {
    $smt = $this->conexao->prepare("UPDATE EVENTOS SET TITULO = ?, DESCRICAO = ?, LOCAL = ?, DATAEVENTO = ? WHERE ID = ?");

    $dataAsString = $data->format(DateTimeInterface::ATOM);
    $smt->bindParam(1, $titulo, PDO::PARAM_STR);
    $smt->bindParam(2, $descricao, PDO::PARAM_STR);
    $smt->bindParam(3, $local, PDO::PARAM_STR);
    $smt->bindParam(4, $dataAsString, PDO::PARAM_STR);
    $smt->bindParam(5, $id, PDO::PARAM_INT);
    return $smt->execute();
  }

  public function excluir($id): bool {
    $smt = $this->conexao->prepare("DELETE FROM EVENTOS WHERE ID = ?");

    $smt->bindParam(1, $id, PDO::PARAM_INT);
    return $smt->execute();
  }

  public function getEventoPorId($id) : array {
    $smt = $this->conexao->prepare("SELECT * FROM EVENTOS WHERE ID = ?");

    $smt->bindParam(1, $id, PDO::PARAM_INT);
    if(!$smt->execute()){
      return [];
    }

    $evento = $smt->fetchAll(PDO::FETCH_ASSOC);
    if(count($evento) == 1){
      return $evento[0];
    }
    return [];
  }
}

?>