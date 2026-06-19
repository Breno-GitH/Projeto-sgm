<!DOCTYPE html>
<html lang="pt-br">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
    content="width=device-width, initial-scale=1.0">

    <title>
        SGM - Gerenciar Blocos
    </title>

    <link rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css">

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

            background: rgba(255,255,255,0.92);

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

        .btn-new{

            border: none;

            background: linear-gradient(
                45deg,
                #1a237e,
                #283593
            );

            color: white;

            padding: 14px 22px;

            border-radius: 16px;

            font-weight: 700;

            transition: 0.3s;

            text-decoration: none;

            box-shadow: 0 10px 25px rgba(26,35,126,0.20);

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

        .table{

            margin-bottom: 0;

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

            padding: 20px;

            font-size: 0.9rem;

            text-transform: uppercase;

            letter-spacing: 1px;

        }

        .table tbody td{

            padding: 20px;

            vertical-align: middle;

            border-color: rgba(26,35,126,0.05);

        }

        .table tbody tr{

            transition: 0.3s;

        }

        .table tbody tr:hover{

            background: rgba(26,35,126,0.03);

            transform: scale(1.003);

        }

        .id-box{

            font-weight: 800;

            color: #1a237e;

        }

        .bloco-box{

            background: rgba(26,35,126,0.04);

            padding: 14px;

            border-radius: 14px;

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

            box-shadow: 0 10px 25px rgba(26,35,126,0.20);

        }

        .btn-delete{

            border: none;

            border-radius: 14px;

            padding: 10px 16px;

            background: linear-gradient(
                45deg,
                #dc3545,
                #ef4444
            );

            color: white;

            font-weight: 600;

            transition: 0.3s;

        }

        .btn-delete:hover{

            transform: translateY(-3px);

            color: white;

            box-shadow: 0 10px 25px rgba(220,53,69,0.20);

        }

    </style>

</head>

<body>

    <header>

        <nav class="navbar navbar-expand-lg navbar-dark navbar-custom shadow-sm mb-4">

            <div class="container">

                <a class="navbar-brand fw-bold"
                href="#">

                    SGM - Configurar Blocos

                </a>

                <div class="d-flex align-items-center gap-3">

                    <a href="gestor_dashboard.php"
                    class="btn btn-outline-light btn-sm rounded-3">

                        <i class="bi bi-arrow-left"></i>

                        Voltar

                    </a>

                    <a href="api/logout.php"
                class="btn btn-outline-light btn-sm rounded-3">

                    Sair

                </a>

                </div>

            </div>

        </nav>

    </header>


    <main class="container pb-5">

        <!-- HEADER -->

        <div class="page-header">

            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">

                <h2 class="page-title">

                    <i class="bi bi-building-fill"></i>

                    Blocos

                </h2>

                <a href="config_criar_bloco.php"
                class="btn-new">

                    <i class="bi bi-plus-lg"></i>

                    Novo Bloco

                </a>

            </div>

        </div>


        <!-- TABELA -->

        <div class="table-card">

            <div class="table-responsive">

                <table class="table align-middle">

                    <thead>

                        <tr>

                            <th>ID</th>

                            <th>Nome do Bloco</th>

                            <th>Editar</th>

                            <th>Deletar</th>

                        </tr>

                    </thead>

                    <tbody id="tabela-blocos">

                    </tbody>

                </table>

            </div>

        </div>

    </main>


<script>

    document.addEventListener(
        'DOMContentLoaded',
        carregarBlocos
    );

    async function carregarBlocos() {

        try {

            const response = await fetch(
                'api/api_blocos.php'
            );

            const result = await response.json();

            const tbody = document.getElementById(
                'tabela-blocos'
            );

            if (result.success) {

                tbody.innerHTML = result.data.map(bloco => `

                    <tr>

                        <td>

                            <span class="id-box">

                                #${bloco.id_bloco}

                            </span>

                        </td>

                        <td>

                            <div class="bloco-box">

                                <strong>

                                    ${bloco.nome}

                                </strong>

                            </div>

                        </td>

                        <td>

                            <a href="config_blocos_detalhes.php?id=${bloco.id_bloco}"
                            class="btn btn-manage">

                                <i class="bi bi-gear-fill"></i>

                                Gerenciar

                            </a>

                        </td>

                        <td>

                            <button onclick="excluirBloco(${bloco.id_bloco})"
                            class="btn btn-delete">

                                <i class="bi bi-trash-fill"></i>

                                Deletar

                            </button>

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

        const res = await fetch(
            'api/api_blocos.php',
            {

                method: 'DELETE',

                headers: {
                    'Content-Type': 'application/json'
                },

                body: JSON.stringify({
                    id_bloco: id
                })

            }
        );

        const result = await res.json();

        alert(result.message);

        if (result.success) carregarBlocos();

    }

</script>

</body>
</html>