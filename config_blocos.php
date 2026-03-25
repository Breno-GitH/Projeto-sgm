<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SGM - Gerenciar Blocos</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css">
</head>
<body>
    <header>
        <nav class="navbar mb-4 shadow-sm" data-bs-theme="dark" style="background-color: #1a237e;">
            <div class="container">
                <a class="navbar-brand" href="#">SGM - Configurar Blocos</a>
                <div class="d-flex align-items-center">
                <a href="gestor_dashboard.php" class="btn btn-outline-light btn-sm me-3">
                    <i class="bi bi-arrow-left"></i> Voltar
                </a>
                <a href="painel.php" class="btn btn-outline-light btn-sm">Painel</a>
            </div>
        </nav>
    </header>

    <main class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Blocos</h1> 
            <a href="config_criar_bloco.php" class="btn btn-success">+ Novo Bloco</a>
        </div>

        <div class="table-responsive shadow-sm">
            <table class="table table-hover border">
                <thead class="table-light">
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Nome do Bloco</th>
                        <th scope="col">Editar</th>
                        <th scope="col">Deletar</th>
                    </tr>
                </thead>
                <tbody id="tabela-blocos"></tbody> 
            </table>
        </div>
    </main>

<script>
    document.addEventListener('DOMContentLoaded', carregarBlocos);

    async function carregarBlocos() {
        try {
            const response = await fetch('api/api_blocos.php'); 
            const result = await response.json();
            const tbody = document.getElementById('tabela-blocos');

            if (result.success) {
                tbody.innerHTML = result.data.map(bloco => `
                    <tr>
                        <th scope="row">${bloco.id_bloco}</th>
                        <td><strong>${bloco.nome}</strong></td>
                        <td>
                            <a href="config_blocos_detalhes.php?id=${bloco.id_bloco}" class="btn btn-primary btn-sm">Gerenciar</a>
                        </td>
                        <td>
                            <button onclick="excluirBloco(${bloco.id_bloco})" class="btn btn-danger btn-sm">Deletar</button>
                        </td>
                    </tr>
                `).join('');
            }
        } catch (error) {
            console.error('Erro:', error);
        }
    }

    async function excluirBloco(id) {
        if (!confirm('Excluir este bloco?')) return;
        const res = await fetch('api/api_blocos.php', {
            method: 'DELETE',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ id_bloco: id })
        });
        const result = await res.json();
        alert(result.message);
        if (result.success) carregarBlocos();
    }
</script>
</body>
</html>