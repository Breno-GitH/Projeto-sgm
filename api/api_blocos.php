<?php
session_start();
require_once '../config/database.php';
header('Content-Type: application/json');


if (!isset($_SESSION['user_id'] )) {
    echo json_encode(["success" => false, "message" => "Acesso negado."]);
    exit;
}

$method = $_SERVER['REQUEST_METHOD'];

switch ($method){
    case'GET':
        $sql = "SELECT * FROM blocos";
        $result = $conn->query($sql);
         $blocos = [];
            if($result){
            while($row = $result->fetch_assoc()){
                $blocos[] = $row;
    } 
}
    echo json_encode(["success" => true, "data" => $blocos]);
    break;
 case 'POST':
    $data = json_decode(file_get_contents("php://input"));


    if(!isset($data->nome) || !isset($data->id_bloco) || !isset($data->descricao)){
        echo json_encode(["success" => false, "message" => "Dados incompletos. Informe nome, id_bloco e descricao."]); 
        exit;
    }
    $nome = $conn->real_escape_string(trim($data->nome));
    $id_bloco = (int)$data->id_bloco;
    $descricao = $conn->real_escape_string(trim($data->descricao));

    $sql = "INSERT INTO blocos (nome, id_bloco, descricao) VALUES ('$nome', $id_bloco, '$descricao')";

    if($conn->query($sql) === TRUE){
        echo json_encode(["success" => true, "message" => "Bloco criado com sucesso!", "id_blocos" => $conn->insert_id]);
    } else {
        echo json_encode(["success" => false, "message" => "Erro ao criar bloco: " . $conn->error]);
    }
    break;

     case 'PUT':
    $data = json_decode(file_get_contents("php://input"));

    if(!isset($data->id_bloco) || !isset($data->nome) || !isset($data->descricao)){
        echo json_encode(["success" => false, "message" => "Dados incompletos para atualização."]);
        exit;
    }

    $id_bloco = (int)$data->id_bloco;
    $nome = $conn->real_escape_string(trim($data->nome));
    $descricao = $conn->real_escape_string(trim($data->descricao));

    $sql = "UPDATE blocos SET nome = '$nome', descricao = '$descricao' WHERE id_bloco = $id_bloco";

    if($conn->query($sql) === TRUE){
        echo json_encode(["success" => true, "message" => "Bloco atualizado com sucesso!"]);
    } else {
        echo json_encode(["success" => false, "message" => "Erro ao atualizar bloco: " . $conn->error]);
    }
    break;
case 'DELETE':
          $data = json_decode(file_get_contents("php://input"));
            if(!isset($data->id_bloco)){
                echo json_encode(["success" => false, "message" =>"ID do ambiente não fornecido."]);
                exit;
           }
            $id_bloco = (int)$data->id_bloco;
            $sql = "DELETE FROM blocos WHERE id_bloco = $id_bloco";
            if($conn->query($sql) === TRUE){
                echo json_encode(["success" => true, "message" =>"Bloco excluido com sucesso!"]);
           }else{
              echo json_encode(["success" => false, "message" =>"Erro ao excluir: Pode haver dados vinculados a este Bloco."]);
           }
          break;

        default: 
        echo json_encode(["success" => false, "message" => "Método HTTP não suportado. "]);
        break;
}
?>
