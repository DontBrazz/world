<?php
// Verifique se a chave foi passada na query string
require_once("../classes/Controller.php");
//require_once("classes/mysql/MySQLController.php");
require_once("../classes/JSON.php");
$invoke = new Controller();
$mysql = new MySQL();
$json = new JSONS();
$nomePais = $_GET['nomePais'];
$idPais = $mysql->getIdPais($nomePais);
$imagem_blob = $mysql->getImagemPais($idPais);
$imagem_base64 = base64_encode($imagem_blob);
$imagem = 'data:image/jpeg;base64,' . $imagem_base64;
$categoria = $json->getCategorias($idPais);
$response = [
    'categoria' => $categoria,
    'imagem' => $imagem,
];

header('Content-Type: application/json');
echo json_encode($response);
?>
