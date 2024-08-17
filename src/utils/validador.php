<?php

class Validador {
  public static function validaCampo(String $nomeCampo){
    if(!isset($_POST[$nomeCampo])){
      throw new Exception("A requisição não possui o campo ".$nomeCampo);
    }
  }

}

?>