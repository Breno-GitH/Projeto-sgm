<?php
session_start();
require_once '../config/database.php';
header('Content-Type: application/json');

if (!isset($_SESSION['user_id']) || $_SESSION['user_perfil'] !== 'gestor') {
    echo json_encode(["success" => false, "message" => "Acesso negado."]);
    exit;
}

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        $sql = "SELECT id_bloco, nome FROM blocos ORDER BY nome ASC";
        $result = $conn->query($sql);
        $blocos = [];
        if ($result) {
            while ($row = $result->fetch_assoc()) { $blocos[] = $row; }
        }
        echo json_encode(["success" => true, "data" => $blocos]);
        break;

    case 'POST':
        $data = json_decode(file_get_contents("php://input"));
        if (!isset($data->nome)) {
            echo json_encode(["success" => false, "message" => "Nome não fornecido."]);
            exit;
        }
        $nome = $conn->real_escape_string(trim($data->nome));
        $sql = "INSERT INTO blocos (nome) VALUES ('$nome')";
        if ($conn->query($sql)) {
            echo json_encode(["success" => true, "message" => "Bloco criado!"]);
        } else {
            echo json_encode(["success" => false, "message" => "Erro: " . $conn->error]);
        }
        break;

    case 'PUT':
        $data = json_decode(file_get_contents("php://input"));
        $id = (int)$data->id_bloco;
        $nome = $conn->real_escape_string(trim($data->nome));
        $sql = "UPDATE blocos SET nome = '$nome' WHERE id_bloco = $id";
        if ($conn->query($sql)) {
            echo json_encode(["success" => true, "message" => "Bloco atualizado!"]);
        }
        break;

    case 'DELETE':
        $data = json_decode(file_get_contents("php://input"));
        $id = (int)$data->id_bloco;
        $sql = "DELETE FROM blocos WHERE id_bloco = $id";
        if ($conn->query($sql)) {
            echo json_encode(["success" => true, "message" => "Excluído com sucesso!"]);
        } else {
            echo json_encode(["success" => false, "message" => "Erro: Há ambientes vinculados a este bloco."]);
        }
        break;
}
?>