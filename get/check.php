<?php
require_once("../classes/Controller.php");
require_once("../classes/mysql/MySQLController.php");
require_once("../classes/JSON.php");
$invoke = new Controller();
$mysql = new MySQL();
$json = new JSONS();


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['teste'])) {
        $chave = $_POST['key'];
        $num = $_POST['teste'];
        $num = $num + 1;
        $id = $mysql->getIdRoom($chave);
        $json->setStageMath($id,$num);
        // Retorne o JSON
        echo json_encode(['resultado' => $num]);
        exit;
    } else {
        echo json_encode(['resultado' => false]); // Resposta padrão
        exit;
    }
}

?>