<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>SGM - Usuários</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">
    <header>
        <nav class="navbar mb-4 shadow-sm" data-bs-theme="dark" style="background-color: #1a237e;">
            <div class="container">
                <a class="navbar-brand" href="#">SGM -Usuarios</a>
                <div class="d-flex align-items-center">
                <a href="gestor_dashboard.php" class="btn btn-outline-light btn-sm me-3">
                    <i class="bi bi-arrow-left"></i> Voltar
                </a>
                <a href="painel.php" class="btn btn-outline-light btn-sm">Painel</a>
            </div>
        </nav>
    </header>
    <main class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Usuários do Sistema</h1>
            <a href="config_criar_usuario.php" class="btn btn-success">+ Novo Usuário</a>
        </div>
        <div class="card shadow-sm">
            <table class="table table-hover mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>Nome</th>
                        <th>E-mail</th>
                        <th>Perfil</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody id="tabela-usuarios"></tbody>
            </table>
        </div>
    </main>

<script>
    document.addEventListener('DOMContentLoaded', carregarUsuarios);

    async function carregarUsuarios() {
        const res = await fetch('api/api_usuarios.php');
        const result = await res.json();
        if (result.success) {
            document.getElementById('tabela-usuarios').innerHTML = result.data.map(u => `
                <tr>
                    <td>${u.nome}</td>
                    <td>${u.email}</td>
                    <td><span class="badge bg-info text-dark">${u.perfil}</span></td>
                    <td>
                        <button onclick="excluirUsuario(${u.id_usuario})" class="btn btn-outline-danger btn-sm">Remover</button>
                    </td>
                </tr>
            `).join('');
        }
    }

    async function excluirUsuario(id) {
        if (!confirm('Remover acesso deste usuário?')) return;
        const res = await fetch('api/api_usuarios.php', {
            method: 'DELETE',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ id_usuario: id })
        });
        const result = await res.json();
        alert(result.message);
        carregarUsuarios();
    }
</script>
</body>
</html>