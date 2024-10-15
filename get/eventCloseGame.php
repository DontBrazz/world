<?php 
require_once("classes/Controller.php");
require_once("classes/mysql/MySQLController.php");
require_once("classes/JSON.php");
$invoke = new Controller();
$mysql = new MySQL();
$json = new JSONS();
if (isset($_SESSION['nome'])) {
    $nome = $_SESSION['nome'];
    $alunosDaSala = $json->getAlunos($idSala);
    $key = $_SESSION['key'];
        $idC = $mysql->getIdRoom($key);
        $alunosC = $json->getAlunos($idC);
        if ($alunosC !== null) {
            foreach ($alunosC as $aluno) {
                if ($aluno['name'] === $nome) {
                    $json->removerAluno($nome, $idC);
                    return;
                }
            }
        }
        unset($_SESSION['nome']);
        unset($_SESSION['key']);
}

?>