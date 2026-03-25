<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SGM - Dashboard Gestor</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        .card-stat {
            border: none;
            border-radius: 15px;
            transition: transform 0.2s;
        }
        .card-stat:hover {
            transform: translateY(-5px);
        }
        .btn-config {
            padding: 20px;
            font-weight: bold;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 10px;
            border-radius: 12px;
            transition: all 0.3s;
        }
        .btn-config:hover {
            filter: brightness(1.1);
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        a { text-decoration: none; }
    </style>
</head>
<body class="bg-light">

    <header>
        <nav class="navbar navbar-expand-lg navbar-dark mb-4 shadow-sm" style="background: linear-gradient(45deg, #1a237e, #283593);">
            <div class="container">
                <span class="navbar-brand mb-0 h1">SGM | Painel do Gestor</span>
                <div class="d-flex align-items-center gap-3">
                    <span class="text-white-50">Olá, <strong><?php echo $_SESSION['user_nome'] ?? 'João Gestor'; ?></strong></span>
                    <a href="api/logout.php" class="btn btn-outline-light btn-sm">Sair</a>
                </div>
            </div>
        </nav>
    </header>

    <main class="container">
        <h4 class="mb-3 text-secondary">Visão Geral</h4>
        <div class="row g-4 mb-5">
            <div class="col-md-4">
                <div class="card card-stat bg-primary text-white shadow">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h6 class="text-uppercase small">Novos Chamados</h6>
                                <h2 class="mb-0">0</h2>
                            </div>
                            <i class="bi bi-envelope-paper fs-1"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card card-stat bg-warning text-dark shadow">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h6 class="text-uppercase small">Em Atendimento</h6>
                                <h2 class="mb-0">0</h2>
                            </div>
                            <i class="bi bi-tools fs-1"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card card-stat bg-danger text-white shadow">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h6 class="text-uppercase small">Críticos/Urgentes</h6>
                                <h2 class="mb-0">0</h2>
                            </div>
                            <i class="bi bi-exclamation-triangle fs-1"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <h4 class="mb-3 text-secondary">Ferramentas de Configuração</h4>
        <div class="row g-3">
            <div class="col-md-12">
                <a href="gestor_chamados.php" class="btn btn-dark w-100 p-4 mb-3 rounded-3 d-flex align-items-center justify-content-center gap-2 shadow-sm">
                    <i class="bi bi-list-check fs-4"></i> GERENCIAR TODOS OS CHAMADOS
                </a>
            </div>
            
            <div class="col-6 col-md-3">
                <a href="config_ambientes.php" class="btn btn-outline-primary btn-config w-100">
                    <i class="bi bi-geo-alt fs-2"></i> Ambientes
                </a>
            </div>
            <div class="col-6 col-md-3">
                <a href="config_blocos.php" class="btn btn-outline-secondary btn-config w-100">
                    <i class="bi bi-building fs-2"></i> Blocos
                </a>
            </div>
            <div class="col-6 col-md-3">
                <a href="config_tipos_servico.php" class="btn btn-outline-info btn-config w-100">
                    <i class="bi bi-wrench-adjustable fs-2"></i> Tipos de Serviço
                </a>
            </div>
            <div class="col-6 col-md-3">
                <a href="config_usuarios.php" class="btn btn-outline-success btn-config w-100">
                    <i class="bi bi-people fs-2"></i> Usuários
                </a>
            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>