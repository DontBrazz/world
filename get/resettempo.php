<?php
session_start();
// Define um novo tempo inicial na sessão
$_SESSION['tempo_inicial'] = time(); 

// Retorna a confirmação de que o tempo foi resetado
echo json_encode(['status' => 'resetado']);
?>
