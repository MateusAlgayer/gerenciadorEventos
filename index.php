<?php

require 'src/controller/RotasController.php';
require 'src/controller/AdminController.php';
require 'src/controller/EventosController.php';
require 'src/controller/ParticipantesController.php';
require 'src/controller/UsuariosController.php';
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
      EventosController::listar();
      break;
    case $CAMINHO_BASE.'/web/admin/eventos/cadastro/form':
      EventosController::inserir();
      break;
    case $CAMINHO_BASE.'/web/admin/eventos/alteracao/form':
      EventosController::alterar();
      break;
    case $CAMINHO_BASE.'/web/admin/eventos/excluir':
      EventosController::excluir();
      break;
    //---------------- Fim Eventos -----------------------
    case $CAMINHO_BASE.'/':
      RotasController::principalForm();
      break;
    case $CAMINHO_BASE.'/login/form':
      RotasController::loginForm();
      break;
    case $CAMINHO_BASE.'/cadastro/form':
      RotasController::cadastroForm();
      break;
    //---------------- Admin -----------------------------
    //API
    case $CAMINHO_BASE.'/api/admin/usuario/inserir':
      UsuariosController::inserirAPI();
      break;
    //WEB
    case $CAMINHO_BASE.'api/admin/usuario/alterar':
      UsuariosController::alterarAPI();
      break;
    case $CAMINHO_BASE.'api/admin/usuario/excluir':
      UsuariosController::excluirAPI();
      break;
    //TODO: AdminRotasController
    case $CAMINHO_BASE.'/web/admin/eventos/alteracao/form':
      // EventosController::alterar();
      break;
    case $CAMINHO_BASE.'/web/admin/eventos/excluir':
      // EventosController::excluir();
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