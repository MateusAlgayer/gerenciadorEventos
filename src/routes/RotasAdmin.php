<?php

require_once 'src/controller/LayoutController.php';
require_once 'src/controller/AdminController.php';

class RotasAdmin {
  public static function dashboardView(){
    $navContent = '
    <a style="max-width: 52px" class="btn" href="/gerenciadorEventos/admin/logout">Logout</a>
    ';

    LayoutController::geraLayoutBase(__DIR__.'/../view/adminDashboard.php', $navContent);
  }

  public static function eventosForm(){
    LayoutController::geraLayoutBase(__DIR__.'/../view/eventoForm.php');
  }
}

?>