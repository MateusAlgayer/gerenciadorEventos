<?php

class LayoutController {
  
  public static function geraLayoutBase(String $titulo, $conteudo, String $navBarContent = ""){
    $title = $titulo;
    $content = $conteudo;
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