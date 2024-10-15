<?php
require_once("classes/Controller.php");
require_once("classes/mysql/MySQLController.php");
$invoke = new Controller();
$mysql = new MySQL();
$salas = $mysql->listarSalas();
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (isset($_POST["chave"])) {
        $mysql->changeStatus($_POST['chave'],$_POST['status']);
    }
}
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (isset($_POST["id"])) {
        $mysql->deleteMath($_POST['id']);
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
    <title>The World - Atividades</title>
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
                <div class="activity d-flex justify-content-center">
                    <div class="container">
                        <div class="title d-flex aligin-items-center">
                            <h1>SALAS CRIADAS</h1>
                        </div>
                        <div class="list d-flex justify-content-center">
                            <div class="row row-cols-md-4">
                                <?php
                                $index = 1;
                                if (!empty($salas)) {
                                    foreach ($salas as $sala) {
                                        $active = $sala['active'] === "sim" ? "Ativado" : "Desativado";
                                        $name = $sala['active'] === "sim" ? "Desativar" : "Ativar";
                                        echo '
                                    <div class="col" style="width: 20rem;">
                                        <div class="card" style="width: 18.5rem;">
                                            <div class="card-detals">
                                                <div class="cube"></div>
                                            </div>
                                            <div class="card-body">
                                                <h2><i class="bx bx-clipboard"></i></h2>
                                                <h4 class="card-title">Atividade #' . $index . '</h4>
                                                <div class="row d-flex justify-content-between">
                                                    <div class="col">
                                                        <h6><i class="bx bx-lock"></i> <strong>Codigo:</strong></h6>
                                                        <h6><i class="bx bx-user"></i> <strong>Professor:</strong></h6>
                                                        <h6><i class="bx bx-calendar"></i> <strong>Data:</strong></h6>
                                                        <h6><strong>Expira em:</strong></h6>
                                                        <h6><strong>Status</strong></h6>
                                                    </div>
                                                    <div class="col">
                                                        <h6>' . $sala['chave'] . '</h6>
                                                        <h6>' . $sala['professor'] . '</h6>
                                                        <h6>' . date('d/m/Y', strtotime($sala['datas'])) . '</h6>
                                                        <h6>Nunca</h6>
                                                        <h6>'.$active.'</h6>
                                                    </div>
                                                </div>
                                                <div class="button">
                                                    <a onclick="deletes(\''.$sala['idActiviy'] . '\')" class="btn btn-primary">Excluir</a>
                                                    <br>
                                                   <a onclick="change(\'' . $sala['chave'] . '\', \'' . $sala['active'] . '\')" class="btn btn-primary" style="margin-left: 10px;">'.$name.'</a>
                                                </div>
                                            </div>
                                            <div class="card-detals-footer">
                                                <div class="cube"></div>
                                            </div>
                                        </div>
                                    </div>';
                                        $index++;
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
    <script>
        function change(id,status) {
            const data = {
                chave: id,
                status: status,
            };
            $.ajax({
                url: '',
                type: 'POST',
                data: data,
                success: function(response) {
                    setTimeout(function() {
                        location.reload();
                    },500);
                },
                error: function(xhr, status, error) {
                    alert('Erro ao excluir a pergunta: ' + error);
                }
            });
        }
        function deletes(id) {
            const data = {
                id: id,
            };
            $.ajax({
                url: '',
                type: 'POST',
                data: data,
                success: function(response) {
                    setTimeout(function() {
                        location.reload();
                    },500);
                },
                error: function(xhr, status, error) {
                    alert('Erro ao excluir a pergunta: ' + error);
                }
            });
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.12.1/js/all.js"></script>
    <script src="js/bootstrap/bootstrap.js"></script>
</body>

</html>