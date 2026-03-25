<?php
session_start();
require_once '../config/database.php';
header('Content-Type: application/json');

if (!isset($_SESSION['user_id']) || $_SESSION['user_perfil'] !== 'gestor') {
    echo json_encode(["success" => false, "message" => "Acesso restrito a gestores."]);
    exit;
}

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        $sql = "SELECT id_usuario, nome, email, perfil FROM usuarios ORDER BY nome ASC";
        $result = $conn->query($sql);
        $usuarios = [];
        if ($result) {
            while ($row = $result->fetch_assoc()) { $usuarios[] = $row; }
        }
        echo json_encode(["success" => true, "data" => $usuarios]);
        break;

    case 'POST':
        $json = file_get_contents("php://input");
        $data = json_decode($json);
        if (!isset($data->email) || !isset($data->senha)) {
            echo json_encode(["success" => false, "message" => "Dados incompletos."]);
            exit;
        }
        $nome = $conn->real_escape_string(trim($data->nome));
        $email = $conn->real_escape_string(trim($data->email));
        $perfil = $conn->real_escape_string($data->perfil);
        $senha = password_hash($data->senha, PASSWORD_DEFAULT);

        $sql = "INSERT INTO usuarios (nome, email, senha, perfil) VALUES ('$nome', '$email', '$senha', '$perfil')";
        if ($conn->query($sql) === TRUE) {
            echo json_encode(["success" => true, "message" => "Usuário criado!"]);
        } else {
            echo json_encode(["success" => false, "message" => "Erro: " . $conn->error]);
        }
        break;

    case 'PUT':
        $json = file_get_contents("php://input");
        $data = json_decode($json);
        $id_usuario = (int)$data->id_usuario;
        $nome = $conn->real_escape_string(trim($data->nome));
        $email = $conn->real_escape_string(trim($data->email));
        $perfil = $conn->real_escape_string($data->perfil);

        // Se a senha foi enviada, atualiza ela também
        if (!empty($data->senha)) {
            $senha = password_hash($data->senha, PASSWORD_DEFAULT);
            $sql = "UPDATE usuarios SET nome='$nome', email='$email', perfil='$perfil', senha='$senha' WHERE id_usuario=$id_usuario";
        } else {
            $sql = "UPDATE usuarios SET nome='$nome', email='$email', perfil='$perfil' WHERE id_usuario=$id_usuario";
        }

        if($conn->query($sql) === TRUE) echo json_encode(["success" => true, "message" => "Usuário atualizado!"]);
        break;

    case 'DELETE':
        $json = file_get_contents("php://input");
        $data = json_decode($json);
        $id_usuario = (int)$data->id_usuario;
        
        if($id_usuario == $_SESSION['user_id']){
            echo json_encode(["success" => false, "message" => "Você não pode excluir a si mesmo!"]);
            exit;
        }

        $sql = "DELETE FROM usuarios WHERE id_usuario = $id_usuario";
        if($conn->query($sql) === TRUE) echo json_encode(["success" => true, "message" => "Usuário removido!"]);
        break;
}