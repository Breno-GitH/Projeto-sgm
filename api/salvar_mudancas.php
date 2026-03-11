<?php
session_start();
require_once '../config/database.php';
header('Content-Type: application/json');


if(!isset($_SESSION['user_id'])){
    echo json_encode(["success" => false, "message" => "Sessão expirada"]);
    exit();
}
$nome = $conn->real_escape_string($_POST['nome'] ?? '');
$id_bloco = (int)($_POST['id_tipo'] ?? 0);



if(!$id_bloco || empty($nome)){
    echo json_encode(['success' => false, 'message' => 'Preencha todos os campos obrigatórios']);
    exit();
}


$sql ="INSERT INTO ambientes (nome, id_bloco) VALUES('$nome', $id_bloco)";
    echo json_encode(["success" => true, "message" => "Chamado #$id_chamado aberto com sucesso!"]);
 else {
    echo json_encode(["success" => false, "message" => "Erro no banco: " . $conn->error]);
}
?>