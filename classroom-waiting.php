<?php
require_once("classes/Controller.php");
require_once("classes/mysql/MySQLController.php");
require_once("classes/JSON.php");
$invoke = new Controller();
$mysql = new MySQL();
$json = new JSONS();
$idSala = null;
if (isset($_GET["chave"])) {
    $chave = $_GET["chave"];
    $idSala = $mysql->getIdRoom($chave);
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['start'])) {
        $json->setIniciado($idSala,"Sim");
        $json->setStageMath($id,1);
        exit;
    } else {
        echo json_encode(['resultado' => false]); // Resposta padrão
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <style>
        .waiting-body {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh; /* Ocupa toda a altura da viewport */
}

#iniciar {
    padding: 10px 20px;
    font-size: 16px;
    background-color: white;
    border: 2px solid #0d6efd; /* Borda azul */
    border-radius: 5px;
    background-color: #0d6efd;
    color: black;
    cursor: pointer;
    transition: background-color 0.3s ease, color 0.3s ease;
}

/* Efeito de hover no botão */
#iniciar:hover {
    background-color: solid #0d6efd;
    color: white;
}

    </style>
</head>

<body>
    <div class="meting">
        <div class="d-flex justify-content-center">
            <div class="waiting">
                <div class="effect">


                    <svg xmlns="http://www.w3.org/2000/svg" height="200" width="200">
                        <g style="order: -1;">
                            <polygon transform="rotate(45 100 100)" stroke-width="1" stroke="#d3a410" fill="none" points="70,70 148,50 130,130 50,150" id="bounce"></polygon>
                            <polygon transform="rotate(45 100 100)" stroke-width="1" stroke="#d3a410" fill="none" points="70,70 148,50 130,130 50,150" id="bounce2"></polygon>
                            <polygon transform="rotate(45 100 100)" stroke-width="2" stroke="" fill="#414750" points="70,70 150,50 130,130 50,150"></polygon>
                            <polygon stroke-width="2" stroke="" fill="url(#gradiente)" points="100,70 150,100 100,130 50,100"></polygon>
                            <defs>
                                <linearGradient y2="100%" x2="10%" y1="0%" x1="0%" id="gradiente">
                                    <stop style="stop-color: #1e2026;stop-opacity:1" offset="20%"></stop>
                                    <stop style="stop-color:#414750;stop-opacity:1" offset="60%"></stop>
                                </linearGradient>
                            </defs>
                            <polygon transform="translate(20, 31)" stroke-width="2" stroke="" fill="#b7870f" points="80,50 80,75 80,99 40,75"></polygon>
                            <polygon transform="translate(20, 31)" stroke-width="2" stroke="" fill="url(#gradiente2)" points="40,-40 80,-40 80,99 40,75"></polygon>
                            <defs>
                                <linearGradient y2="100%" x2="0%" y1="-17%" x1="10%" id="gradiente2">
                                    <stop style="stop-color: #d3a51000;stop-opacity:1" offset="20%"></stop>
                                    <stop style="stop-color:#d3a51054;stop-opacity:1" offset="100%" id="animatedStop"></stop>
                                </linearGradient>
                            </defs>
                            <polygon transform="rotate(180 100 100) translate(20, 20)" stroke-width="2" stroke="" fill="#d3a410" points="80,50 80,75 80,99 40,75"></polygon>
                            <polygon transform="rotate(0 100 100) translate(60, 20)" stroke-width="2" stroke="" fill="url(#gradiente3)" points="40,-40 80,-40 80,85 40,110.2"></polygon>
                            <defs>
                                <linearGradient y2="100%" x2="10%" y1="0%" x1="0%" id="gradiente3">
                                    <stop style="stop-color: #d3a51000;stop-opacity:1" offset="20%"></stop>
                                    <stop style="stop-color:#d3a51054;stop-opacity:1" offset="100%" id="animatedStop"></stop>
                                </linearGradient>
                            </defs>
                            <polygon transform="rotate(45 100 100) translate(80, 95)" stroke-width="2" stroke="" fill="#ffe4a1" points="5,0 5,5 0,5 0,0" id="particles"></polygon>
                            <polygon transform="rotate(45 100 100) translate(80, 55)" stroke-width="2" stroke="" fill="#ccb069" points="6,0 6,6 0,6 0,0" id="particles"></polygon>
                            <polygon transform="rotate(45 100 100) translate(70, 80)" stroke-width="2" stroke="" fill="#fff" points="2,0 2,2 0,2 0,0" id="particles"></polygon>
                            <polygon stroke-width="2" stroke="" fill="#292d34" points="29.5,99.8 100,142 100,172 29.5,130"></polygon>
                            <polygon transform="translate(50, 92)" stroke-width="2" stroke="" fill="#1f2127" points="50,50 120.5,8 120.5,35 50,80"></polygon>
                        </g>
                    </svg>

                    <h1>Aguardando...</h1>
                    <h3 id="numeroParticipantes">0 Participantes!</h3>
                    <div class="waiting-body">
                        <?php
                            if (isset($_SESSION['admin'])) {
                                echo '<button id="iniciar">Iniciar</button>';
                            }

                        ?>
                    </div>
                    <div class="waiting-footer">
                        <h6><strong>DICA:</strong> Responda rapidamente para conseguir mais pontos!</h6>
                    </div>
                    
                </div>
                
            </div>
            
        </div>
        
    </div>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.12.1/js/all.js"></script>
    <script>
        let skipUnloadEvents = false;
        document.addEventListener('DOMContentLoaded', function () {
            window.addEventListener('beforeunload', function(event) {
                if (skipUnloadEvents) return;
        // Faz uma requisição ao servidor para limpar a session
            fetch('get/eventCloseGame.php')
            .then(response => {
                if (!response.ok) {
                    console.error('Erro ao sair da sala:', response.statusText);
                }
            })
            .catch(error => {
                console.error('Erro ao sair da sala', error);
            });

        });
        window.addEventListener('unload', function(event) {
            if (skipUnloadEvents) return;
        // Faz uma requisição ao servidor para limpar a session
            fetch('get/eventCloseGame.php')
            .then(response => {
                if (!response.ok) {
                    console.error('Erro ao sair da sala:', response.statusText);
                }
            })
            .catch(error => {
                console.error('Erro ao sair da sala', error);
            });

        });
    });

        function atualizarParticipantes() {
            // Simulação de dados em JSON (substitua pela lógica real de busca)
            fetch(`get/roomAlunos.php?chave=<?php echo $chave ?>`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Erro ao carregar os dados dos alunos.');
                    }
                    return response.json();
                })
                .then(data => {
                    document.getElementById('numeroParticipantes').textContent = data.length + ' Participantes!';

                })
                .catch(error => {
                    console.error('Erro ao carregar os numeros dos alunos:', error);
                });
        }

        function getStarted() {
            fetch(`get/getStarted.php?chave=<?php echo $chave ?>`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Erro ao carregar as informações do start.');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data == "Sim") {
                        skipUnloadEvents = true;
                        window.location.replace(`http://localhost/Project/classroom?chave=<?php echo $chave ?>`);
                    }

                })
                .catch(error => {
                    console.error('Erro ao carregar as informações do start:', error);
                });
                
        }

        if (document.getElementById('iniciar')) {
        document.getElementById('iniciar').addEventListener('click', function() {
            getStarted();
            let starta = "sim";
            $.ajax({
                    url: window.location.href,
                    type: 'POST',
                    data: { start: starta },
                    dataType: 'json',
                    success: function(response) {

                        finalResponse = response; // Armazena a resposta
                    },
                    error: function() {
                       
                    }
                });
            //window.location.replace("localhost/Project/classroom?chave=8381934");
        });
    }
        setInterval(getStarted,500);
        setInterval(atualizarParticipantes, 500);
    </script>
    <script src="js/bootstrap/bootstrap.js"></script>
</body>

</html>