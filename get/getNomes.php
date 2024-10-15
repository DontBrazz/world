<?php
// Verifique se a chave foi passada na query string
require_once("../classes/Controller.php");
//require_once("classes/mysql/MySQLController.php");
require_once("../classes/JSON.php");
$invoke = new Controller();
$mysql = new MySQL();
$json = new JSONS();
$idSala = null;

$paises = $mysql->getPaisesCadastrado();
$nome = null;
foreach ($paises as $pais) {
    $nome[] = $pais['nomePais'];

}
// Retorna os dados como JSON
header('Content-Type: application/json');
echo json_encode($nome);
?>
