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
    API::sendResponse($service->getEventos());
  }

  // public static function formInserir(){
  //   $acao = '/mvc/carros/marca/inserir';
  //   include __DIR__.'/../view/marcaForm.php';
  // }

  public static function inserir() : void {
    EventosController::inserirInterno();
    header('location: /gerenciadorEventos/admin/');
  }
  
  // public static function inserirAPI() : void {
  //   EventosController::inserirInterno();
  //   API::sendResponse($_POST);
  // }

  public static function inserirInterno() : void {
    if($_SERVER['REQUEST_METHOD'] !== 'POST'){
      throw new Exception("A requisição deve utilizar o método POST");
    }

    Validador::validaCampo('titulo');
    Validador::validaCampo('descricao');
    Validador::validaCampo('local');
    Validador::validaCampo('dataEvento');
      
    $service = new EventosModel();
    if(!$service->inserir($_POST['titulo'], $_POST['descricao'], $_POST['local'], new DateTimeImmutable($_POST['dataEvento']))){
      throw new Exception("Ocorreu um erro ao inserir o evento");
    }
  }

  public static function alterar() : void {
    EventosController::alterarInterno();
    header('location: /gerenciadorEventos/admin/');
  }

  // public static function alterarAPI() : void {
  //   EventosController::alterarInterno();
  //   API::sendResponse($_POST);
  // }

  private static function alterarInterno() : void {
    if($_SERVER['REQUEST_METHOD'] !== 'POST'){
      throw new Exception("A requisição deve utilizar o método POST");
    }

    Validador::validaCampo('id');
    Validador::validaCampo('titulo');
    Validador::validaCampo('descricao');
    Validador::validaCampo('local');
    Validador::validaCampo('dataEvento');
      
    $service = new EventosModel();
    if(!$service->alterar($_POST['id'], $_POST['titulo'], $_POST['descricao'], $_POST['local'], new DateTimeImmutable($_POST['dataEvento']))){
      throw new Exception("Ocorreu um erro ao alterar o evento");
    }
  }

  public static function excluir() : void {
    EventosController::excluirInterno();
    header('location: /gerenciadorEventos/admin/');
  }

  // public static function excluirAPI() : void {
  //   EventosController::excluirInterno();
  //   API::sendResponse($_POST);
  // }

  private static function excluirInterno() : void {
    if($_SERVER['REQUEST_METHOD'] !== 'POST'){
      throw new Exception("A requisição deve utilizar o método POST");
    }

    Validador::validaCampo('id');
    $service = new EventosModel();
    if(!$service->excluir($_POST['id'])){
      throw new Exception("Ocorreu um erro ao excluir o evento");
    }
  }

  public static function getEventoPorId() : array{
    return EventosController::getEventoPorIdInterno();
  }

  public static function getEventoPorIdAPI() : void {
    API::sendResponse(EventosController::getEventoPorIdInterno());
  }

  public static function getEventoPorIdInterno() : array {
    if($_SERVER['REQUEST_METHOD'] !== 'POST'){
      throw new Exception("A requisição deve utilizar o método POST");
    }

    Validador::validaCampo('id');

    return (new EventosModel())->getEventoPorId($_POST['id']);
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

  public static function geraPDFEvento($id) : void {
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