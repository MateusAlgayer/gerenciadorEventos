<?php

require 'src/controller/AdminController.php';
require 'src/controller/EventosController.php';
require 'src/controller/ParticipantesController.php';
require 'src/controller/UsuarioController.php';
require 'src/controller/ErroController.php';
require 'src/controller/AcessoController.php';

$CAMINHO_BASE = '/gerenciadorEventos';

$requisicao = $_SERVER['REQUEST_URI'];
try {
  $usaAutenticacao = explode('/', $_SERVER['REQUEST_URI'], 4)[2] === 'admin';
  if($usaAutenticacao && !AcessoController::usuarioEstaLogado()){
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
    case $CAMINHO_BASE.'/api/eventos/participantes/alterar':
      ParticipantesController::alterarAPI();
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
    //API
    case $CAMINHO_BASE.'/admin/eventos/cadastro/form':
      RotasAdmin::eventosForm();
      break;
    //WEB
    case $CAMINHO_BASE.'admin/eventos/alteracao/form':
      RotasAdmin::eventosForm();
      break;
    case $CAMINHO_BASE.'/admin/eventos/detalhes/form':
      RotasAdmin::eventosForm();
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