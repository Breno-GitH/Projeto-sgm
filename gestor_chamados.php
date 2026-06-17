<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['user_perfil'] !== 'gestor') {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>

    <meta charset="UTF-8">

    <title>
        SGM - Gestão de Chamados
    </title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>

        body{
            background: #f5f7fb;
            overflow-x: hidden;
            position: relative;
            font-family: "Segoe UI", sans-serif;
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
            background: linear-gradient(45deg, #1a237e, #283593);
        }

        .page-header{

            background: rgba(255,255,255,0.9);

            backdrop-filter: blur(10px);

            border-radius: 28px;

            padding: 30px;

            border: 1px solid rgba(26,35,126,0.08);

            box-shadow: 0 15px 40px rgba(0,0,0,0.05);

            margin-bottom: 30px;

        }

        .page-title{

            color: #1a237e;

            font-weight: 800;

            margin: 0;

            display: flex;

            align-items: center;

            gap: 15px;

        }

        .page-title i{

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

        .filter-panel{

            background: rgba(255,255,255,0.9);

            backdrop-filter: blur(10px);

            border-radius: 24px;

            padding: 20px;

            margin-bottom: 25px;

            border: 1px solid rgba(26,35,126,0.08);

            box-shadow: 0 10px 30px rgba(0,0,0,0.05);

        }

        .btn-filter{

            border: none;

            padding: 12px 22px;

            border-radius: 14px;

            font-weight: 600;

            transition: 0.3s;

        }

        .btn-filter:hover{

            transform: translateY(-3px);

        }

        .table-card{

            background: rgba(255,255,255,0.9);

            backdrop-filter: blur(10px);

            border-radius: 28px;

            overflow: hidden;

            border: 1px solid rgba(26,35,126,0.08);

            box-shadow: 0 15px 40px rgba(0,0,0,0.05);

        }

        .table{

            margin-bottom: 0;

        }

        .table thead{

            background: linear-gradient(45deg, #1a237e, #283593);

            color: white;

        }

        .table thead th{

            border: none;

            padding: 20px;

            font-size: 0.9rem;

            text-transform: uppercase;

            letter-spacing: 1px;

        }

        .table tbody tr{

            transition: 0.3s;

        }

        .table tbody tr:hover{

            background: rgba(26,35,126,0.03);

            transform: scale(1.003);

        }

        .table tbody td{

            padding: 20px;

            vertical-align: middle;

            border-color: rgba(26,35,126,0.05);

        }

        .ticket-id{

            font-weight: 800;

            color: #1a237e;

        }

        .local-box{

            background: rgba(26,35,126,0.04);

            border-radius: 14px;

            padding: 12px;

        }

        .badge-status{

            padding: 10px 14px;

            border-radius: 12px;

            font-size: 0.75rem;

            font-weight: 700;

            letter-spacing: 0.5px;

        }

        .btn-manage{

            border: none;

            border-radius: 14px;

            padding: 10px 16px;

            background: linear-gradient(
                45deg,
                #1a237e,
                #283593
            );

            color: white;

            font-weight: 600;

            transition: 0.3s;

        }

        .btn-manage:hover{

            transform: translateY(-3px);

            color: white;

            box-shadow: 0 10px 25px rgba(26,35,126,0.25);

        }

        .modal-content{

            border-radius: 24px;

            overflow: hidden;

            border: none;

        }

    </style>

</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-dark navbar-custom shadow-sm mb-4">

        <div class="container">

            <a class="navbar-brand fw-bold"
            href="gestor_dashboard.php">

                SGM Admin

            </a>

            <div class="navbar-nav ms-auto d-flex flex-row gap-3">

                <a class="nav-link active"
                href="gestor_dashboard.php">

                    Voltar

                </a>

                <a class="nav-link active"
                href="gestor_chamados.php">

                    Chamados

                </a>

                <a class="nav-link active"
                href="api/logout.php">

                    Sair

                </a>

            </div>

        </div>

    </nav>


    <main class="container pb-5">

        <!-- HEADER -->

        <div class="page-header">

            <h2 class="page-title">

                <i class="bi bi-clipboard2-check-fill"></i>

                Todos os Chamados

            </h2>

        </div>


        <!-- FILTROS -->

        <div class="filter-panel">

            <div class="d-flex flex-wrap gap-3">

                <button class="btn btn-secondary btn-filter"
                onclick="carregarChamados('')">

                    Todos

                </button>

                <button class="btn btn-primary btn-filter"
                onclick="carregarChamados('aberto')">

                    Abertos

                </button>

                <button class="btn btn-warning btn-filter"
                onclick="carregarChamados('em_execucao')">

                    Em Execução

                </button>

                <button class="btn btn-success btn-filter"
                onclick="carregarChamados('concluido')">

                    Concluídos

                </button>

            </div>

        </div>


        <!-- TABELA -->

        <div class="table-card">

            <div class="table-responsive">

                <table class="table align-middle">

                    <thead>

                        <tr>

                            <th>ID</th>

                            <th>Solicitante</th>

                            <th>Local / Tipo</th>

                            <th>Prioridade</th>

                            <th>Técnico</th>

                            <th>Status</th>

                            <th>Ações</th>

                        </tr>

                    </thead>

                    <tbody id="tabelaGeral">

                    </tbody>

                </table>

            </div>

        </div>

    </main>


    <!-- MODAL FOTO -->

    <div class="modal fade"
    id="modalFoto"
    tabindex="-1"
    aria-hidden="true">

        <div class="modal-dialog modal-lg modal-dialog-centered">

            <div class="modal-content">

                <div class="modal-body p-0 text-center bg-dark">

                    <img src=""
                    id="imgModal"
                    class="img-fluid">

                </div>

                <div class="modal-footer">

                    <button type="button"
                    class="btn btn-secondary"
                    data-bs-dismiss="modal">

                        Fechar

                    </button>

                </div>

            </div>

        </div>

    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>

        function verFoto(url) {

            document.getElementById('imgModal').src = url;

            new bootstrap.Modal(
                document.getElementById('modalFoto')
            ).show();

        }

    </script>


    <script>

        const coresPrioridade = {

            'urgente': 'text-danger',

            'alta': 'text-warning',

            'media': 'text-primary',

            'baixa': 'text-secondary'

        };

        const coresStatus = {

            'aberto': 'bg-secondary',

            'em_execucao': 'bg-warning text-dark',

            'concluido': 'bg-success',

            'fechado': 'bg-dark'

        };


        async function carregarChamados(status = '') {

            const res = await fetch(
                `api/gestor_chamados.php?status=${status}`
            );

            const chamados = await res.json();

            const body = document.getElementById('tabelaGeral');

            body.innerHTML = chamados.map(c => `

                <tr>

                    <td>

                        <span class="ticket-id">
                            #${c.id}
                        </span>

                    </td>

                    <td>

                        <strong>
                            ${c.solicitante}
                        </strong>

                    </td>

                    <td>

                        <div class="local-box">

                            <small class="text-muted">

                                ${c.bloco_nome}

                            </small>

                            <br>

                            <strong>

                                ${c.ambiente}

                            </strong>

                        </div>

                    </td>

                    <td>

                        <i class="bi bi-circle-fill
                        ${coresPrioridade[c.prioridade]}
                        me-1"></i>

                        ${c.prioridade
                            ? c.prioridade.toUpperCase()
                            : 'N/A'}

                    </td>

                    <td>

                        ${c.tecnico ||

                        '<em class="text-muted">Não atribuído</em>'}

                    </td>

                    <td>

                        <span class="badge badge-status
                        ${coresStatus[c.status]}">

                            ${c.status
                                .replace('_', ' ')
                                .toUpperCase()}

                        </span>

                    </td>

                    <td>

                        <a href="gestor_detalhes.php?id=${c.id}"
                        class="btn btn-manage">

                            <i class="bi bi-eye"></i>

                            Gerenciar

                        </a>

                    </td>

                </tr>

            `).join('');

        }

        carregarChamados();

    </script>

</body>

</html>