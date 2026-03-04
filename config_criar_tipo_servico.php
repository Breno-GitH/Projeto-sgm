<?php 
session_start();

if(!isset($_SESSION['user_id']) || $_SESSION['user_perfil'] !== 'gestor'){
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>SGM - Novo Tipo de Serviço</title>
</head>

<body class="bg-light">
    <div class="container d-flex align-items-center" style="min-height: 100vh; padding: 20px 0;">
        <form action="api/salvar_chamados.php" method="POST" enctype="multipart/form-data" class="w-100 m-auto shadow-lg" id="formChamado" style="max-width: 600px;">
            <header class="text-white d-flex justify-content-between align-items-center rounded-top-4 px-4 py-3" style="background: linear-gradient(45deg, #1a237e, #283593);">
                <h2 class="mb-0 h4 d-flex align-items-center">
                    <i class="bi bi-plus-circle-fill me-2"></i> Criar Tipo de Serviço
                </h2>
                 <a href="config_blocos.php" class="btn btn-sm btn-outline-light">Voltar</a>
</header>

            <main class="p-4 border rounded-bottom bg-white">
                <div class="mb-3">
                    <label for="bloco" class="form-label fw-bold">Novo Tipo de Serviço</label>
                    <input type="form" name="id_Novo-Ambiente" class="form-select">
                </div>

                <button class="btn btn-lg w-100 py-3 mt-3 text-white shadow-sm border-0 rounded-3" type="submit" id="btnEnviar" style="background: linear-gradient(45deg, #1a237e, #283593); transition: 0.3s;">
                    <i class="bi bi-check2-all me-2"></i> Registrar Tipo de Serviço
                </button>   
            </main>
        </form>
    </div>