<!DOCTYPE html>
<html lang="pt-br">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
    content="width=device-width, initial-scale=1.0">

    <title>
        SGM | Técnico
    </title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
    rel="stylesheet">

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

        .content-area{
            margin-top: 45px;
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

        .status-card{

            background: rgba(255,255,255,0.92);

            backdrop-filter: blur(10px);

            border-radius: 28px;

            border: 1px solid rgba(26,35,126,0.08);

            box-shadow: 0 15px 40px rgba(0,0,0,0.05);

            padding: 35px;
        }

        .text-info-vazio{

            color: #64748b;

            font-size: 1.1rem;

            margin-bottom: 0;

            font-weight: 500;
        }

        .task-card{

            background: white;

            border-radius: 22px;

            padding: 22px;

            margin-bottom: 18px;

            transition: 0.3s;

            border: 1px solid rgba(26,35,126,0.06);

            box-shadow: 0 10px 25px rgba(0,0,0,0.04);
        }

        .task-card:hover{

            transform: translateY(-4px);

            box-shadow: 0 18px 35px rgba(0,0,0,0.08);
        }

        .task-priority{

            width: 14px;

            border-radius: 20px;

            align-self: stretch;
        }

        .priority-alta{
            background: #dc3545;
        }

        .priority-media{
            background: #ffc107;
        }

        .priority-baixa{
            background: #0dcaf0;
        }

        .task-id{

            background: #1a237e;

            color: white;

            padding: 6px 12px;

            border-radius: 10px;

            font-size: 0.8rem;

            font-weight: 700;
        }

        .task-date{

            color: #64748b;

            font-size: 0.9rem;
        }

        .task-title{

            color: #1a237e;

            font-weight: 800;

            margin-top: 12px;

            margin-bottom: 8px;
        }

        .task-desc{

            color: #555;

            margin-bottom: 0;

            max-width: 650px;
        }

        .btn-open{

            border: none;

            border-radius: 14px;

            padding: 12px 18px;

            font-weight: 700;

            background: linear-gradient(
                45deg,
                #1a237e,
                #283593
            );

            color: white;

            transition: 0.3s;

            text-decoration: none;

            display: inline-flex;

            align-items: center;

            gap: 8px;

            box-shadow: 0 10px 25px rgba(26,35,126,0.18);
        }

        .btn-open:hover{

            transform: translateY(-3px);

            color: white;
        }

    </style>

</head>

<body>

<header>

    <nav class="navbar navbar-expand-lg navbar-dark navbar-custom shadow-sm">

        <div class="container">

            <span class="navbar-brand fw-bold">

                SGM | Técnico | João

            </span>

            <div class="ms-auto">

                <a href="api/logout.php"
                class="btn btn-outline-light btn-sm rounded-3">

                    <i class="bi bi-box-arrow-right"></i>

                    Sair

                </a>

            </div>

        </div>

    </nav>

</header>


<main class="container content-area">

    <div class="row justify-content-center">

        <div class="col-md-11">

            <!-- HEADER -->

            <div class="page-header">

                <h3 class="page-title">

                    <i class="bi bi-tools"></i>

                    Minha Fila de Trabalho

                </h3>

            </div>


            <!-- TAREFAS -->

            <div id="containerTarefas"
            class="status-card">

                <p class="text-info-vazio">

                    Carregando tarefas...

                </p>

            </div>

        </div>

    </div>

</main>


<script>

async function carregarTarefas() {

    try {

        const res = await fetch(
            'api/tecnico_chamados.php'
        );

        const tarefas = await res.json();

        const container = document.getElementById(
            'containerTarefas'
        );

        if (!tarefas || tarefas.length === 0) {

            container.innerHTML = `

                <div class="text-center py-4">

                    <i class="bi bi-check-circle-fill"
                    style="
                        font-size: 4rem;
                        color: #1a237e;
                        opacity: 0.8;
                    "></i>

                    <p class="text-info-vazio mt-3">

                        Nenhuma Tarefa Pendente

                    </p>

                </div>

            `;

            return;

        }

        container.innerHTML = tarefas.map(t => `

            <div class="task-card d-flex align-items-center gap-4">

                <div class="task-priority priority-${t.prioridade || 'baixa'}">

                </div>

                <div class="flex-grow-1">

                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">

                        <span class="task-id">

                            #${t.id_chamado}

                        </span>

                        <small class="task-date">

                            ${new Date(t.data_abertura).toLocaleDateString()}

                        </small>

                    </div>

                    <h5 class="task-title">

                        ${t.ambiente}
                        -
                        ${t.bloco}

                    </h5>

                    <p class="task-desc">

                        ${t.descricao_problema}

                    </p>

                </div>

            </div>

        `).join('');

    } catch (error) {

        console.error(
            "Erro ao carregar tarefas:",
            error
        );

        document.getElementById(
            'containerTarefas'
        ).innerHTML = `

            <div class="text-center py-4">

                <i class="bi bi-wifi-off"
                style="
                    font-size: 4rem;
                    color: #dc3545;
                "></i>

                <p class="text-danger mt-3">

                    Erro de conexão.

                </p>

            </div>

        `;

    }

}

carregarTarefas();

</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>