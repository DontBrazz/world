<?php
// Verifique se a chave foi passada na query string
require_once("../classes/Controller.php");
require_once("../classes/mysql/MySQLController.php");
require_once("../classes/JSON.php");
$invoke = new Controller();
$mysql = new MySQL();
$json = new JSONS();
$idSala = null;

if (isset($_GET["chave"])) {
    $chave = $_GET["chave"];
    $idSala = $mysql->getIdRoom($chave);
}
$alunos = $json->getAlunos($idSala);
header('Content-Type: application/json');
echo json_encode($alunos);
