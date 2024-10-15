<?php
session_start();
$duracao = 30;

// Se o tempo inicial não existir na sessão, define agora
if (!isset($_SESSION['tempo_inicial'])) {
    $_SESSION['tempo_inicial'] = time();  // Marca o tempo inicial na sessão
}

// Calcula o tempo decorrido desde o início
$tempo_inicial = $_SESSION['tempo_inicial'];
$tempo_passado = time() - $tempo_inicial;

// Calcula o tempo restante
$tempo_restante = $duracao - $tempo_passado;

// Garante que o tempo restante não seja negativo
if ($tempo_restante < 0) {
    $tempo_restante = 0;
}

// Retorna o tempo restante para o frontend
echo $tempo_restante;
?>