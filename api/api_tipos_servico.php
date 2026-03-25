<?php
session_start();
require_once '../config/database.php';
header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(["success" => false, "message" => "Acesso negado."]);
    exit;
}

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        $sql = "SELECT id_tipo, nome FROM tipos_servico ORDER BY nome ASC";
        $result = $conn->query($sql);
        $tipos = [];
        if ($result) {
            while ($row = $result->fetch_assoc()) { $tipos[] = $row; }
        }
        echo json_encode(["success" => true, "data" => $tipos]);
        break;

    case 'POST':
        $json = file_get_contents("php://input");
        $data = json_decode($json);
        if (!isset($data->nome)) {
            echo json_encode(["success" => false, "message" => "Nome não fornecido."]);
            exit;
        }
        $nome = $conn->real_escape_string(trim($data->nome));
        $sql = "INSERT INTO tipos_servico (nome) VALUES ('$nome')";
        if ($conn->query($sql) === TRUE) {
            echo json_encode(["success" => true, "message" => "Tipo de serviço criado!"]);
        } else {
            echo json_encode(["success" => false, "message" => "Erro: " . $conn->error]);
        }
        break;

    case 'PUT':
        $json = file_get_contents("php://input");
        $data = json_decode($json);
        $id_tipo = (int)$data->id_tipo;
        $nome = $conn->real_escape_string(trim($data->nome));
        $sql = "UPDATE tipos_servico SET nome = '$nome' WHERE id_tipo = $id_tipo";
        if($conn->query($sql) === TRUE) echo json_encode(["success" => true, "message" => "Tipo atualizado!"]);
        break;

    case 'DELETE':
        $json = file_get_contents("php://input");
        $data = json_decode($json);
        $id_tipo = (int)$data->id_tipo;
        $sql = "DELETE FROM tipos_servico WHERE id_tipo = $id_tipo";
        if($conn->query($sql) === TRUE) {
            echo json_encode(["success" => true, "message" => "Tipo excluído!"]);
        } else {
            echo json_encode(["success" => false, "message" => "Erro: Há chamados usando este tipo."]);
        }
        break;
}