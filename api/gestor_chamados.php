<?php
session_start();
require_once '../config/database.php';
header('Content-Type: application/json');

// if (!isset($_SESSION['user_id']) || $_SESSION['user_perfil'] !== 'gestor') {
//     echo json_encode(["success" => false, "message" => "Acesso negado."]);
//     exit;
// }


$sql = "SELECT
           c.id_chamado AS id, 
            u1.nome AS solicitante, 
            a.nome AS ambiente,
            c.prioridade, 
            u2.nome AS tecnico, 
            c.status,
            b.nome as bloco_nome
        FROM chamados c
        LEFT JOIN usuarios u1 ON c.id_solicitante = u1.id_usuario
        LEFT JOIN usuarios u2 ON c.id_tecnico = u2.id_usuario
        LEFT JOIN ambientes a ON c.id_ambiente = a.id_ambiente
        left join blocos b on a.id_bloco = b.id_bloco;";

$result = $conn->query($sql);
$chamados = $result->fetch_all(MYSQLI_ASSOC);

echo json_encode($chamados);