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
        $sql = "SELECT * FROM tipos_servico";
        $result = $conn->query($sql);
         $tipos_servico = [];
            if($result){
            while($row = $result->fetch_assoc()){
                $tipos_servico[] = $row;
    } 
}
    echo json_encode(["success" => true, "data" => $tipos_servico]);
    break;
 case 'POST':
    $data = json_decode(file_get_contents("php://input"));


    if(!isset($data->nome) || !isset($data->id_tipo) || !isset($data->descricao)){
        echo json_encode(["success" => false, "message" => "Dados incompletos. Informe nome, id_tipo e descricao."]); 
        exit;
    }
    $nome = $conn->real_escape_string(trim($data->nome));
    $id_tipo = (int)$data->id_tipo;
    $descricao = $conn->real_escape_string(trim($data->descricao));

    $sql = "INSERT INTO tipos_servico (nome, id_tipo, descricao) VALUES ('$nome', $id_tipo, '$descricao')";

    if($conn->query($sql) === TRUE){
        echo json_encode(["success" => true, "message" => "Tipo de serviço criado com sucesso!", "id_tipo" => $conn->insert_id]);
    } else {
        echo json_encode(["success" => false, "message" => "Erro ao criar tipo de serviço: " . $conn->error]);
    }
    break;

     case 'PUT':
    $data = json_decode(file_get_contents("php://input"));

    if(!isset($data->id_tipo) || !isset($data->nome) || !isset($data->descricao)){
        echo json_encode(["success" => false, "message" => "Dados incompletos para atualização."]);
        exit;
    }

    $id_tipo = (int)$data->id_tipo;
    $nome = $conn->real_escape_string(trim($data->nome));
    $descricao = $conn->real_escape_string(trim($data->descricao));

    $sql = "UPDATE tipos_servico SET nome = '$nome', descricao = '$descricao' WHERE id_tipo = $id_tipo";

    if($conn->query($sql) === TRUE){
        echo json_encode(["success" => true, "message" => "Tipo de serviço atualizado com sucesso!"]);
    } else {
        echo json_encode(["success" => false, "message" => "Erro ao atualizar tipo de serviço: " . $conn->error]);
    }
    break;
case 'DELETE':
          $data = json_decode(file_get_contents("php://input"));
            if(!isset($data->id_tipo)){
                echo json_encode(["success" => false, "message" =>"ID do tipo de serviço não fornecido."]);
                exit;
           }
            $id_tipo = (int)$data->id_tipo;
            $sql = "DELETE FROM tipos_servico WHERE id_tipo = $id_tipo";
            if($conn->query($sql) === TRUE){
                echo json_encode(["success" => true, "message" =>"Tipo de serviço excluido com sucesso!"]);
           }else{
              echo json_encode(["success" => false, "message" =>"Erro ao excluir: Pode haver dados vinculados a este Tipo de serviço."]);
           }
          break;

        default: 
        echo json_encode(["success" => false, "message" => "Método HTTP não suportado. "]);
        break;
}
?>
