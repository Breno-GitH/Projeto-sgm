<!DOCTYPE html>
<html lang="pt-br">

<head>

    <meta charset="UTF-8">

    <title>
        SGM - Gestão de Usuários
    </title>

    <meta name="viewport"
    content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">

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

            background: linear-gradient(
                45deg,
                #1a237e,
                #283593
            );

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

            padding: 22px 20px;

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

        .user-name{

            font-weight: 700;

            color: #1a237e;

        }

        .user-email{

            color: #64748b;

            font-size: 0.95rem;

        }

        .perfil-badge{

            background: rgba(26,35,126,0.10);

            color: #1a237e;

            padding: 10px 16px;

            border-radius: 14px;

            font-weight: 700;

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

            text-decoration: none;

            display: inline-flex;

            align-items: center;

            gap: 8px;

        }

        .btn-manage:hover{

            transform: translateY(-3px);

            color: white;

            box-shadow: 0 10px 25px rgba(26,35,126,0.20);

        }

        .btn-remove{

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

        .btn-remove:hover{

            transform: translateY(-3px);

            color: white;

            box-shadow: 0 10px 25px rgba(220,53,69,0.20);

        }

    </style>

</head>

<body class="bg-light">

<header>

    <nav class="navbar navbar-expand-lg navbar-dark navbar-custom shadow-sm mb-4">

        <div class="container">

            <a class="navbar-brand fw-bold"
            href="#">

                SGM - Gerenciamento de usuarios

            </a>

            <div class="d-flex align-items-center gap-3">

                <a href="gestor_dashboard.php"
                class="btn btn-outline-light btn-sm rounded-3">

                    <i class="bi bi-arrow-left"></i>

                    Voltar

                </a>

                <span class="text-white">

                    Olá,
                    <?php echo $_SESSION['user_nome'] ?? 'Usuário'; ?>

                </span>

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

        <h2 class="page-title">

            <i class="bi bi-people-fill"></i>

            Gestão de Usuários

        </h2>

    </div>


    <!-- TABELA -->

    <div class="table-card">

        <div class="table-responsive">

            <table class="table align-middle">

                <thead>

                    <tr>

                        <th>Nome</th>

                        <th>E-mail</th>

                        <th>Perfil</th>

                        <th class="text-center"
                        style="width: 280px;">

                            Ações

                        </th>

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

            const res = await fetch(
                'api/api_usuarios.php'
            );

            const result = await res.json();

            if(result.success) {

                const tbody = document.getElementById(
                    'tabela-usuarios'
                );

                tbody.innerHTML = result.data.map(u => `

                    <tr>

                        <td>

                            <div class="user-name">

                                ${u.nome}

                            </div>

                        </td>

                        <td>

                            <div class="user-email">

                                ${u.email}

                            </div>

                        </td>

                        <td>

                            <span class="perfil-badge">

                                ${u.perfil}

                            </span>

                        </td>

                        <td class="text-center">

                            <a href="config_usuarios_detalhes.php?id=${u.id_usuario}"
                            class="btn-manage me-2">

                                <i class="bi bi-pencil-square"></i>

                                Gerenciar

                            </a>

                            <button onclick="excluir(${u.id_usuario})"
                            class="btn btn-remove">

                                <i class="bi bi-trash-fill"></i>

                                Remover

                            </button>

                        </td>

                    </tr>

                `).join('');

            }

        } catch (e) {

            console.error(
                "Erro ao carregar lista:",
                e
            );

        }

    }


    async function excluir(id) {

        if(!confirm(
            'Tem certeza que deseja excluir este usuário?'
        )) return;

        const res = await fetch(
            'api/api_usuarios.php',
            {

                method: 'DELETE',

                headers: {
                    'Content-Type': 'application/json'
                },

                body: JSON.stringify({
                    id_usuario: id
                })

            }
        );

        const r = await res.json();

        alert(r.message);

        if(r.success)
            carregar();

    }

    window.onload = carregar;

</script>

</body>
</html>