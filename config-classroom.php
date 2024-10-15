<?php

require_once("classes/Controller.php");
require_once("classes/mysql/MySQLController.php");
require_once("classes/JSON.php");
$invoke = new Controller();
$mysql = new MySQL();
$json = new JSONS();
if (!isset($_SESSION['admin'])) {
    header('Location: ./index.php');
}
if (!isset($_SESSION['id'])) {
    header('Location: ./index.php');
}
$id = $_SESSION['id'];
$alunos = $json->listQuestions($id);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['add'])) {
        $question = $_POST['question'];
        $resposta1 = $_POST['resposta1'];
        $resposta2 = $_POST['resposta2'];
        $resposta3 = $_POST['resposta3'];
        $respostaCorreta = $_POST['respostaCorreta'];
        if ($resposta1 == "" || $resposta2 == "" || $respostaCorreta == "" || $resposta3 == "" || $question == "") {
            $_SESSION['msg'] = '<i class="bx bx-error"></i> - Preencha todos os campos!';
        } else {
            try {
                $json->addQuestion($question, $resposta1, $resposta2, $resposta3, $respostaCorreta, $id);
                header('Location: ' . $_SERVER['PHP_SELF']);
                exit;
            } catch (Exception $e) {
                echo 'Nao foi possivel.';
            }
        }
    }
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['idQuestion'])) {
        $idQuestion = $_POST['idQuestion'];
        try {
            $json->deleteQuestion($idQuestion, $id);
            header('Location: ' . $_SERVER['PHP_SELF']);
            exit;
        } catch (Exception $e) {
            echo 'Nao foi possivel.';
        }
    }
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['final'])) {
        header("Location: ./end-classroom.php");
        exit;
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
    <title>The World - Painel</title>
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
    <?php $invoke->loadNav(); ?>

    <div class="cPainel-controller">
        <div class="row row-cols-md-2">

            <div class="col debug"></div>

            <div class="col">
                <div class="config-classroom">
                    <div class="container">
                        <div class="progress-key">
                            <div class="row">
                                <div class="point_1"><i class='bx bx-check'></i></div>
                                <div class="bar_1"></div>
                                <div class="point_2"><i class='bx bx-book'></i></div>
                                <div class="bar_2"></div>
                                <div class="point_3"><i class='bx bx-error'></i></div>
                            </div>
                        </div>
                        <div class="painel-question">
                            <form data-name="" id="pais" name="pais-form" method="post" aria-label="Form">
                                <div class="row row-cols-md-2 d-flex justify-content-around">
                                    <div class="col col_1">
                                        <div class="add-question">
                                            <div class="card">
                                                <h2>Questão</h2>
                                                <div class="form">
                                                    <div class="mb-3">
                                                        <label for="exampleFormControlInput1" class="form-label"><i class='bx bx-book'></i> Pergunta</label>
                                                        <input type="text" name="question" id="question" class="form-control" id="exampleFormControlInput1" placeholder="Digite uma pergunta" autocomplete="off">
                                                    </div>

                                                    <div class="mb-3">
                                                        <label for="exampleFormControlInput1" class="form-label"><i class='bx bx-error'></i> Respostas erradas</label>
                                                        <input type="text" name="resposta1" id="resposta1" class="form-control" id="exampleFormControlInput1" placeholder="Resposta errada #1" autocomplete="off">
                                                    </div>
                                                    <div class="mb-3">
                                                        <input type="text" name="resposta2" id="resposta2" class="form-control" id="exampleFormControlInput1" placeholder="Resposta errada #2" autocomplete="off">
                                                    </div>
                                                    <div class="mb-3">
                                                        <input type="text" name="resposta3" id="resposta3" class="form-control" id="exampleFormControlInput1" placeholder="Resposta errada #3" autocomplete="off">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="exampleFormControlInput1" class="form-label"><i class='bx bx-check'></i> Resposta correta</label>
                                                        <input type="text" name="respostaCorreta" id="respostaCorreta" class="form-control" id="exampleFormControlInput1" placeholder="Resposta correta" autocomplete="off">
                                                    </div>
                                                    <div class="d-flex justify-content-center">
                                                        <button type="submit" name="add" class="btn btn-primary">Adicionar</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                        if (isset($_SESSION['msg'])) {
                                            echo '<div class="col error">';
                                            echo '<div class="card">';
                                            echo '<h3>' . $_SESSION['msg'] . '</h3>';

                                            echo '</div>';
                                            echo '</div>';
                                            unset($_SESSION['msg']);
                                        }
                                        ?>
                                    </div>
                            </form>
                            <div class="col col_2">
                                <div class="questions">
                                    <div class="title d-flex align-items-center justify-content-center">
                                        <h1>Perguntas</h1>
                                    </div>
                                    <div class="list d-flex justify-content-center">
                                        <div class="row row-cols-md-1">
                                            <?php
                                            if (empty($alunos)) {
                                                echo '<h6>Nenhuma pergunta encontrada.</h6>
                                                     <h1 class="multiple-text animation"></h1>';
                                            }
                                            ?>

                                            <?php
                                            if (!empty($alunos)) {

                                                usort($alunos, function ($a, $b) {
                                                    return $a['id'] - $b['id'];
                                                });

                                                foreach ($alunos as $pergunta) {
                                                    echo '<div class="col">';
                                                    echo '<div class="card">';
                                                    echo '<div class="card-body">';
                                                    echo '<div class="question">';
                                                    echo '<div class="row row-cols-md-2 d-flex justify-content-between">';
                                                    echo '<div class="col col-md-8">';
                                                    echo '<h3 class="question">Questão #' . $pergunta['id'] . '</h3>';
                                                    echo '</div>';
                                                    echo '<div class="col col-md-1">';
                                                    echo '<button onclick="deleteQuestion(' . $pergunta['id'] . ');"><i class="bx bx-trash"></i></button>';
                                                    echo '</div>';
                                                    echo '</div>';
                                                    echo '<p class="n1"><strong><i class="bx bx-book"></i> Pergunta:</strong> ' . $pergunta['question'] . '</p>';
                                                    echo '<p class="n2"><strong><i class="bx bx-pencil"></i> Respostas:</strong></p>';
                                                    echo '<ul>';
                                                    echo '<li>' . $pergunta['resposta1']['reposta'] . '</li>';
                                                    echo '<li>' . $pergunta['resposta2']['reposta'] . '</li>';
                                                    echo '<li>' . $pergunta['resposta3']['reposta'] . '</li>';
                                                    echo '<li>' . $pergunta['respostaCorreta']['reposta'] . ' (Resposta Correta)</li>';
                                                    echo '</ul>';
                                                    echo '</div>';
                                                    echo '</div>';
                                                    echo '</div>';
                                                    echo '</div>';
                                                }
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
                if ($json->todosIndicesOcupados($id)) {
                    echo '<form data-name="" id="pais" name="pais-form" method="post" aria-label="Form">';
                    echo '<button class="fixed-button" type="submit" name="final">Avançar</button>';
                    echo '</form>';
                }
                ?>
            </div>

        </div>
        <script src="js/typed.js"></script>
        <script>
            var typed = new Typed('.multiple-text', {
                strings: ['...'],
                typeSpeed: 85,
                backSpeed: 70,
                backDelay: 2000,
                loop: true
            });
        </script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>
        <script defer src="https://use.fontawesome.com/releases/v5.12.1/js/all.js"></script>
        <script src="classes/js/teste.js"></script>
        <script src="js/bootstrap/bootstrap.js"></script>
    </body>

</html>