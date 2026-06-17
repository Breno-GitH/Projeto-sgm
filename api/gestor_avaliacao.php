<?php

session_start();

if (!isset($_SESSION['user_id']) ||
    $_SESSION['user_perfil'] !== 'gestor') {

    http_response_code(403);
    exit;
}

require_once '../config/database.php';

$sql = "

SELECT

    c.id_chamado,
    c.status,
    c.solucao_tecnica,
    c.tempo_gasto_minutos,

    u.nome AS tecnico,

    ca.caminho_arquivo AS foto_conclusao

FROM chamados c

LEFT JOIN usuarios u
ON u.id_usuario = c.id_tecnico

LEFT JOIN chamados_anexos ca
ON ca.id_chamado = c.id_chamado
AND ca.tipo_anexo = 'conclusao'

WHERE

    c.status = 'concluido'

ORDER BY c.data_fechamento DESC

";

$result = mysqli_query($conn, $sql);

$dados = [];

while($row = mysqli_fetch_assoc($result)){

    $dados[] = $row;

}

header('Content-Type: application/json');

echo json_encode($dados);