<?php
session_start();
require_once '../config/database.php';
header('Content-Type: application/json');

// IMPORTANTE: O técnico deve estar logado
$tecnico_id = $_SESSION['user_id'] ?? 0;

$sql = "SELECT 
            c.id_chamado, 
            c.descricao_problema, 
            c.prioridade, 
            c.data_abertura,
            b.nome AS bloco, 
            a.nome AS ambiente
        FROM chamados c
        JOIN ambientes a ON c.id_ambiente = a.id_ambiente
        JOIN blocos b ON a.id_bloco = b.id_bloco
        WHERE c.id_tecnico = $tecnico_id 
        AND c.status IN ('aberto', 'em_execucao')
        ORDER BY FIELD(prioridade, 'alta', 'media', 'baixa'), data_abertura DESC";

$result = $conn->query($sql);
echo json_encode($result->fetch_all(MYSQLI_ASSOC));