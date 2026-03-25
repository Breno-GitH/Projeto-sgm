<?php 
session_start();
// Proteção de acesso: apenas gestores
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
    <title>SGM - Novo Usuário</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body class="bg-light">
    <header>
        <nav class="navbar mb-4 shadow-sm" data-bs-theme="dark" style="background: linear-gradient(45deg, #1a237e, #283593);">
            <div class="container">
                <div class="d-flex align-items-center">
                    <a href="config_usuarios.php" class="btn btn-outline-light btn-sm me-3">
                        <i class="bi bi-arrow-left"></i> Voltar
                    </a>
                    <span class="navbar-brand">Cadastrar Usuário</span>
                </div>
            </div>
        </nav>
    </header>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow border-0 rounded-4">
                    <div class="card-body p-4">
                        <form id="formUsuario">
                            <div class="mb-3">
                                <label class="form-label fw-bold small">NOME COMPLETO</label>
                                <input type="text" id="nome" class="form-control form-control-lg" placeholder="Ex: João Silva" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold small">E-MAIL (LOGIN)</label>
                                <input type="email" id="email" class="form-control form-control-lg" placeholder="email@escola.com" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold small">SENHA</label>
                                <input type="password" id="senha" class="form-control form-control-lg" required>
                            </div>
                            <div class="mb-4">
                                <label class="form-label fw-bold small">PERFIL DE ACESSO</label>
                                <select id="perfil" class="form-select form-select-lg">
                                    <option value="solicitante">Solicitante (Professor/Funcionário)</option>
                                    <option value="tecnico">Técnico (Manutenção)</option>
                                    <option value="gestor">Gestor (Administrador)</option>
                                </select>
                            </div>
                            <button type="button" onclick="enviarUsuario()" class="btn btn-primary w-100 py-3 fw-bold shadow-sm" style="background: #1a237e;">
                                <i class="bi bi-person-plus-fill me-2"></i> REGISTRAR USUÁRIO
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        async function enviarUsuario() {
            const btn = document.querySelector('button');
            const dados = {
                nome: document.getElementById('nome').value.trim(),
                email: document.getElementById('email').value.trim(),
                senha: document.getElementById('senha').value,
                perfil: document.getElementById('perfil').value
            };

            if(!dados.nome || !dados.email || !dados.senha) {
                alert("Por favor, preencha todos os campos obrigatórios.");
                return;
            }

            try {
                btn.disabled = true;
                btn.innerHTML = "Processando...";

                // Verifique se o caminho da API está correto (api/api_usuarios.php)
                const res = await fetch('api/api_usuarios.php', {
                    method: 'POST',
                    headers: {'Content-Type': 'application/json'},
                    body: JSON.stringify(dados)
                });

                // Se a resposta não for OK (404 ou 500), vai cair no catch
                if (!res.ok) throw new Error('Erro no servidor');

                const result = await res.json();
                
                if(result.success) {
                    alert("Sucesso: " + result.message);
                    window.location.href = 'config_usuarios.php';
                } else {
                    alert("Atenção: " + result.message);
                    btn.disabled = false;
                    btn.innerHTML = '<i class="bi bi-person-plus-fill me-2"></i> REGISTRAR USUÁRIO';
                }
            } catch (e) {
                console.error(e);
                alert("Erro de conexão: Verifique se o arquivo api/api_usuarios.php existe ou se há erro no PHP.");
                btn.disabled = false;
                btn.innerHTML = '<i class="bi bi-person-plus-fill me-2"></i> REGISTRAR USUÁRIO';
            }
        }
    </script>
</body>
</html>