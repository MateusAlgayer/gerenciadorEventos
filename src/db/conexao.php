<?php

  function conectarBaseDados(){
    try {
      $pdo = new PDO("mysql:host=localhost;dbname=jubileueventos", "root", "");
      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      // echo "criou PDO";
      return $pdo;
    } catch (PDOException $e) {
      throw "Erro na conexão: ".$e->getMessage();
    }
  }

?>