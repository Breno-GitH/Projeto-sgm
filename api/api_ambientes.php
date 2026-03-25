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
        if (isset($_GET['metodo']) && $_GET['metodo'] == 'LISTAR_BLOCOS') {
            $sql = "SELECT id_bloco, nome FROM blocos ORDER BY nome ASC";
            $result = $conn->query($sql);
            $blocos = [];
            if ($result) {
                while ($row = $result->fetch_assoc()) { $blocos[] = $row; }
            }
            echo json_encode(["success" => true, "data" => $blocos]);
        } else {
            $sql = "SELECT a.id_ambiente, a.nome, a.id_bloco, b.nome as nome_bloco
                    FROM ambientes a 
                    LEFT JOIN blocos b ON a.id_bloco = b.id_bloco
                    ORDER BY a.nome ASC";
            $result = $conn->query($sql);
            $ambientes = [];
            if ($result) {
                while ($row = $result->fetch_assoc()) { $ambientes[] = $row; }
            }
            echo json_encode(["success" => true, "data" => $ambientes]);
        }
        break;

    case 'POST':
        $json = file_get_contents("php://input");
        $data = json_decode($json);

        if (!isset($data->nome) || !isset($data->id_bloco)) {
            echo json_encode(["success" => false, "message" => "Dados incompletos."]);
            exit;
        }

        $nome = $conn->real_escape_string(trim($data->nome));
        $id_bloco = (int)$data->id_bloco;

        $sql = "INSERT INTO ambientes (nome, id_bloco) VALUES ('$nome', $id_bloco)";

        if ($conn->query($sql) === TRUE) {
            echo json_encode(["success" => true, "message" => "Ambiente criado com sucesso!"]);
        } else {
            echo json_encode(["success" => false, "message" => "Erro ao criar: " . $conn->error]);
        }
        break;

    case 'PUT':
        $json = file_get_contents("php://input");
        $data = json_decode($json);

        if(!isset($data->id_ambiente) || !isset($data->nome) || !isset($data->id_bloco)){
            echo json_encode(["success" => false, "message" => "Dados incompletos para atualização."]);
            exit;
        }

        $id_ambiente = (int)$data->id_ambiente;
        $nome = $conn->real_escape_string(trim($data->nome));
        $id_bloco = (int)$data->id_bloco;

        $sql = "UPDATE ambientes SET nome = '$nome', id_bloco = $id_bloco WHERE id_ambiente = $id_ambiente";

        if($conn->query($sql) === TRUE){
            echo json_encode(["success" => true, "message" => "Ambiente atualizado!"]);
        } else {
            echo json_encode(["success" => false, "message" => "Erro ao atualizar: " . $conn->error]);
        }
        break;

    case 'DELETE':
        $json = file_get_contents("php://input");
        $data = json_decode($json);

        if(!isset($data->id_ambiente)){
            echo json_encode(["success" => false, "message" => "ID não fornecido."]);
            exit;
        }

        $id_ambiente = (int)$data->id_ambiente;
        $sql = "DELETE FROM ambientes WHERE id_ambiente = $id_ambiente";

        if($conn->query($sql) === TRUE){
            echo json_encode(["success" => true, "message" => "Excluído com sucesso!"]);
        } else {
            echo json_encode(["success" => false, "message" => "Erro: Verifique se há itens vinculados."]);
        }
        break;

    default:
        echo json_encode(["success" => false, "message" => "Método não suportado."]);
        break;
}
?>