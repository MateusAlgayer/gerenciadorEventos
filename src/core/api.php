<?php

  class API {
    public static function sendResponse($response){
      header('Content-Type: application/json; charset=utf-8');
      echo json_encode($response);
    }
  }

?>