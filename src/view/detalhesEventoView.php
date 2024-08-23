<?php
  require_once 'src/controller/EventosController.php';
  require_once 'src/controller/ParticipantesController.php';
  
  $evento = EventosController::getEventoPorId();
  $participantes = ParticipantesController::geraTabelaParticipante();
?>
<div class="login-align">
  <div class="login-container">
    <a class="btn" href="/gerenciadorEventos/admin/">Voltar</a>
    <br>
    <br>
    <form action="/gerenciadorEventos/admin/eventos/gerarPDF" method="post" target="_blank">
      <input type="hidden" value="<?=$evento['ID']?>" name='id' id='id'>
      <button type="submit" class="btn" href="">Gerar PDF</button>
    </form>
    <h2><?= $evento['TITULO']?></h2>
    <hr class="solid">
    <p>Descrição: <?= $evento['DESCRICAO']?></p>    
    <p>Local: <?= $evento['LOCAL']?></p>    
    <p>Data do evento: <?= date_format(new DateTime($evento['DATAEVENTO']), 'd/m/Y')?></p>    
    <table>
      <caption>Participantes</caption>
      <thead>
        <tr>
          <th>Nome</th>
          <th>E-mail</th>
        </tr>
      </thead>
      <tbody>
          <?=$participantes?>
      </tbody>
    </table>  
  </div>
</div>