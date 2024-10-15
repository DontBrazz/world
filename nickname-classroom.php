<?php
require_once("classes/Controller.php");
require_once("classes/mysql/MySQLController.php");
require_once("classes/JSON.php");
$invoke = new Controller();
$mysql = new MySQL();
$json = new JSONS();
$idSala = null;
$chave = null;

if (isset($_GET["chave"])) {
    $chave = $_GET["chave"];
    $idSala = $mysql->getIdRoom($chave);
    $iniciado = $json->getIniciado($idSala);
    if ($iniciado === "Sim") {
        header('Location: ./index.php');
        exit;
    }
}
if (isset($_SESSION['nome'])) {
    $nome = $_SESSION['nome'];
    $alunosDaSala = $json->getAlunos($idSala);
    if ($alunosDaSala !== null && $_SESSION['key'] == $chave) {
        foreach ($alunosDaSala as $aluno) {
            if ($aluno['name'] == $nome) {
                header( 'Location: ./classroom-waiting.php?chave=' . $chave);
                exit;
            }
        }
    } else {
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
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['entrar'])) {
        $nome = $_POST['nome'];
        try {
            $json->addAluno($nome, 0, $idSala, $chave);
            header('Location: ./classroom-waiting.php?chave=' . $chave);
            exit;
        } catch (Exception $e) {
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://d3js.org/d3.v5.min.js"></script>
    <script src="https://unpkg.com/topojson@3"></script>
    <link rel="stylesheet" href="bootstrap.min.css">
    <title>The World - Sala</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" integrity="sha384-rR6z4u7ezt6ureuF5F73BzLcHekVJf5Y2n1BSUoBPK8Dq1T7n3U5tJYh3PQgXtB8" crossorigin="anonymous">
    <link rel="stylesheet" href="classes/template/config.css">
    <link rel="stylesheet" href="classes/template/login.css">
    <link rel="stylesheet" href="classes/template/dashboard.css">
    <link rel="stylesheet" href="classes/template/custom.css">
    <link rel="stylesheet" href="classes/template/global.css">
    <link rel="stylesheet" href="classes/template/animation.css">
    <link rel="stylesheet" href="classes/template/global.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Righteous&family=Roboto:wght@400;500;900&display=swap" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
</head>

<body>
    <div class="temp-nickname">
        <form data-name="" id="pais" name="pais-form" method="post" aria-label="Form">
            <div class="nickname-body">
                <h1><i class='bx bx-world'></i><br>Entrar</h1>
                <div class="form">
                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label"><i class='bx bx-face'></i> Digite um nome.</label>
                        <input type="name" class="form-control" id="nome" name="nome" placeholder="Nome">
                    </div>
                </div>
                <div class="d-flex justify-content-center">
                    <button class="btn" type="submit" name="entrar">Pronto!</button>
                </div>
            </div>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.12.1/js/all.js"></script>
    <script src="js/bootstrap/bootstrap.js"></script>
</body>

</html>