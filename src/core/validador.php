<?php

class Validador {
  public static function validaCampo(String $nomeCampo, $valorCampo){
    if(!isset($valorCampo)){
      throw new Exception("A requisição não possui o campo ".$nomeCampo);
    }
  }

}

?>