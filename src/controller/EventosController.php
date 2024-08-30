<?php

require_once 'src/core/api.php';
require_once 'src/model/EventosModel.php';
require_once 'src/core/validador.php';

class EventosController {
  public static function listar() : array {
    $service = new EventosModel();
    return $service->getEventos();
  }

  public static function listarAPI() : void{
    $service = new EventosModel();

    $result = [];
    $eventos = $service->getEventos();
    foreach ($eventos as $evento) {
      $result[] = array(
        'idEvento' => $evento['ID'],
        'titulo' => $evento['TITULO'],
        'descricao' => $evento['DESCRICAO'],
        'local' => $evento['LOCAL'],
        'data' => $evento['DATAEVENTO'],
        'participantes_id' => $evento['PARTICIPANTES_ID'],
      );
    }

    API::sendResponse($result);
  }

  public static function inserir() : void {
    if($_SERVER['REQUEST_METHOD'] !== 'POST'){
      throw new Exception("A requisição deve utilizar o método POST");
    }
    
    EventosController::inserirInterno($_POST['titulo'],$_POST['descricao'],$_POST['local'],$_POST['dataEvento']);
    header('location: /gerenciadorEventos/admin/');
  }
  
  public static function inserirInterno($titulo, $descricao, $local, $dataEvento) : void {
    Validador::validaCampo('titulo', $titulo);
    Validador::validaCampo('descricao', $descricao);
    Validador::validaCampo('local', $local);
    Validador::validaCampo('dataEvento', $dataEvento);
      
    $service = new EventosModel();
    if(!$service->inserir($titulo, $descricao, $local, new DateTimeImmutable($dataEvento))){
      throw new Exception("Ocorreu um erro ao inserir o evento");
    }
  }

  public static function alterar() : void {
    if($_SERVER['REQUEST_METHOD'] !== 'POST'){
      throw new Exception("A requisição deve utilizar o método POST");
    }
    
    EventosController::alterarInterno($_POST['id'],$_POST['titulo'],$_POST['descricao'],$_POST['local'],$_POST['dataEvento']);
    header('location: /gerenciadorEventos/admin/');
  }

  private static function alterarInterno($id, $titulo,$descricao,$local,$dataEvento) : void {
    Validador::validaCampo('id', $id);
    Validador::validaCampo('titulo', $titulo);
    Validador::validaCampo('descricao', $descricao);
    Validador::validaCampo('local', $local);
    Validador::validaCampo('dataEvento', $dataEvento);
      
    $service = new EventosModel();
    if(!$service->alterar($id, $titulo, $descricao, $local, new DateTimeImmutable($dataEvento))){
      throw new Exception("Ocorreu um erro ao alterar o evento");
    }
  }

  public static function excluir() : void {
    if($_SERVER['REQUEST_METHOD'] !== 'POST'){
      throw new Exception("A requisição deve utilizar o método POST");
    }
    
    EventosController::excluirInterno($_POST['id']);
    header('location: /gerenciadorEventos/admin/');
  }

  private static function excluirInterno($id) : void {
    Validador::validaCampo('id', $id);
    $service = new EventosModel();
    if(!$service->excluir($id)){
      throw new Exception("Ocorreu um erro ao excluir o evento");
    }
  }

  public static function getEventoPorId() : array{
    if($_SERVER['REQUEST_METHOD'] !== 'POST'){
      throw new Exception("A requisição deve utilizar o método POST");
    }

    return EventosController::getEventoPorIdInterno($_POST['id']);
  }

  public static function getEventoPorIdAPI() : void {
    if($_SERVER['REQUEST_METHOD'] !== 'POST'){
      throw new Exception("A requisição deve utilizar o método POST");
    }
    
    $dados = json_decode(file_get_contents("php://input"));
    
    $evento = EventosController::getEventoPorIdInterno($dados->id);
    API::sendResponse(array(
        'idEvento' => $evento['ID'],
        'titulo' => $evento['TITULO'],
        'descricao' => $evento['DESCRICAO'],
        'local' => $evento['LOCAL'],
        'data' => $evento['DATAEVENTO']
      )
    );
  }

  public static function getEventoPorIdInterno($id) : array {
    Validador::validaCampo('id', $id);

    return (new EventosModel())->getEventoPorId($id);
  }

  public static function geraXMLEventos() : void {
    $lista = (new EventosModel())->getEventos();

    $dom = new DOMDocument('1.0', 'UTF-8');
    $dom->preserveWhiteSpace = false;
    $dom->formatOutput = true;

    $root = $dom->createElement('eventos');

    foreach ($lista as $evento) {
      $eventoNode = $dom->createElement('evento');
      $eventoNode->appendChild($dom->createElement('titulo', $evento['TITULO']));
      $eventoNode->appendChild($dom->createElement('descricao', $evento['DESCRICAO']));
      $eventoNode->appendChild($dom->createElement('local', $evento['LOCAL']));
      $eventoNode->appendChild($dom->createElement('dataEvento', $evento['DATAEVENTO']));

      $participantesNode = $dom->createElement("participantes");
      $arrayParticipantes = explode(',', $evento['PARTICIPANTES']);
      foreach ($arrayParticipantes as $participante) {
        $aux = explode(' - ', $participante);
        if($aux[0] === ''){
          continue;
        }

        $participanteNode = $dom->createElement('participante');
        $participanteNode->appendChild($dom->createElement('nome', $aux[0]));
        $participanteNode->appendChild($dom->createElement('email', $aux[1]));
      
        $participantesNode->appendChild($participanteNode);
      }
      $eventoNode->appendChild($participantesNode);
      $root->appendChild($eventoNode);
    }

    $dom->appendChild($root);
    header('Content-Type: text/xml');
    echo $dom->saveXML();
  }

  public static function gerarPDF(){
    require 'src/library/fpdf/fpdf.php';
    $evento = EventosController::getEventoPorId();
    
    $pdf = new FPDF('P', 'pt', 'A4');
    $pdf->AddPage();
    $pdf->SetFont('Arial','B', 24);
    $pdf->Cell(0,30,EventosController::converteTexto($evento['TITULO']), 0, 1);
    $pdf->SetFont('Arial','B', 16);
    $pdf->Cell(0,20,EventosController::converteTexto("Descrição: {$evento['DESCRICAO']}"), 0, 1);
    $pdf->Cell(0,20,EventosController::converteTexto("Local: {$evento['LOCAL']}"), 0, 1);
    $data = date_format(new DateTime($evento['DATAEVENTO']), 'd/m/Y');
    $pdf->Cell(0,20,"Data do evento: {$data}", 0, 1);
    
    $pdf->Ln(12);
    $pdf->SetFont('Arial','B',24);
    $pdf->Cell(0,30, 'Participantes',0,1,'C');
    
    $pdf->SetFont('Arial','B',16);
    $pdf->Cell(250,30, 'Nome',1,0,'E');
    $pdf->Cell(290,30, 'E-mail',1,1,'E');

    $pdf->SetFont('Arial','B',12);
    $arrayParticipantes = explode(',', $evento['PARTICIPANTES']);
    foreach ($arrayParticipantes as $participante) {
      $aux = explode(' - ', $participante);
      if($aux[0] === ''){
        continue;
      }

      $pdf->Cell(250,30, EventosController::converteTexto($aux[0]),1,0,'E');
      $pdf->Cell(290,30, EventosController::converteTexto($aux[1]),1,1,'E');
    }
    
    $pdf->Output("Evento_{$evento['ID']}.pdf", 'I', true);
  }

  private static function converteTexto($texto){
    return mb_convert_encoding($texto, 'windows-1252', 'UTF-8');
  }
}

?>