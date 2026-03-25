<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>SGM - Novo Usuário</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow border-0">
                    <div class="card-header text-white p-3" style="background: linear-gradient(45deg, #1a237e, #283593);">
                        <h5 class="mb-0">Cadastrar Usuário</h5>
                    </div>
                    <div class="card-body p-4 bg-white">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Nome Completo</label>
                            <input type="text" id="nome" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">E-mail (Login)</label>
                            <input type="email" id="email" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Senha Inicial</label>
                            <input type="password" id="senha" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Perfil de Acesso</label>
                            <select id="perfil" class="form-select">
                                <option value="solicitante">Solicitante (Professor/Funcionário)</option>
                                <option value="tecnico">Técnico (Manutenção)</option>
                                <option value="gestor">Gestor (Administrador)</option>
                            </select>
                        </div>
                        <button onclick="enviarUsuario()" class="btn btn-primary w-100 py-3 mt-2 fw-bold">Criar Conta</button>
                        <a href="config_usuarios.php" class="btn btn-link w-100 mt-2 text-muted">Voltar à lista</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        async function enviarUsuario() {
            const dados = {
                nome: document.getElementById('nome').value,
                email: document.getElementById('email').value,
                senha: document.getElementById('senha').value,
                perfil: document.getElementById('perfil').value
            };

            if(!dados.nome || !dados.email || !dados.senha) return alert("Preencha tudo!");

            try {
                const res = await fetch('api/api_usuarios.php', {
                    method: 'POST',
                    headers: {'Content-Type': 'application/json'},
                    body: JSON.stringify(dados)
                });
                const result = await res.json();
                alert(result.message);
                if(result.success) window.location.href = 'config_usuarios.php';
            } catch (e) {
                alert("Erro de conexão.");
            }
        }
    </script>
</body>
</html>