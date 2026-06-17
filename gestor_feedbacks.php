<?php
session_start();
require_once 'config/database.php'; // Ajuste o caminho se necessário

if(!isset($_SESSION['user_id']) || $_SESSION['user_perfil'] !== 'gestor'){
    header("Location: login.php");
    exit;
}

// 1. Buscar Totais para os Cards
$sql_likes = "SELECT COUNT(*) as total FROM feedback_servico WHERE avaliacao = 'like'";
$res_likes = $conn->query($sql_likes);
$total_likes = $res_likes ? $res_likes->fetch_assoc()['total'] : 0;

$sql_dislikes = "SELECT COUNT(*) as total FROM feedback_servico WHERE avaliacao = 'dislike'";
$res_dislikes = $conn->query($sql_dislikes);
$total_dislikes = $res_dislikes ? $res_dislikes->fetch_assoc()['total'] : 0;

// 2. Buscar a lista de Feedbacks com Nome do Solicitante
$sql_feedbacks = "
    SELECT 
        f.id_chamado, 
        f.avaliacao, 
        f.motivo_dislike, 
        f.data_envio,
        u.nome as nome_solicitante
    FROM feedback_servico f
    JOIN chamados c ON f.id_chamado = c.id_chamado
    JOIN usuarios u ON c.id_solicitante = u.id_usuario
    ORDER BY f.data_envio DESC
