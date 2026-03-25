<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>SGM - Gestão de Usuários</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body class="bg-light">
      <header>
        <nav class="navbar mb-4 shadow-sm" data-bs-theme="dark" style="background-color: #1a237e; border-bottom: 1px solid #283593;">
            <div class="container">
                <a class="navbar-brand" href="#">SGM - Gerenciamento de usuarios</a>
                <div class="d-flex align-items-center gap-3">
                    <div class="d-flex align-items-center">
                <a href="gestor_dashboard.php" class="btn btn-outline-light btn-sm me-3">
                    <i class="bi bi-arrow-left"></i> Voltar
                </a>
                    <span class="text-white">Olá, <?php echo $_SESSION['user_nome'] ?? 'Usuário'; ?></span>
                    <a href="api/logout.php" class="btn btn-outline-light btn-sm">Sair</a>
                </div>
            </div>
        </nav>
    </header>

    <main class="container">
        <div class="card shadow-sm border-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th>Nome</th>
                            <th>E-mail</th>
                            <th>Perfil</th>
                            <th class="text-center" style="width: 250px;">Ações</th>
                        </tr>
                    </thead>
                    <tbody id="tabela-usuarios">
                        </tbody>
                </table>
            </div>
        </div>
    </main>

    <script>
        async function carregar() {
            try {
                const res = await fetch('api/api_usuarios.php');
                const result = await res.json();
                
                if(result.success) {
                    const tbody = document.getElementById('tabela-usuarios');
                    tbody.innerHTML = result.data.map(u => `
                        <tr>
                            <td><strong>${u.nome}</strong></td>
                            <td>${u.email}</td>
                            <td><span class="badge bg-secondary">${u.perfil}</span></td>
                            <td class="text-center">
                                <a href="config_usuarios_detalhes.php?id=${u.id_usuario}" class="btn btn-primary btn-sm me-2">
                                    <i class="bi bi-pencil-square"></i> Gerenciar
                                </a>
                                
                                <button onclick="excluir(${u.id_usuario})" class="btn btn-danger btn-sm">
                                    <i class="bi bi-trash"></i> Remover
                                </button>
                            </td>
                        </tr>
                    `).join('');
                }
            } catch (e) {
                console.error("Erro ao carregar lista:", e);
            }
        }

        async function excluir(id) {
            if(!confirm('Tem certeza que deseja excluir este usuário?')) return;
            const res = await fetch('api/api_usuarios.php', {
                method: 'DELETE',
                headers: {'Content-Type': 'application/json'},
                body: JSON.stringify({id_usuario: id})
            });
            const r = await res.json();
            alert(r.message);
            if(r.success) carregar();
        }

        window.onload = carregar;
    </script>
</body>
</html>