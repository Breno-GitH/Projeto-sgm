<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>SGM - Tipos de Serviço</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css">
</head>
<body>
     <header>
        <nav class="navbar mb-4 shadow-sm" data-bs-theme="dark" style="background-color: #1a237e;">
            <div class="container">
                <a class="navbar-brand" href="#">SGM - Configurar Tipos de serviço</a>
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
            <h1>Tipos de Serviço</h1>
            
            <a href="config_criar_tipo.php" class="btn btn-success">+ Novo Tipo</a>
        </div>
        <table class="table table-hover border shadow-sm">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Nome do Serviço</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody id="tabela-tipos"></tbody>
        </table>
    </main>

<script>
    document.addEventListener('DOMContentLoaded', carregarTipos);

    async function carregarTipos() {
        const res = await fetch('api/api_tipos_servico.php');
        const result = await res.json();
        if (result.success) {
            document.getElementById('tabela-tipos').innerHTML = result.data.map(t => `
                <tr>
                    <td>${t.id_tipo}</td>
                    <td>${t.nome}</td>
                    <td>
                        <button onclick="excluirTipo(${t.id_tipo})" class="btn btn-danger btn-sm">Deletar</button>
                    </td>
                </tr>
            `).join('');
        }
    }

    async function excluirTipo(id) {
        if (!confirm('Deseja excluir?')) return;
        const res = await fetch('api/api_tipos_servico.php', {
            method: 'DELETE',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ id_tipo: id })
        });
        const result = await res.json();
        alert(result.message);
        carregarTipos();
    }
</script>
</body>
</html>