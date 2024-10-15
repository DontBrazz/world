<?php
require_once("../classes/Controller.php");
require_once("../classes/mysql/MySQLController.php");
require_once("../classes/JSON.php");
$invoke = new Controller();
$mysql = new MySQL();
$json = new JSONS();


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['stage'])) {
        $chave = $_POST['key'];
        $num = $_POST['stage'];
        if ($num === 'sim') {
            $id = $mysql->getIdRoom($chave);
            $json->setStageMath($id,0);
            $json->setIniciado($id,'Nao');
            $alunos = $json->getAlunos($id);
            $alunoss = json_encode($alunos);

            $professor = "Sistema";
            $datas = date('Y-m-d');
            $stm = $mysql->getMySQL()->prepare("INSERT INTO history (chave,dates,professor,alunos) VALUES (:chave,:dates,:professor,:alunos)");
            $stm->bindValue(':chave',$chave);
            $stm->bindValue(':dates',$datas);
            $stm->bindValue(':professor',$professor);
            $stm->bindValue(':alunos',$alunoss);
            $stm->execute();
            $json->resetAluno($id);

            // Retorne o JSON
            echo json_encode(['resultado' => 'success']);
            exit;
        }
    } else {
        echo json_encode(['resultado' => false]); // Resposta padrão
        exit;
    }
}

?>