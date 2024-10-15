<?php
require_once("../classes/Controller.php");
require_once("../classes/mysql/MySQLController.php");
require_once("../classes/JSON.php");
$invoke = new Controller();
$mysql = new MySQL();
$json = new JSONS();
$id = null;

if (isset($_GET["id"])) {
    $id = $_GET["id"];
}
$alunos = $json->getCategorias($id);
// Retorna os dados como JSON
header('Content-Type: application/json');
echo json_encode($alunos);
