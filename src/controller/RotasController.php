<?php

require_once 'LayoutController.php';

class RotasController {

  public static function principalForm() : void {
    LayoutController::geraLayoutBase("Jubileu Eventos", 'teste');
  }

  public static function loginForm() : void {
    LayoutController::geraLayoutBase("Jubileu Eventos", 'teste');
  }

  public static function cadastroForm() : void {
    LayoutController::geraLayoutBase("Jubileu Eventos", 'teste');
  }
}

?>