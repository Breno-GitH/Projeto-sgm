<?php
require_once '../config/database.php';
header('Content-Type: application/json');

$sql = "SELECT
         ca.caminho_arquivo AS caminho_arquivo,
         ca.tipo_anexo AS tipo_anexo
        FROM chamados c
 LEFT JOIN chamados_anexos ca ON c.id_chamado = ca.id_chamado GROUP BY c.id_chamado";
        $res = $conn-> query($sql);
        $dados = $res->fetch_assoc();
        echo json_encode($dados);