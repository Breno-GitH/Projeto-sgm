<?php
session_start();
require_once '../config/database.php';
header('Content-Type: application/json');

if(!isset($_SESSION['user_id']) || $_SESSION['user_perfil'] !== 'tecnico'){
    echo json_encode(["success" => false, "message" => "Acesso negado"]);
    exit();
}

$id_chamado = intval($_POST['id_chamado'] ?? 0);
$solucao_tecnica = $conn->real_escape_string($_POST['solucao_tecnica'] ?? '');
$tempo_gasto_minutos = intval($_POST['tempo_gasto_minutos'] ?? 0);
$id_tecnico = $_SESSION['user_id'];

if (!$id_chamado || !$solucao_tecnica || !$tempo_gasto_minutos) {
    echo json_encode(["success" => false, "message" => "Preencha todos os campos obrigatórios"]);
    exit();
}

// Verificar se o chamado pertence a este técnico
$check_sql = "SELECT id_tecnico, status FROM chamados WHERE id_chamado = $id_chamado";
$check_result = $conn->query($check_sql);
$chamado = $check_result->fetch_assoc();

if (!$chamado) {
    echo json_encode(["success" => false, "message" => "Chamado não encontrado"]);
    exit();
}

if ($chamado['id_tecnico'] != $id_tecnico) {
    echo json_encode(["success" => false, "message" => "Este chamado não está atribuído a você"]);
    exit();
}

// Atualizar chamado com status 'concluido'
$update_sql = "UPDATE chamados 
               SET status = 'concluido', 
                   solucao_tecnica = '$solucao_tecnica', 
                   tempo_gasto_minutos = $tempo_gasto_minutos,
                   data_fechamento = NOW()
               WHERE id_chamado = $id_chamado";

if (!$conn->query($update_sql)) {
    echo json_encode(["success" => false, "message" => "Erro ao atualizar chamado: " . $conn->error]);
    exit();
}

// Processar upload da foto de conclusão se existir
if(isset($_FILES['foto_conclusao']) && $_FILES['foto_conclusao']['error'] === UPLOAD_ERR_OK){
    $diretorio = "../assets/uploads/";
    if(!is_dir($diretorio)) mkdir($diretorio, 0777, true);
    
    $extensao = strtolower(pathinfo($_FILES['foto_conclusao']['name'], PATHINFO_EXTENSION));
    $nome_arquivo = "conclusao_" . uniqid() . "." . $extensao;
    $caminho_final = $diretorio . $nome_arquivo;
    
    if(move_uploaded_file($_FILES['foto_conclusao']['tmp_name'], $caminho_final)){
        $caminho_db = "assets/uploads/" . $nome_arquivo;
        $sql_anexo = "INSERT INTO chamados_anexos (id_chamado, caminho_arquivo, tipo_anexo, data_upload) 
                     VALUES ($id_chamado, '$caminho_db', 'conclusao', NOW())";
        $conn->query($sql_anexo);
    }
}

echo json_encode(["success" => true, "message" => "Serviço concluído com sucesso!"]);
?>
