<?php

require_once 'src/core/api.php';
require_once 'src/model/EventosModel.php';

class AdminController {
  public static function geraTabelaEventos():String{
    $lista = (new EventosModel())->getEventos();

    $table = "";
    foreach ($lista as $evento) {
      $table = $table."<tr>
        <td>{$evento['TITULO']}</td>
        <td>{$evento['DESCRICAO']}</td>
        <td>{$evento['LOCAL']}</td>
        <td>{$evento['DATAEVENTO']}</td>
        <td>
          <form action='/gerenciadorEventos/admin/eventos/detalhes/form' method='POST'>
            <input type='hidden' value='{$evento['ID']}' name='id' id='id'>
            <button type='submit' class='btn'>Detalhes</button>
          </form>
          <form action='/gerenciadorEventos/admin/eventos/alteracao/form' method='POST'>
            <input type='hidden' value='{$evento['ID']}' name='id' id='id'>
            <button type='submit' class='btn'>Alterar</button>
          </form>
          <form action='/gerenciadorEventos/admin/eventos/excluir' method='POST'>
            <input type='hidden' value='{$evento['ID']}' name='id' id='id'>
            <button type='submit' class='btn'>Excluir</button>
          </form>
        </td>
      </tr>";
    }

    return $table;
  }
}

?>