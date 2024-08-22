<?php
  $eventos = AdminController::geraTabelaEventos();
?>
<body>
  <nav>
    <a class="btn" href="/gerenciadorEventos/admin/eventos/cadastro/form">Novo evento</a>  
    <a class="btn" href="">Gerar XML eventos</a>  
    <a class="btn" href="">Gerar PDF</a> 
  </nav>  
  <br>
  <div style="max-width: 20%" class="form-group">
    <label for="pesq">Pesquisar</label>
    <input type="search" name="pesq" id="pesq"> 
  </div>
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