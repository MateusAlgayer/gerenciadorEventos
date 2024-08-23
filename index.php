<?php

require_once 'src/controller/AdminController.php';
require_once 'src/controller/EventosController.php';
require_once 'src/controller/ParticipantesController.php';
require_once 'src/controller/UsuariosController.php';
require_once 'src/controller/ErroController.php';
require_once 'src/controller/AcessoController.php';
require_once 'src/routes/Rotas.php';
require_once 'src/routes/RotasAdmin.php';

$CAMINHO_BASE = '/gerenciadorEventos';

$requisicao = $_SERVER['REQUEST_URI'];
try {
  $usaAutenticacao = explode('/', $_SERVER['REQUEST_URI'], 4)[2] === 'admin';
  if($usaAutenticacao && !AcessoController::usuarioEstaLogado()){
    //vai cair em não encontrado.
    $requisicao = "";
  }

  switch ($requisicao) {
    //----------------- Eventos ------------------------------
    case $CAMINHO_BASE.'/api/eventos/listar':
      EventosController::listarAPI();
      break;
    case $CAMINHO_BASE.'/api/eventos/getEvento':
      EventosController::getEventoPorIdAPI();
      break;
    case $CAMINHO_BASE.'/api/eventos/participantes/listar':
      ParticipantesController::listarAPI();
      break;
    case $CAMINHO_BASE.'/api/eventos/participantes/inserir':
      ParticipantesController::inserirAPI();
      break;
    case $CAMINHO_BASE.'/api/eventos/participantes/excluir':
      ParticipantesController::excluirAPI();
      break;
    case $CAMINHO_BASE.'/api/usuario/inserir':
      UsuariosController::inserirAPI();
      break;
    case $CAMINHO_BASE.'/api/login':
      AcessoController::fazLoginAPI();
      break;
    //---------------- FIM APIS ---------------------------
    case $CAMINHO_BASE.'/':
      Rotas::principalForm();
      break;
    case $CAMINHO_BASE.'/cadastro/form':
      Rotas::cadastroForm();
      break;
    case $CAMINHO_BASE.'/login':
      AcessoController::fazLogin();
      break;
    case $CAMINHO_BASE.'/usuario/inserir':
      UsuariosController::inserir();
      break;
    //---------------- Admin -----------------------------
    case $CAMINHO_BASE.'/admin/':
      RotasAdmin::dashboardView();
      break;
    case $CAMINHO_BASE.'/admin/eventos/cadastro/form':
      RotasAdmin::eventosForm();
      break;
    case $CAMINHO_BASE.'/admin/eventos/alteracao/form':
      RotasAdmin::eventosForm();
      break;
    case $CAMINHO_BASE.'/admin/eventos/detalhes/form':
      RotasAdmin::detalhesEventoView();
      break;
    case $CAMINHO_BASE.'/admin/logout':
      AcessoController::fazLogout();
      break;
    case $CAMINHO_BASE.'/admin/eventos/inserir':
      EventosController::inserir();
      break;
    case $CAMINHO_BASE.'/admin/eventos/alterar':
      EventosController::alterar();      
      break;
    case $CAMINHO_BASE.'/admin/eventos/excluir':
      EventosController::excluir();
      break;
    //---------------- Fim Admin -------------------------
    default:
      ErroController::naoEncontrado();
      break;
  }
} catch (\Exception $th) {
  ErroController::erro($th->getMessage());
}