<?php
  if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $acao = 'alterar';
    $evento = EventosController::getEventoPorId();
  } else {
    $acao = 'inserir';
    $evento = [
      'ID'=> '',
      'TITULO'=> '',
      'DESCRICAO'=> '',
      'LOCAL'=> '',
      'DATAEVENTO'=> '',
    ];
  }
?>

<div class="login-align">
  <div class="login-container">
    <h2>Cadastrar evento</h2>
    <form  action="/gerenciadorEventos/admin/eventos/<?=$acao?>" method="post">
      <input type="hidden" id="id" name="id" value="<?=$evento['ID']?>" required>
      <div class="form-group">
        <label for="titulo">Título</label>
        <input type="text" id="titulo" name="titulo" value="<?=$evento['TITULO']?>" required>
      </div>
      <div class="form-group">
        <label for="descricao">Descrição</label>
        <input type="text" id="descricao" name="descricao" value="<?=$evento['DESCRICAO']?>" required>
      </div>
      <div class="form-group">
        <label for="local">Local</label>
        <input type="text" id="local" name="local" value="<?=$evento['LOCAL']?>" required>
      </div>
      <div class="form-group">
        <label for="dataEvento">Data</label>
        <input type="date" id="dataEvento" name="dataEvento" value="<?=$evento['DATAEVENTO']?>" required>
      </div>
      <div class="form-group">
        <button class="btn" type="submit">Salvar</button>
      </div>
    </form>
    <hr class="solid">
    <a class="btn" href="/gerenciadorEventos/admin/">Voltar</a>
  </div>
</div>