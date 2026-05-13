<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
require_once '../config/database.php';

header('Content-Type: application/json');

$dadosBrutos = file_get_contents("php://input");
$data = json_decode($dadosBrutos);

if (!$data || !isset($data->email) || !isset($data->senha)) {
    echo json_encode(["success" => false, "message" => "Dados inválidos."]);
    exit;
}

$email = $conn->real_escape_string(trim($data->email));
$senha = trim($data->senha);

$sql = "SELECT id_usuario, nome, senha_hash, perfil, ativo 
        FROM usuarios 
        WHERE email = '$email' 
        LIMIT 1";

$result = $conn->query($sql);

if ($result && $result->num_rows === 1) {

    if ($result && $result->num_rows === 1) {

    $user = $result->fetch_assoc();
    
    // 1. PRIMEIRO: Criamos a variável extraindo do array $user
    $hashDoBanco = trim($user['senha_hash']); 

    // 2. AGORA SIM: Podemos usar nos logs e no if
    error_log("Senha digitada: " . $senha);
    error_log("Hash limpo do banco: " . $hashDoBanco);
    error_log("Resultado Verify: " . (password_verify($senha, $hashDoBanco) ? 'SIM' : 'NÃO'));

    if ((int)$user['ativo'] !== 1) {
        echo json_encode(["success" => false, "message" => "Usuário inativo."]);
        exit;
    }

    // 3. Verificação final
    if (password_verify($senha, $hashDoBanco)) {
        $_SESSION['user_id'] = $user['id_usuario'];
        $_SESSION['user_nome'] = $user['nome'];
        $_SESSION['user_perfil'] = $user['perfil'];

        echo json_encode(["success" => true, "perfil" => $user['perfil']]);
        exit;
    } else {
        echo json_encode(["success" => false, "message" => "Senha incorreta."]);
        exit;
    }
}

    $hashDoBanco = trim($user['senha_hash']);

    if (password_verify($senha, $hashDoBanco)) {
        $_SESSION['user_id'] = $user['id_usuario'];
        $_SESSION['user_nome'] = $user['nome'];
        $_SESSION['user_perfil'] = $user['perfil'];

        echo json_encode(["success" => true, "perfil" => $user['perfil']]);
        exit;
    } else {
        echo json_encode(["success" => false, "message" => "Senha incorreta."]);
        exit;
    }

} else {
    echo json_encode(["success" => false, "message" => "Usuário não encontrado."]);
    exit;
}