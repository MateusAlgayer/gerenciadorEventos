<?php

class LayoutController {
  
  public static function geraLayoutBase(String $titulo, $conteudo){
    $title = $titulo;
    $content = $conteudo;
    include __DIR__.'/../view/layout.php';
  }
}

?>