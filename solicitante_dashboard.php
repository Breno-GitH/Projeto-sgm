<?php 
session_start();
require_once 'config/database.php'; 

if(!isset($_SESSION['user_id']) || $_SESSION['user_perfil'] !== 'solicitante'){
    header("Location: login.php");
    exit;
}

$id_usuario = $_SESSION['user_id'];

$sql = "SELECT
            c.id_chamado,
            c.descricao_problema,
            c.status,
            c.data_abertura,
            a.nome as nome_ambiente,
            ca.caminho_arquivo

        FROM chamados c

        JOIN ambientes a
        ON c.id_ambiente = a.id_ambiente

        LEFT JOIN chamados_anexos ca
        ON c.id_chamado = ca.id_chamado
        AND ca.tipo_anexo = 'abertura'

        WHERE c.id_solicitante = $id_usuario

        ORDER BY c.id_chamado DESC";

$resultado = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
    content="width=device-width, initial-scale=1.0">

    <title>SGM - Painel</title>

    <link rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">

    <link rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<style>

    body{
        background: #f5f7fb;
        overflow-x: hidden;
        position: relative;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    body::before{

        content: "";

        position: fixed;

        inset: 0;

        background:

        radial-gradient(
            circle at 20% 20%,
            rgba(26,35,126,0.04) 0%,
            transparent 25%
        ),

        radial-gradient(
            circle at 80% 70%,
            rgba(40,53,147,0.04) 0%,
            transparent 25%
        ),

        linear-gradient(
            rgba(26,35,126,0.025) 1px,
            transparent 1px
        ),

        linear-gradient(
            90deg,
            rgba(26,35,126,0.025) 1px,
            transparent 1px
        );

        background-size:
            auto,
            auto,
            40px 40px,
            40px 40px;

        z-index: -1;
    }

    .navbar-custom{

        background: linear-gradient(
            45deg,
            #1a237e,
            #283593
        );

        border-bottom: 1px solid #3949ab;
    }

    .panel-header{

        background: rgba(255,255,255,0.92);

        backdrop-filter: blur(10px);

        border-radius: 28px;

        padding: 30px;

        margin-bottom: 30px;

        border: 1px solid rgba(26,35,126,0.08);

        box-shadow: 0 15px 40px rgba(0,0,0,0.05);
    }

    .panel-title{

        color: #1a237e;

        font-weight: 800;

        display: flex;

        align-items: center;

        gap: 15px;

        margin: 0;
    }

    .panel-title i{

        width: 60px;

        height: 60px;

        border-radius: 18px;

        display: flex;

        align-items: center;

        justify-content: center;

        background: rgba(26,35,126,0.08);

        color: #1a237e;

        font-size: 1.8rem;
    }

    .btn-new{

        border: none;

        border-radius: 16px;

        padding: 14px 22px;

        font-weight: 700;

        background: linear-gradient(
            45deg,
            #1a237e,
            #283593
        );

        color: white;

        text-decoration: none;

        transition: 0.3s;

        box-shadow: 0 10px 25px rgba(26,35,126,0.18);
    }

    .btn-new:hover{

        transform: translateY(-3px);

        color: white;
    }

    .table-card{

        background: rgba(255,255,255,0.92);

        backdrop-filter: blur(10px);

        border-radius: 28px;

        overflow: hidden;

        border: 1px solid rgba(26,35,126,0.08);

        box-shadow: 0 15px 40px rgba(0,0,0,0.05);
    }

    .table thead{

        background: linear-gradient(
            45deg,
            #1a237e,
            #283593
        );

        color: white;
    }

    .table thead th{

        border: none;

        padding: 18px;

        font-size: 0.95rem;

        font-weight: 700;
    }

    .table tbody td,
    .table tbody th{

        padding: 18px;

        vertical-align: middle;

        border-color: #eef2ff;
    }

    .table tbody tr{

        transition: 0.2s;
    }

    .table tbody tr:hover{

        background: rgba(26,35,126,0.03);
    }

    .ticket-id{

        color: #1a237e;

        font-weight: 800;
    }

    .ticket-image{

        width: 60px;

        height: 60px;

        object-fit: cover;

        border-radius: 16px;

        border: 2px solid rgba(26,35,126,0.08);
    }

    .local-box{

        background: rgba(26,35,126,0.06);

        color: #1a237e;

        padding: 8px 14px;

        border-radius: 12px;

        font-weight: 700;

        display: inline-block;
    }

    .desc-box{

        color: #555;

        max-width: 280px;
    }

    .badge{

        padding: 10px 14px;

        border-radius: 12px;

        font-size: 0.82rem;

        font-weight: 700;
    }

    .empty-box{

        padding: 60px;

        text-align: center;

        color: #64748b;
    }

    .empty-box i{

        font-size: 4rem;

        color: #1a237e;

        opacity: 0.7;
    }

</style>

</head>

<body>

<header>

    <nav class="navbar navbar-expand-lg navbar-dark navbar-custom shadow-sm">

        <div class="container">

            <a class="navbar-brand fw-bold"
            href="#">

                SGM - Painel do Solicitante

            </a>

            <div class="d-flex align-items-center gap-3">

                <span class="text-white">

                    Olá,
                    <?php echo $_SESSION['user_nome'] ?? 'Usuário'; ?>

                </span>

                <a href="api/logout.php"
                class="btn btn-outline-light btn-sm rounded-3">

                    <i class="bi bi-box-arrow-right"></i>

                    Sair

                </a>

            </div>

        </div>

    </nav>

</header>


<main class="container py-4">

    <div class="panel-header d-flex justify-content-between align-items-center flex-wrap gap-3">

        <h1 class="panel-title">

            <i class="bi bi-clipboard2-check-fill"></i>

            Minhas Solicitações

        </h1>

        <a href="solicitante_abrir_chamado.php"
        class="btn-new">

            <i class="bi bi-plus-circle-fill"></i>

            Nova Solicitação

        </a>

    </div>


    <div class="table-card">

        <div class="table-responsive">

            <table class="table table-hover mb-0">

                <thead>

                    <tr>

                        <th scope="col">ID</th>

                        <th scope="col">Foto</th>

                        <th scope="col">Local</th>

                        <th scope="col">Descrição</th>

                        <th scope="col">Data</th>

                        <th scope="col">Status</th>

                    </tr>

                </thead>

                <tbody class="table-group-divider">

                    <?php if ($resultado && $resultado->num_rows > 0): ?>

                        <?php while($row = $resultado->fetch_assoc()): ?>

                            <tr>

                                <th scope="row"
                                class="ticket-id">

                                    #<?php echo $row['id_chamado']; ?>

                                </th>

                                <td>

                                    <?php if(!empty($row['caminho_arquivo'])): ?>

                                        <img src="<?php echo $row['caminho_arquivo']; ?>"
                                        alt="Foto"
                                        class="ticket-image">

                                    <?php else: ?>

                                        <span class="text-muted small">

                                            <i class="bi bi-image"></i>

                                            Sem foto

                                        </span>

                                    <?php endif; ?>

                                </td>

                                <td>

                                    <span class="local-box">

                                        <?php echo $row['nome_ambiente']; ?>

                                    </span>

                                </td>

                                <td class="desc-box"
                                title="<?php echo $row['descricao_problema']; ?>">

                                    <?php echo mb_strimwidth($row['descricao_problema'], 0, 40, "..."); ?>

                                </td>

                                <td>

                                    <?php echo date('d/m/Y', strtotime($row['data_abertura'])); ?>

                                </td>

                                <td>

                                    <?php

                                        $status = strtolower($row['status']);

                                        $badge_class = ($status == 'aberto')
                                        ? 'text-bg-warning'
                                        : 'text-bg-success';

                                    ?>

                                    <span class="badge <?php echo $badge_class; ?>">

                                        <?php echo ucfirst($status); ?>

                                    </span>

                                </td>

                            </tr>

                        <?php endwhile; ?>

                    <?php else: ?>

                        <tr>

                            <td colspan="6">

                                <div class="empty-box">

                                    <i class="bi bi-inbox-fill"></i>

                                    <h4 class="mt-4">

                                        Nenhuma solicitação encontrada

                                    </h4>

                                    <p>

                                        Você ainda não possui solicitações registradas.

                                    </p>

                                </div>

                            </td>

                        </tr>

                    <?php endif; ?>

                </tbody>

            </table>

        </div>

    </div>

</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>