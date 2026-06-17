<?php
require_once '../config/database.php';
$data = json_decode(file_get_contents("php://input"));

$sql = "INSERT INTO feedback_servico (id_chamado, avaliacao, motivo_dislike) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("iss", $data->id_chamado, $data->avaliacao, $data->motivo);

if ($stmt->execute()) {
    echo json_encode(["success" => true]);
} else {
    echo json_encode(["success" => false]);
}