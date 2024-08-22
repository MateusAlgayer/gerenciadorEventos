<?php

class LayoutController {
  
  public static function geraLayoutBase($conteudo, String $navBarContent = ""){
    $content = LayoutController::getConteudo($conteudo);
    $navContent = $navBarContent;
    include __DIR__.'/../view/layout.php';
  }

  private static function getConteudo(String $conteudo): String{
    ob_start();
    include $conteudo;
    return ob_get_clean();
  }
}

?>