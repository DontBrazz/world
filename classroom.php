<?php
require_once("classes/Controller.php");
require_once("classes/mysql/MySQLController.php");
require_once("classes/JSON.php");
$invoke = new Controller();
$mysql = new MySQL();
$json = new JSONS();

$user = $_SESSION['nome'];

$chave = $_GET['chave'];
$id = $mysql->getIdRoom($chave);
$tempo = $json->getTempo($id);
$stage = $json->getStage($id);
if ($stage == 0) {
    $json->setStageMath($id,1);
}



if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        if (isset($_POST['resposta'])) {
            $resposta = $_POST['resposta'];
            $tempo = intval($_POST['time']);
            $nome = isset($_SESSION['nome']) ? $_SESSION['nome'] : 'guest';

            $resultado = $json->checkQuestionI($resposta, 1, $id);
            $resultado = ($resultado === true) ? true : false;
            $json->updatePoints($nome, $id, $tempo,$resultado);
            $points = $json->getPoints($nome,$id);
       
            

            echo json_encode(['resultado' => $resultado, 'nome' => $nome, 'tempo' => $tempo, 'points' => $points]);
        } else {
            echo json_encode(['resultado' => false, 'error' => 'Nenhuma resposta fornecida']);
        }
    } catch (Exception $e) {
        echo json_encode(['resultado' => false, 'error' => $e->getMessage()]);
    }
    exit;
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


        .loading-overlay {
            display: none; /* Inicialmente oculto */
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5); /* Fundo semi-transparente */
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 9999; /* Colocar acima de outros elementos */
        }

        /* Estilo para o contêiner central com borda */
        .loading-container {
            background-color: #333;
            padding: 30px;
            border-radius: 10px;
            border: 2px solid #fff;
            text-align: center;
        }

        /* Animação de rotação */
        .spinner {
            border: 8px solid #f3f3f3;
            border-top: 8px solid #3498db;
            border-radius: 50%;
            width: 60px;
            height: 60px;
            margin: 10px auto; /* Centraliza dentro do contêiner */
            animation: spin 2s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        .loading-text {
            margin-top: 10px;
            font-size: 18px;
        }
        .result-message {
            display: none;
            font-size: 20px;
            margin-top: 20px;
            padding: 10px;
            border-radius: 8px;
            text-align: center;
        }
        .success-message {
            background-color: #4CAF50;
            color: #fff;
        }
        .nome {
            font-weight: bold;          /* Para deixar o texto em negrito */
            color: #fff;            /* Cor do texto (verde) */
            font-size: 2.0em;          /* Aumenta o tamanho da fonte */
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.3); /* Sombra no texto */
            margin-left: 5px;          /* Um pouco de espaço entre o emoji e o nome */
        }
        .error-message {
            background-color: #f44336;
            color: #fff;
        }
                /* Animações de acerto e erro */
       /* Animações de acerto e erro */
        /* Animações de acerto e erro */
  /* Animações de acerto e erro */
          /* Animações de acerto e erro */
          .animation-container {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            text-align: center;
            z-index: 9999;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.5);
        }
        @keyframes bounce {
            0%, 20%, 50%, 80%, 100% {
                transform: translateY(0);
            }
            40% {
                transform: translateY(-20px);
            }
            60% {
                transform: translateY(-10px);
            }
        }

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
        #finalizar {
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
        #finalizar:hover {
            background-color: solid #0d6efd;
            color: white;
        }
    </style>
