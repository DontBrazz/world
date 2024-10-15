<?php
require_once("../classes/Controller.php");
require_once("../classes/mysql/MySQLController.php");
require_once("../classes/JSON.php");
$invoke = new Controller();
$mysql = new MySQL();
$json = new JSONS();



if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['key'])) {
        $chave = $_POST['key'];
        $nome = $_SESSION['nome'];
        $id = $mysql->getIdRoom($chave);
        $json->updatePoints( $nome, $id, -5,false);
        $points = $json->getPoints($nome,$id);

        echo json_encode(['points' => $points]);
        exit;
    } else {
        echo json_encode(['resultado' => false]); // Resposta padrão
        exit;
    }
}

?>