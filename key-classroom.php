<?php
require_once("classes/Controller.php");
require_once("classes/mysql/MySQLController.php");
$invoke = new Controller();
$mysql = new MySQL();
$paises = $mysql->getPaisesCadastrado();
if (!isset($_SESSION['admin'])) {
    header('Location: ./index.php');
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['salvar'])) {
        $pais = $_POST['paisSelected'];
        $time = $_POST['timeSelected'];
        if ($pais == "none" && $time == "none") {
            header("Location: " . $_SERVER['PHP_SELF']);
        } else {
            $tempo = str_replace('s', '', $time);

            try {
                $mysql->createMath($pais, $tempo);
                echo 'Criado com sucesso!';
                exit;
            } catch (Exception $e) {
                echo 'Nao foi possivel cadastrar o pais';
            }
        }
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
                    <div class="key-classroom">
                        <div class="container">
                            <div class="progress-key">
                                <div class="row">
                                    <div class="point_1"><i class='bx bx-box'></i></div>
                                    <div class="bar_1"></div>
                                    <div class="point_2"><i class='bx bx-error'></i></div>
                                    <div class="bar_2"></div>
                                    <div class="point_3"><i class='bx bx-error'></i></div>
                                </div>
                            </div>
                            <div class="gen-key">

                                <!-- Selecionar Pais -->
                                <!-- Definir tempo de pergunta -->

                                <!-- <div class="input-group mb-3">
                                <input type="text" class="form-control" placeholder="Codigo" aria-label="Recipient's username" aria-describedby="button-addon2">
                                <button class="btn btn-outline-secondary" type="button" id="button-addon2">Gerar</button>
                            </div> -->
                                <div class="key-body">
                                    <h1><i class='bx bx-box'></i><br> Gerar Sala</h1>
                                    <div class="form">
                                        <div class="mb-3">
                                            <label for="exampleFormControlInput1" class="form-label"><i class='bx bx-map'></i> País</label>
                                            <select class="form-select form-select-sm" aria-label=".form-select-sm example" name="paisSelected">
                                                <option value="none">Selecione um país</option>
                                                <?php foreach ($paises as $pais) : ?>
                                                    <option value="<?php echo $pais['idPais']; ?>"><?php echo $pais['nomePais']; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="exampleFormControlInput1" class="form-label"><i class='bx bx-time'></i> Tempo de cada pergunta</label>
                                            <select class="form-select form-select-sm" aria-label=".form-select-sm example" name="timeSelected">
                                                <option value="none">Selecionar tempo.</option>
                                                <option value="10">10s</option>
                                                <option value="20">15s</option>
                                                <option value="30">20s</option>
                                                <option value="40">25s</option>
                                                <option value="30">30s</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-center">
                                        <button type="submit" name="salvar" class="btn btn-primary">Gerar</button>
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