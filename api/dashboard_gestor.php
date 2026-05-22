<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once '../config/database.php';
header('Content-Type: application/json');

// Validação de acesso
if(!isset($_SESSION['user_id']) || $_SESSION['user_perfil'] !== 'gestor'){
    echo json_encode(["success" => false, "message" => "Acesso negado"]);
    exit;
}

// Chamados sem técnico (novos)
$sql_abertos = "SELECT COUNT(*) as total FROM chamados WHERE id_tecnico IS NULL";
$res_abertos = $conn->query($sql_abertos);
$dados_abertos = $res_abertos->fetch_assoc();

// Chamados em execução (em atendimento)
$sql_execucao = "SELECT COUNT(*) as total FROM chamados WHERE status = 'em_execucao'";
$res_execucao = $conn->query($sql_execucao);
$dados_execucao = $res_execucao->fetch_assoc();

// Chamados com prioridade alta/urgente e não fechados
$sql_urgentes = "SELECT COUNT(*) as total FROM chamados WHERE (prioridade = 'alta' OR prioridade = 'urgente') AND status != 'fechado' AND status != 'concluido'";
$res_urgentes = $conn->query($sql_urgentes);
$dados_urgentes = $res_urgentes->fetch_assoc();

$resultado = [
    "abertos" => (int)$dados_abertos['total'],
    "em_execucao" => (int)$dados_execucao['total'],
    "urgentes" => (int)$dados_urgentes['total']
];

echo json_encode($resultado);
?>