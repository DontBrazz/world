<?php
require_once("classes/Controller.php");
require_once("classes/mysql/MySQLController.php");
require_once("classes/JSON.php");
$invoke = new Controller();
$mysql = new MySQL();
$json = new JSONS();
$idSala = null; 
if (isset($_GET["sala"])) {
    $chave = $_GET["sala"];
    $idSala = $chave;
} else {
    header('Location: ./index.php');
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
    <style>

.container-2 {
            display: none;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            background-color: #3498db;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            text-align: center;
            z-index: 9999;
            width: 450px; /* Largura fixa para garantir a centralização */
            padding: 10px 5px; /* Padding uniforme */
            border-radius: 16px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.5);
        }

        .container-2-titulo {
            margin-bottom: 8px;
            font-size: 28px;
            font-weight: bold;
            color: #fff;
        }

        .container-2-alunos {
            display: flex;
            flex-direction: column;
            align-items: center;
            font-size: 20px;
            color: #fff;
        }

        .container-2-alunos p {
            margin: -1px 0; /* Espaçamento entre as linhas */
            font-size: 18px; /* Tamanho da fonte */
            display: flex;
            align-items: center;
            justify-content: space-between; /* Distribui o nome e pontuação nas extremidades */
            gap: 6px; /* Espaço entre texto e emoji */
            border: 2px solid #fff;
            padding: 5px 20px; /* Ajuste de padding */
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            background-color: rgba(255, 255, 255, 0.1);
            width: 90%; /* Define a mesma largura para todas as linhas */
            white-space: normal; /* nowrap / normal */
            word-wrap: break-word;
            overflow: hidden;
        }
        .emoji {
            font-size: 1.5em;
        }


        .emoji {
            font-size: 100px;
            animation: bounce 1s infinite;
        }

        .happy-animation {
            background-color: #4CAF50; /* Fundo verde para acerto */
            color: white;
        }

        .error-animation {
            background-color: #f44336; /* Fundo vermelho para erro */
            color: white;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes scaleUp {
            from { transform: scale(0.5); }
            to { transform: scale(1); }
        }

        @keyframes shake {
            0% { transform: translateX(0); }
            25% { transform: translateX(-10px); }
            50% { transform: translateX(10px); }
            75% { transform: translateX(-10px); }
            100% { transform: translateX(0); }
        }

        @keyframes bounce {
            0%, 20%, 50%, 80%, 100% { transform: translateY(0); }
            40% { transform: translateY(-30px); }
            60% { transform: translateY(-15px); }
        }
        #voltar {
            padding: 10px 20px;
            font-size: 16px;
            background-color: white;
            border: 2px solid #0d6efd; /* Borda azul */
            border-radius: 5px;
            background-color: #3498db;
            color: black;
            margin: 9px 0;
            cursor: pointer;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        /* Efeito de hover no botão */
        #voltar:hover {
            background-color: solid #0d6efd;
            color: white;
        }
    </style>
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
                            <h1>Historico</h1>
                        </div>
                        
                            <div class="container-2">
                                <div class="container-2-titulo">
                                    <p id="resultado"></p> <!-- Adiciona emojis ao título -->
                                </div>
                    
                                <div class="container-2-alunos">
                                    <p class="nome" id="top1"></p> <!-- Emoji de medalha de ouro -->
                                    <p class="nome" id="top2"></p> <!-- Emoji de medalha de prata -->
                                    <p class="nome" id="top3"></p> <!-- Emoji de medalha de bronze -->
                                    <p class="nome" id="top4"></p> <!-- Emoji de medalha -->
                                    <p class="nome" id="top5"></p> <!-- Emoji de medalha -->
                                </div>
                                <button id="voltar">Voltar</button>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        const alunos = [];
                    function getAlunos() {
                        alunos.length = 0; // Limpa o array de alunos
                        return fetch(`get/historyAlunos.php?sala=<?php echo $idSala ?>`) // Retorna a promessa do fetch
                            .then(response => {
                                if (!response.ok) {
                                    throw new Error('Erro ao buscar dados: ' + response.statusText);
                                }
                                return response.json(); // Retorna a promessa da conversão para JSON
                            })
                            .then(data => {
                                data.forEach(teste => {
                                    alunos.push(teste);
                                });

                                // Cria o ranking de alunos
                                const topicos = alunos
                                    .sort((a, b) => b.points - a.points) // Ordena os alunos pelos pontos
                                    .map((user, index) => ({
                                        position: index + 1, // Atribui a posição
                                        name: user.name, // Nome do aluno
                                        points: user.points // Pontos do aluno
                                    }));
                                
                                return topicos; // Retorna os tópicos (ranking)
                            })
                            .catch(error => {
                                console.error('Erro ao carregar os nomes:', error);
                            });
                    }
        
        $('#voltar').click(function() {
            window.location.replace(`http://localhost/Project/classroom-log`);
        });
        function load() {
                $("#resultado").text('🎉 Historico Atividade! 🎉');
                    getAlunos().then(topicos => {
                        $("#top1").html(` ${topicos.length > 0 && topicos[0] ? topicos[0].name : 'Guest'}  ${topicos[0].position}° / ${topicos[0].points}  <span class="emoji">🥇</span>`);
                        $("#top2").html(` ${topicos.length > 1 && topicos[1] ? topicos[1].name : 'Guest'}  ${topicos[1].position}° / ${topicos[1].points}  <span class="emoji">🥈</span>`);
                        $("#top3").html(` ${topicos.length > 2 && topicos[2] ? topicos[2].name : 'Guest'}  ${topicos[2].position}° / ${topicos[2].points}  <span class="emoji">🥉</span>`);
                        $("#top4").html(` ${topicos.length > 3 && topicos[3] ? topicos[3].name : 'Guest'}  ${topicos[3].position}° / ${topicos[3].points}  <span class="emoji">🏅</span>`);
                        $("#top5").html(` ${topicos.length > 4 && topicos[4] ? topicos[4].name : 'Guest'}  ${topicos[4].position}° / ${topicos[4].points}  <span class="emoji">🏅</span>`);                   
                    }).catch(error => {
                        console.error('Erro ao atualizar o ranking:', error);
                    });
                   
                    $(".container-2").fadeIn().css("display","flex");
        }
        load(); 
    </script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.12.1/js/all.js"></script>
    <script src="js/bootstrap/bootstrap.js"></script>
</body>

</html>