";
$resultado = $conn->query($sql_feedbacks);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SGM - Feedbacks dos Usuários</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <style>
        body { 
            background: #f5f7fb; 
            overflow-x: hidden; 
            position: relative; 
            font-family: "Segoe UI", sans-serif; 
        }
        
        body::before { 
            content: ""; 
            position: fixed; 
            inset: 0; 
            background: radial-gradient(circle at 20% 20%, rgba(26,35,126,0.04) 0%, transparent 25%), 
                        radial-gradient(circle at 80% 70%, rgba(40,53,147,0.04) 0%, transparent 25%), 
                        linear-gradient(rgba(26,35,126,0.025) 1px, transparent 1px), 
                        linear-gradient(90deg, rgba(26,35,126,0.025) 1px, transparent 1px); 
            background-size: auto, auto, 40px 40px, 40px 40px; 
            z-index: -1; 
        }
        
        .navbar-custom { 
            background: linear-gradient(45deg, #1a237e, #283593); 
        }
        
        .card-stat { 
            border: none; 
            border-radius: 24px; 
            transition: 0.3s; 
            overflow: hidden; 
        }
        
        .card-stat:hover { 
            transform: translateY(-6px); 
        }
        
        .section-title { 
            color: #1a237e; 
            font-weight: 800; 
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .section-title i {
            background: rgba(26,35,126,0.08);
            padding: 12px;
            border-radius: 14px;
            font-size: 1.5rem;
        }
        
        .table-card { 
            background: rgba(255,255,255,0.92);
            backdrop-filter: blur(10px);
            border-radius: 24px; 
            padding: 24px; 
            box-shadow: 0 15px 40px rgba(0,0,0,0.05); 
            border: 1px solid rgba(26,35,126,0.08); 
        }

        .table thead {
            background: linear-gradient(45deg, #1a237e, #283593);
            color: white;
        }

        .table thead th {
            border: none;
            padding: 16px;
            font-weight: 600;
        }

        .table tbody td {
            padding: 16px;
            vertical-align: middle;
            border-color: #eef2ff;
        }
        
        .badge-like { 
            background-color: rgba(25, 135, 84, 0.1); 
            color: #198754; 
            padding: 8px 12px; 
            border-radius: 12px; 
            font-weight: 600; 
            display: inline-block;
        }
        
        .badge-dislike { 
            background-color: rgba(220, 53, 69, 0.1); 
            color: #dc3545; 
            padding: 8px 12px; 
            border-radius: 12px; 
            font-weight: 600; 
            display: inline-block;
        }
    </style>
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark navbar-custom shadow-sm">
            <div class="container">
                <span class="navbar-brand mb-0 h1 fw-bold">SGM | Painel do Gestor</span>
                <div class="d-flex align-items-center gap-3">
                    <span class="text-white-50">Olá, <strong><?php echo $_SESSION['user_nome'] ?? 'Gestor'; ?></strong></span>
                    <a href="gestor_dashboard.php" class="btn btn-outline-light btn-sm rounded-3 me-2"><i class="bi bi-arrow-left"></i> Voltar</a>
                    <a href="api/logout.php" class="btn btn-outline-light btn-sm rounded-3">Sair</a>
                </div>
            </div>
        </nav>
    </header>

    <main class="container py-5">
        <div class="row justify-content-center">
            
            <div class="col-12 col-xl-10 mx-auto">
                
                <h3 class="section-title mb-4">
                    <i class="bi bi-chat-left-heart"></i> Feedbacks e Avaliações
                </h3>

                <div class="row g-4 mb-4">
                    <div class="col-md-6">
                        <div class="card card-stat bg-success-subtle text-success-emphasis shadow-sm h-100">
                            <div class="card-body p-4 d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-uppercase small fw-bold mb-1">Total de Elogios (Likes)</h6>
                                    <h1 class="fw-bold mb-0 display-5"><?php echo $total_likes; ?></h1>
                                </div>
                                <i class="bi bi-hand-thumbs-up-fill display-4 text-success opacity-75"></i>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card card-stat bg-danger-subtle text-danger-emphasis shadow-sm h-100">
                            <div class="card-body p-4 d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-uppercase small fw-bold mb-1">Críticas / Ajustes (Dislikes)</h6>
                                    <h1 class="fw-bold mb-0 display-5"><?php echo $total_dislikes; ?></h1>
                                </div>
                                <i class="bi bi-hand-thumbs-down-fill display-4 text-danger opacity-75"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="table-card mt-2">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="rounded-top">
                                <tr>
                                    <th scope="col" style="width: 100px; border-top-left-radius: 12px;">Chamado</th>
                                    <th scope="col">Solicitante</th>
                                    <th scope="col">Avaliação</th>
                                    <th scope="col">Motivo / Justificativa</th>
                                    <th scope="col" style="border-top-right-radius: 12px;">Data</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($resultado && $resultado->num_rows > 0): ?>
                                    <?php while($row = $resultado->fetch_assoc()): ?>
                                        <?php 
                                            $is_like = ($row['avaliacao'] == 'like');
                                            $class = $is_like ? 'badge-like' : 'badge-dislike';
                                            $icon = $is_like ? 'bi-hand-thumbs-up-fill' : 'bi-hand-thumbs-down-fill';
                                            $texto = $is_like ? 'Resolvido' : 'Problema Persiste';
                                            $motivo = !empty($row['motivo_dislike']) ? '"' . htmlspecialchars($row['motivo_dislike']) . '"' : '<em class="text-muted small">Sem observações adicionais</em>';
                                        ?>
                                        <tr>
                                            <td><strong class="text-primary fs-5">#<?php echo $row['id_chamado']; ?></strong></td>
                                            <td class="fw-medium text-dark"><?php echo htmlspecialchars($row['nome_solicitante']); ?></td>
                                            <td>
                                                <span class="<?php echo $class; ?>">
                                                    <i class="bi <?php echo $icon; ?> me-1"></i> <?php echo $texto; ?>
                                                </span>
                                            </td>
                                            <td><?php echo $motivo; ?></td>
                                            <td class="text-muted small fw-medium">
                                                <i class="bi bi-calendar3 me-1"></i> <?php echo date('d/m/Y H:i', strtotime($row['data_envio'])); ?>
                                            </td>
                                        </tr>
                                    <?php endwhile; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="5" class="text-center py-5 text-muted">
                                            <i class="bi bi-inbox fs-1 d-block mb-3 opacity-50"></i>
                                            Nenhum feedback registrado até o momento.
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>