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

<meta name="viewport"
content="width=device-width, initial-scale=1.0">

<title>SGM - Avaliações Técnicas</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
rel="stylesheet">

<link rel="stylesheet"
href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<style>

body{
    background:#f5f7fb;
    font-family:"Segoe UI",sans-serif;
}

.navbar-custom{
    background:linear-gradient(45deg,#1a237e,#283593);
}

.page-header{
    background:rgba(255,255,255,.9);
    backdrop-filter:blur(10px);
    border-radius:28px;
    padding:30px;
    border:1px solid rgba(26,35,126,.08);
    box-shadow:0 15px 40px rgba(0,0,0,.05);
    margin-bottom:30px;
}

.page-title{
    color:#1a237e;
    font-weight:800;
    display:flex;
    align-items:center;
    gap:15px;
}

.page-title i{
    width:60px;
    height:60px;
    border-radius:18px;
    display:flex;
    align-items:center;
    justify-content:center;
    background:rgba(26,35,126,.08);
    color:#1a237e;
    font-size:1.8rem;
}

.table-card{
    background:rgba(255,255,255,.9);
    backdrop-filter:blur(10px);
    border-radius:28px;
    overflow:hidden;
    border:1px solid rgba(26,35,126,.08);
    box-shadow:0 15px 40px rgba(0,0,0,.05);
}

.table{
    margin-bottom:0;
}

.table thead{
    background:linear-gradient(45deg,#1a237e,#283593);
    color:white;
}

.table thead th{
    border:none;
    padding:18px;
}

.table tbody td{
    padding:18px;
    vertical-align:middle;
}

.table tbody tr:hover{
    background:rgba(26,35,126,.03);
}

.ticket-id{
    font-weight:800;
    color:#1a237e;
}

.btn-foto{
    border:none;
    border-radius:12px;
    padding:8px 14px;
    background:linear-gradient(45deg,#1a237e,#283593);
    color:white;
}

.btn-foto:hover{
    color:white;
}

.solucao-box{
    max-width:350px;
    white-space:normal;
    word-break:break-word;
}

.modal-content{
    border-radius:24px;
    overflow:hidden;
    border:none;
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

    <div class="page-header">

        <h2 class="page-title">

            <i class="bi bi-clipboard2-check-fill"></i>

            Avaliações Técnicas

        </h2>

    </div>

    <div class="table-card">

        <div class="table-responsive">

            <table class="table align-middle">

                <thead>

                    <tr>

                        <th>Chamado</th>

                        <th>Técnico</th>

                        <th>Tempo Gasto</th>

                        <th>Solução Técnica</th>

                        <th>Foto</th>

                        <th>Status</th>

                    </tr>

                </thead>

                <tbody id="tabelaAvaliacoes">

                </tbody>

            </table>

        </div>

    </div>

</main>

<div class="modal fade"
id="modalFoto"
tabindex="-1">

    <div class="modal-dialog modal-lg modal-dialog-centered">

        <div class="modal-content">

            <div class="modal-body p-0 text-center bg-dark">

                <img id="imgModal"
                class="img-fluid">

            </div>

            <div class="modal-footer">

                <button class="btn btn-secondary"
                data-bs-dismiss="modal">

                    Fechar

                </button>

            </div>

        </div>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>

    function verFoto(url){

        document.getElementById('imgModal').src = url;

        new bootstrap.Modal(
            document.getElementById('modalFoto')
        ).show();
    }

    async function carregarAvaliacoes(){

        const res = await fetch(
            'api/gestor_avaliacao.php'
        );

        const dados = await res.json();

        const tabela =
        document.getElementById('tabelaAvaliacoes');

        tabela.innerHTML = dados.map(a => `

            <tr>

                <td>

                    <span class="ticket-id">

                        #${a.id_chamado}

                    </span>

                </td>

                <td>

                    ${a.tecnico ?? '-'}

                </td>

                <td>

                    ${a.tempo_gasto_minutos ?? 0} min

                </td>

                <td>

                    <div class="solucao-box">

                        ${a.solucao_tecnica ?? ''}

                    </div>

                </td>

                <td>

                    ${
                        a.foto_conclusao

                        ?

                        `<button
                            class="btn btn-foto"
                            onclick="verFoto('${a.foto_conclusao}')">

                            <i class="bi bi-image"></i>

                            Ver Foto

                        </button>`

                        :

                        '<span class="text-muted">Sem foto</span>'
                    }

                </td>

                <td>

                    <span class="badge bg-success">

                        ${a.status}

                    </span>

                </td>

            </tr>

        `).join('');
    }

    carregarAvaliacoes();

</script>

</body>

</html>