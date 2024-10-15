<?php
require_once("classes/Controller.php");
require_once("classes/mysql/MySQLController.php");
$invoke = new Controller();
$mysql = new MySQL();
$id = $_SESSION['id'];
if (!isset($_SESSION['admin'])) {
    header('Location: ./index.php');
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['concluir'])) {
        header("Location: ./index.php");
        unset($_SESSION['id']);
        exit;
    }
}
?>

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
</head>

<body>
    <?php $invoke->loadNav(); ?>

    <div class="cPainel-controller">
        <form data-name="" id="pais" name="pais-form" method="post" aria-label="Form">
            <div class="row row-cols-md-2">

                <div class="col debug"></div>

                <div class="col">
                    <div class="end-classroom">
                        <div class="container">
                            
                            <div class="progress-key">
                                <div class="row">
                                    <div class="point_1"><i class='bx bx-check'></i></div>
                                    <div class="bar_1"></div>
                                    <div class="point_2"><i class='bx bx-check'></i></div>
                                    <div class="bar_2"></div>
                                    <div class="point_3"><i class='bx bx-happy'></i></div>
                                </div>
                            </div>
                            <div class="classroom-report">
                                <div class="d-flex justify-content-center">
                                <div class="container">
                                        <div class="report">
                                            <h1><i class='bx bx-clipboard'></i><br>Relatório</h1>
                                            <div class="report-detals"></div>
                                            <div class="report-body">
                                                <div class="row row-cols-md-2 d-flex justify-content-between">
                                                    <div class="col col-md-5">
                                                        <h4>- Chave:</h4>
                                                        <h4>- Pais:</h4>
                                                        <h4>- Questoes:</h4>
                                                        <h4>- Data:</h4>
                                                    </div>
                                                    <div class="col col-md-4">
                                                        <h4><?php echo $mysql->getChave($id); ?></h4>
                                                        <h4><?php echo $mysql->getPais($id); ?></h4>
                                                        <h4>5/5</h4>
                                                        <h4><?php echo $mysql->getData($id); ?></h4>
                                                    </div>
                                                    <div class="col col-md-1">
                                                        <h4><i class='bx bx-check'></i></h4>
                                                        <h4><i class='bx bx-check'></i></h4>
                                                        <h4><i class='bx bx-check'></i></h4>
                                                        <h4><i class='bx bx-check'></i></h4>
                                                    </div>
                                                </div>
                                                <div class="report-footer">
                                                    <h5><i class='bx bx-stats'></i> <strong>Sala:</strong> Publica.</h5>
                                                </div>
                                                <?php
                                        echo '<form data-name="" id="pais" name="pais-form" method="post" aria-label="Form">';
                                        echo '                                                    <div class="d-flex justify-content-center">
                                                        <button type="submit" name="concluir" class="btn btn-primary">Finalizar</button>
                                                    </div>';
                                        echo '</form>';
                                        ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
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