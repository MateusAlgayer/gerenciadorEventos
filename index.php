<?php

require 'src/controller/RotasController.php';
require 'src/controller/AdminController.php';
require 'src/controller/EventosController.php';
require 'src/controller/ParticipantesController.php';
require 'src/controller/ErroController.php';

$CAMINHO_BASE = '/gerenciadorEventos';

$requisicao = $_SERVER['REQUEST_URI'];
//echo $requisicao;
try {
  switch ($requisicao) {
    //----------------- Eventos ------------------------------
    case $CAMINHO_BASE.'/api/eventos/listar':
      EventosController::listarAPI();
      break;
    case $CAMINHO_BASE.'/api/eventos/inserir':
      EventosController::inserirAPI();
      break;
    case $CAMINHO_BASE.'/api/eventos/alterar':
      EventosController::alterarAPI();      
      break;
    case $CAMINHO_BASE.'/api/eventos/excluir':
      EventosController::excluirAPI();
      break;    
    case $CAMINHO_BASE.'/api/eventos/participantes/listar':
      ParticipantesController::listarAPI();
      break;
    case $CAMINHO_BASE.'/api/eventos/participantes/inserir':
      ParticipantesController::inserirAPI();
      break;
    case $CAMINHO_BASE.'/api/eventos/participantes/alterar':
      ParticipantesController::alterarAPI();
      break;
    case $CAMINHO_BASE.'/api/eventos/participantes/excluir':
      ParticipantesController::excluirAPI();
      break;
    //WEB - Requer Autenticação Admin
    case $CAMINHO_BASE.'/web/admin/eventos/listar':
      break;
    case $CAMINHO_BASE.'/web/admin/eventos/cadastro/form':
      break;
    case $CAMINHO_BASE.'/web/admin/eventos/alteracao/form':
      break;
    //---------------- Fim Eventos -----------------------

    //---------------- Principal -------------------------
    case $CAMINHO_BASE.'/':
      RotasController::principalForm();
      break;
    case $CAMINHO_BASE.'/login/form':
      RotasController::loginForm();
      break;
    //---------------- Admin -----------------------------
    //API
    case $CAMINHO_BASE.'/api/admin/inserir':
      break;
    //WEB
    case $CAMINHO_BASE.'/web/admin/cadastro/form':
      break;
    case $CAMINHO_BASE.'/web/admin/login':
      AdminController::fazLogin();
      break;
    case $CAMINHO_BASE.'/web/admin/logout':
      AdminController::fazLogout();
      break;
    //---------------- Fim Admin -------------------------
    default:
      ErroController::naoEncontrado();
      break;
  }
} catch (\Exception $th) {
  ErroController::erro($th->getMessage());
}