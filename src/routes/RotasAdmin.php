<?php

require_once 'src/controller/LayoutController.php';

class RotasAdmin {
  public static function dashboardView(){
    LayoutController::geraLayoutBase(__DIR__.'/../view/registrarForm.html');
  }
}

?>