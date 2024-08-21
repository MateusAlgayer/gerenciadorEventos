<?php

require_once 'src/controller/LayoutController.php';

class Rotas {

  public static function principalForm() : void {
    LayoutController::geraLayoutBase(__DIR__.'/../view/loginForm.html');
  }

  public static function cadastroForm() : void {
    LayoutController::geraLayoutBase(__DIR__.'/../view/registrarForm.html');
  }
}

?>