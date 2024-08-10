<?php

$requisicao = $_SERVER['REQUEST_URI'];
switch ($requisicao) {
    //----------------- Eventos ------------------------------
    //API - Requer a autenticação da API (Decidir qual vai ser)
    case '/api/eventos/listar':
      break;
    case '/api/eventos/inserir':
      break;
    case '/api/eventos/alterar':
      break;
    case '/api/eventos/excluir':
      break;    
    case '/api/eventos/participantes/listar':
      break;
    case '/api/eventos/participantes/inserir':
      break;
    case '/api/eventos/participantes/alterar':
      break;
    case '/api/eventos/participantes/excluir':
      break;
    //WEB - Requer Autenticação Admin
    case '/web/eventos/cadastro/form':
      break;
    case '/web/eventos/alteracao/form':
      break;
    //---------------- Fim Eventos -----------------------
    //---------------- Admin ---------------------------------
    //API
    case '/api/admin/inserir':
      break;
    //WEB
    case '/web/admin/cadastro/form':
      break;
    case '/web/admin/login':
      break;
    case '/web/admin/logout':
      break;
    //---------------- Fim Admin -----------------------------
    default:
      // Não encontrado  
      break;
}