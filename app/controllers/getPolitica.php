<?php

header("Content-Type: application/json");

require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../models/politica.php';

require_once __DIR__ . '/../../protected/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../protected');
$dotenv->load();

$database = new Database();
$db = $database->conectar();

$politica = new Politica($db);

// 🔍 Decide qual versão buscar
if (isset($_GET['historico'])) {
    $versoes = $politica->getTodasVersoes();
    echo json_encode($versoes);
    exit;
}
if (isset($_GET['versao'])) {
    $dados = $politica->getPorVersao($_GET['versao']);
}else {
    $dados = $politica->getVersaoAtiva();
}


// ❌ nenhum dado
if (!$dados || count($dados) === 0) {
    echo json_encode(["erro" => "Nenhuma política encontrada"]);
    exit;
}

// 🧠 dados globais
$titulo = $dados[0]['titulo'];
$versao = $dados[0]['versao']; // precisa existir na tabela
$data = $dados[0]['data_publicacao'];
$ano = date("Y", strtotime($data));

// 🧱 monta resposta
$resposta = [
    "titulo" => $titulo,
    "versao" => $versao,
    "ano" => $ano,
    "data_atualizacao" => date("d/m/Y", strtotime($data)),
    "topicos" => []
];

// 📚 tópicos
$topicos = [];

foreach ($dados as $linha) {
    $topico = $linha["topico"];

    if (!isset($topicos[$topico])) {
        $topicos[$topico] = [
            "topico" => $topico,
            "conteudo" => $linha["conteudo"]
        ];
    } else {
        // concatena conteúdo se repetir
        $topicos[$topico]["conteudo"] .= "\n\n" . $linha["conteudo"];
    }
}

$resposta["topicos"] = array_values($topicos);

echo json_encode($resposta, JSON_UNESCAPED_UNICODE);