</head>
<body>

    <div class="classroom">
        <div class="container">
            <div class="question" id="questao">
                <h1 id="question"></h1>
            </div>
            <div class="classroom-body">
                <div class="row row-cols-md-3 d-flex justify-content-between">
                    <div class="col col-md-1 d-flex align-items-center">
                        <div class="temp" id="tempo">
                            <h2 class="seconds"></h2>
                        </div>
                    </div>
                    <div class="col col-md-5" id="imagem">
                        <img src="https://super.abril.com.br/wp-content/uploads/2021/02/SI_424_Oraculo_barcos_SITE.png?w=720&h=440&crop=1">
                    </div>
                    <div class="col col-md-1 d-flex align-items-center">
                        <div class="action" id="pular">
                            <div class="row row-cols-md-0">
                                <div class="question">
                                        <h1>Proximo</h1>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="classroom-footer">
                <div class="row row-cols-md-2">
                <div class="col">
                    <div id="1" class="card d-flex align-items-center">
                            <h2 id="res1" nome=""></h2>
                        </div>
                    </div>
                    <div class="col">
                        <div id="2" class="card d-flex align-items-center">
                            <h2 id="res2" nome=""></h2>
                        </div>
                    </div>
                    <div class="col">
                        <div id="3" class="card d-flex align-items-center">
                            <h2 id="res3" nome=""></h2>
                        </div>
                    </div>
                    <div class="col">
                        <div id="4" class="card d-flex align-items-center">
                            <h2 id="res4" nome=""></h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="loading-overlay">
        <div class="loading-container">
            <div class="spinner"></div>
            <p class="loading-text">Resposta enviado com sucesso<br>aguarde ate que o tempo acabe...</p>
        </div>
    </div>
    <div class="result-message" id="result-message"></div>
    <div class="animation-container" id="happy-animation">
        <div class="emoji happy-animation">🎉</div>
        <p>Você acertou!</p>
        <p id="points-b">Pontos: </p>
        <br>
        <p id="position-b"></p>
    </div>
    <div class="animation-container" id="error-animation">
        <div class="emoji error-animation">❌</div>
        <p>Você errou!</p>
        <p id="points-n">Pontos: </p>
        <br>
        <p id="position-n"></p>
    </div>
    <div class="animation-container" id="no-clicked">
    <div class="emoji error-animation">❌</div>
        <p>Tempo expirado...</p>
        <br>
        <p id="points-s">Pontos: </p>
        <p id="position-s"></p>
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
        <button id="finalizar">Finalizar</button>
    </div>

    <script>
        $(document).ready(function(){
            var stage = localStorage.getItem('currentStage') ? parseInt(localStorage.getItem('currentStage') == <?php echo $stage;?> ? localStorage.getItem('currentStage') : <?php echo $stage;?>) : 1;
            const alunos = [];
            var finalResponse;
            let num;
            var countdown;
            var user = <?php echo json_encode($user);?>;
            var countdownInterval;



            function getAlunos() {
                alunos.length = 0;
                return fetch(`get/roomAlunos.php?chave=<?php echo $chave ?>`)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Erro ao buscar dados: ' + response.statusText);
                        }
                        return response.json();
                    })
                    .then(data => {
                        data.forEach(teste => {
                            alunos.push(teste);
                    });
                    const topicos = alunos
                        .sort((a, b) => b.points - a.points)
                        .map((user, index) => ({
                            position: index + 1,
                            name: user.name,
                            points: user.points
                        }));
                        
                        return topicos;
                    })
                .catch(error => {
                    console.error('Erro ao carregar os nomes:', error);
                });
            }

            function start() {
                $(".loading-overlay").hide();
                $("#result-message").hide();
                $("#happy-animation").hide();
                $("#error-animation").hide();
                $("#no-clicked").hide();
                $(".classroom-footer").show();
                $("#imagem").show();
                $("#pular").hide();
                $("#questao").show();
                $("#tempo").fadeIn();
                $(".container-2").fadeOut();
                finalResponse = null;

            }



            function loadQuestion() {
                fetch('get/getPerguntas.php?chave=<?php echo $chave?>')
                    .then(response => response.json())
                    .then(data => {
                        var results = data[stage];
                        $("#question").text(results.question);
                        var respostas = [
                            { texto: results.resposta1.reposta, id: results.resposta1.id },
                            { texto: results.resposta2.reposta, id: results.resposta2.id },
                            { texto: results.resposta3.reposta, id: results.resposta3.id },
                            { texto: results.respostaCorreta.reposta, id: results.respostaCorreta.id }
                        ];

                        function shuffle(array) {
                            for (let i = array.length - 1; i > 0; i--) {
                                const j = Math.floor(Math.random() * (i + 1));
                                [array[i], array[j]] = [array[j], array[i]];
                            }
                            return array;
                        }

                        var respostasAleatorias = shuffle(respostas);


                        $("#res1").text(respostasAleatorias[0].texto);
                        $("#res1").attr("nome", respostasAleatorias[0].id);

                        $("#res2").text(respostasAleatorias[1].texto);
                        $("#res2").attr("nome", respostasAleatorias[1].id);

                        $("#res3").text(respostasAleatorias[2].texto);
                        $("#res3").attr("nome", respostasAleatorias[2].id);

                        $("#res4").text(respostasAleatorias[3].texto);
                        $("#res4").attr("nome", respostasAleatorias[3].id);
                    })
                    .catch(error => console.error('Erro ao carregar perguntas:', error));
            }

            function expirado() {
                var chave = `<?php echo $chave;?>`;

                $.ajax({
                    url: 'get/check2.php',
                    type: 'POST',
                    data: { key: chave },
                    dataType: 'json',
                    success: function(response) {
                        console.log("TESTE:" + response);
                        $("#points-s").text("Pontos: " + response.points);
                        getAlunos().then(topicos => {
                            $("#position-s").text("Posicão: " + topicos.find(topico => topico.name === user).position);
                        }).catch(error => {
                        console.error("Erro ao atualizar o ranking:", error);
                        });
                    },
                    error: function() {
                    }
                });

                $(".animation-container").css("background-color", "#f44336");
                $("#no-clicked").fadeIn();
                $(".loading-overlay").fadeOut();
                $(".classroom-footer").hide();
                $("#imagem").hide();
                // $("#pular").hide();

                $("#questao").hide();
            }

            function startCountdown() {
                
                $.get('get/tempo.php', function(tempoRestante) {
                    countdown = parseInt(tempoRestante, 10);
                        
                    
                
                    $(".seconds").text(countdown + "s");
                    countdownInterval = setInterval(function() {
                        countdown--;
                        console.log(countdown);
                        $(".seconds").text(countdown + "s");
                        if (countdown <= 0) {
                            clearInterval(countdownInterval);

                            <?php
                                if (isset($_SESSION['admin'])) {
                                    echo 'showTable();';
                                } else {
                                    echo '
                                    if (finalResponse == null) {

                                            expirado();
                                            
                                        } else {
                                            clearInterval(countdownInterval); // Limpa o intervalo quando a contagem terminar

                                            // Verifique a resposta e mostre o resultado
                                            if (finalResponse) {
                                                $(".loading-overlay").fadeOut();
                                                $("#result-message").removeClass("success-message error-message");

                                                if (finalResponse.resultado === true) {
                                                    $(".animation-container").css("background-color", "#4CAF50");
                                                    $("#points-b").text("Pontos: " + finalResponse.points);
                                                    getAlunos().then(topicos => {
                                                        $("#position-b").text("Posicão: " + topicos.find(topico => topico.name === user).position);
                                                    }).catch(error => {
                                                    console.error("Erro ao atualizar o ranking:", error);
                                                    });
                                                    $("#happy-animation").fadeIn();
                                                    
                                                } else {
                                                    $(".animation-container").css("background-color", "#f44336");
                                                    $("#points-n").text("Pontos: " + finalResponse.points);
                                                    getAlunos().then(topicos => {
                                                        $("#position-n").text("Posicão: " + topicos.find(topico => topico.name === user).position);
                                                    }).catch(error => {
                                                    console.error("Erro ao atualizar o ranking:", error);
                                                    });
                                                    $("#error-animation").fadeIn();
                                                }

                                                // Espera 5 segundos antes de iniciar o próximo estágio
                                            /* setTimeout(function() {
                                                    stage++;
                                                    start(); // Função para iniciar o próximo estágio
                                                    loadQuestion(); // Carrega a próxima pergunta
                                                    startCountdown(); // Reinicia a contagem regressiva
                                                }, 5000); // Aguarda 5 segundos antes de passar para o próximo estágio*/
                                            }
                                        }
                                                
                                                
                                    
                                    ';
                                }
                            ?>
                            
                            $("#tempo").fadeOut();


                        
                        }
                    }, 1000); // Executa a cada 1 segundo
                }
            )};
            start();
            loadQuestion();
            startCountdown();


            function showTable() {
                setTimeout(function() {
                        $(".classroom-footer").hide();
                        $("#imagem").hide();
                        $("#questao").hide();
                        $("#tempo").fadeOut();
                        $(".loading-overlay").hide();
                        $("#finalizar").fadeOut();
                        

                    $("#resultado").text(' Resultado: ');
                    getAlunos().then(topicos => {
                        $("#top1").html(` ${topicos.length > 0 && topicos[0] ? topicos[0].name : 'Guest'}   / ${topicos[0].points} pontos `);
                        $("#top2").html(` ${topicos.length > 1 && topicos[1] ? topicos[1].name : 'Guest'}   / ${topicos[1].points} pontos `);
                        $("#top3").html(` ${topicos.length > 2 && topicos[2] ? topicos[2].name : 'Guest'}   / ${topicos[2].points} pontos `);
                        $("#top4").html(` ${topicos.length > 3 && topicos[3] ? topicos[3].name : 'Guest'}   / ${topicos[3].points} pontos `);
                        $("#top5").html(` ${topicos.length > 4 && topicos[4] ? topicos[4].name : 'Guest'}   / ${topicos[4].points} pontos `);                   
                    }).catch(error => {
                        console.error('Erro ao atualizar o ranking:', error);
                    });
                   
                    $(".container-2").fadeIn().css("display","flex");
                    $("#pular").show();
                },1000);
            }

            function finalizado() {
                fetch(`get/getStage.php?chave=<?php echo $chave ?>`)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Erro ao carregar as informações do start.');
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data == 0) {
                            window.location.replace(`http://localhost/Project/`);
                        }

                    })
                    .catch(error => {
                        console.error('Erro ao carregar as informações do start:', error);
                    });
                    
            }

            function checkStage() {
                if (stage == 6) {
                //final da questao coloque a tela de final para todos os usuario aqui!
                    setTimeout(function() {
                        $(".classroom-footer").hide();
                        $("#imagem").hide();
                        $("#pular").hide();
                        $("#questao").hide();
                        $("#tempo").fadeOut();
                        <?php
                        
                            if (isset($_SESSION['admin'])) {
                                echo '$("#finalizar").fadeIn();';
                            } else {
                                echo '$("#finalizar").fadeOut();';
                            }
                        
                        ?>
                    },100);

                    $("#resultado").text('🎉 Resultado Final! 🎉');
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

                    console.log(stage);
                } else {
                    fetch(`get/getStage.php?chave=<?php echo $chave ?>`)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Erro ao carregar as informações do start.');
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data == 0) {
                            window.location.replace(`http://localhost/Project/`);
                        } else {
                            if (data > stage) {
                                stage = data;
                                localStorage.setItem('currentStage',stage);
                                clearInterval(countdownInterval);
                                start();
                                $.get('get/resettempo.php');
                                loadQuestion(); 
                                startCountdown();
                                
                            } else {
                                if (data == stage) {
                                    if (num == false) {
                                        num = true;
                                        start();
                                        loadQuestion(); 
                                        startCountdown();
                                    }
                                }
                            }
                        }

                    })
                    .catch(error => {
                        console.error('Erro ao carregar as informações do start:', error);
                    });
                }
            }
            setInterval(checkStage,500);
            setInterval(finalizado,500);

            $("#pular").click(function() {
                var stages = stage;
                var chave = `<?php echo $chave;?>`;
                setTimeout(function(){
                    $.ajax({
                        url: 'get/check.php',
                        type: 'POST',
                        data: { teste: stages, key:chave},
                        dataType: 'json',
                        success: function(response) {
                            
                            console.log('trocad com sucesso!')
                            // Armazena a resposta
                        },
                        error: function() {// Define um valor padrão
                        }
                    });
                },100);           
            });

            $('#finalizar').click(function() {
                var finaizado = 'sim';
                var chave = `<?php echo $chave;?>`;
                $.ajax({
                   url: 'get/finalizar.php',
                   type: 'POST',
                   data: { stage: finaizado, key: chave},
                   dataType: 'json',
                   success:function(response) {
                   },
                   error:function() {
                        console.log('ERROR');
                   }
                });
            });


            $(".card").click(function(){
                var selectedResponseId = $(this).find("h2").attr("nome");
                console.log(selectedResponseId);
                $(".loading-overlay").fadeIn();
                $(".classroom-footer").hide();
                $("#imagem").hide();
               // $("#pular").hide();
                $("#questao").hide();

                // Faz a requisição AJAX
                $.ajax({
                    url: window.location.href,
                    type: 'POST',
                    data: { resposta: selectedResponseId, time: countdown},
                    dataType: 'json',
                    success: function(response) {
                        console.log(response);
                        finalResponse = response; // Armazena a resposta
                    },
                    error: function(xhr, status, error) {
                        alert("Erro na requisição AJAX.");
                        console.error("Status:", status); // Exibe o status do erro
                        console.error("Erro:", error); // Exibe o erro
                        console.error("Resposta completa:", xhr.responseText); // Exibe o conteúdo retornado pelo servidor
                        finalResponse = null; // Define um valor padrão
                    }
                });
            });
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.12.1/js/all.js"></script>
    <script src="js/bootstrap/bootstrap.js"></script>
</body>

</html>