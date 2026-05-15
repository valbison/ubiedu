<?php

// Pega a URL acessada pelo usuário
$request = $_SERVER['REQUEST_URI'];

// Remove parâmetros (ex: ?id=1)
$request = parse_url($request, PHP_URL_PATH);

// Remove barra final (pra padronizar)
$request = rtrim($request, '/');

// Se ficar vazio, volta pra "/"
$request = $request === '' ? '/' : $request;


/*
|--------------------------------------------------------------------------
| ROTAS PRINCIPAIS
|--------------------------------------------------------------------------
*/

// Landing Page (home)
if ($request === '/') {
    require __DIR__ . '/landing/index.html';
    exit;
}


/*
|--------------------------------------------------------------------------
| ROTAS DA APLICAÇÃO
|--------------------------------------------------------------------------
| Tudo que não for "/" vai pra plataforma
*/

// Você pode futuramente filtrar rotas específicas aqui
// Exemplo:
// if (strpos($request, '/api') === 0) { ... }

require __DIR__ . '/public/index.html';
exit;