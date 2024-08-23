<?php
  if(isset($_POST['pesq'])){
    $argPesq = $_POST['pesq'];
  } else {
    $argPesq = '';
  }
  $eventos = AdminController::geraTabelaEventos($argPesq);
?>
<body>
  <nav>
    <a class="btn" href="/gerenciadorEventos/admin/eventos/cadastro/form">Novo evento</a>
    <a class="btn" href="/gerenciadorEventos/admin/eventos/xml">Gerar XML eventos</a>
  </nav>  
  <br>
  <form method="POST">
    <div style="max-width: 20%" class="form-group">
      <label for="pesq">Pesquisar</label>
      <input type="search" name="pesq" id="pesq" value="<?=$argPesq?>"> 
      <button style="max-width: 120px" class="btn" type="submit">Pesquisar</button>
    </div>
  </form>
  <table>
    <caption>Eventos</caption>
    <thead>
        <tr>
            <th>Título</th>
            <th>Descrição</th>
            <th>Local</th>
            <th>Data</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
        <?=$eventos?>
    </tbody>
  </table>
</body>