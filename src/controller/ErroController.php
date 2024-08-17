<?php

require_once 'src/utils/api.php';

class ErroController {

  public static function naoEncontrado() : void{
    include __DIR__.'/../view/naoEncontradoView.php';
  }

  public static function erro(String $msgErro) : void {
    $isAPI = explode('/', $_SERVER['REQUEST_URI'], 4)[2] === 'api';
    if($isAPI){
      ErroController::erroAPI($msgErro);
    } else {
      ErroController::erroTela($msgErro);
    }
  }

  private static function erroAPI(String $msgErro) : void {
    http_response_code(400);
    API::sendResponse($msgErro);
  }

  private static function erroTela(String $msgErro) : void{
    $msgErroTela = $msgErro;
    include __DIR__.'/../view/erroView.php';
  }
}

?>