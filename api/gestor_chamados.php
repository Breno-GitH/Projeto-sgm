<?php
require_once '../config/database.php';
header('Content-Type: application/json');

$sql = "SELECT
           c.id_chamado AS id, 
            u1.nome AS solicitante, 
            a.nome AS local_tipo, 
            c.prioridade, 
            u2.nome AS tecnico, 
            c.status 
        FROM chamados c
        LEFT JOIN usuarios u1 ON c.id_solicitante = u1.id_usuario
        LEFT JOIN usuarios u2 ON c.id_tecnico = u2.id_usuario
        LEFT JOIN ambientes a ON c.id_ambiente = a.id_ambiente";

     $res = $conn-> query($sql);
        $dados = $res->fetch_assoc();
        echo json_encode($dados);