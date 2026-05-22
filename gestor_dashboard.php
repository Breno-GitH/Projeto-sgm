<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SGM - Dashboard Gestor</title>

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
            background: linear-gradient(45deg, #1a237e, #283593);
        }

        .card-stat{
            border: none;
            border-radius: 24px;
            transition: 0.3s;
            overflow: hidden;
        }

        .card-stat:hover{
            transform: translateY(-6px);
        }

        .tech-sidebar{

            background: rgba(255,255,255,0.92);

            backdrop-filter: blur(10px);

            border-radius: 28px;

            padding: 28px;

            height: 100%;

            position: relative;

            overflow: hidden;

            border: 1px solid rgba(26,35,126,0.08);

            box-shadow: 0 15px 40px rgba(0,0,0,0.05);

        }

        .sidebar-glow{

            position: absolute;

            width: 220px;
            height: 220px;

            border-radius: 50%;

            background: rgba(26,35,126,0.08);

            top: -100px;
            right: -100px;

        }

        .sidebar-title{

            font-weight: 800;

            color: #1a237e;

            margin-bottom: 30px;

            position: relative;

            z-index: 2;

        }

        .side-item{

            display: flex;

            align-items: center;

            gap: 15px;

            padding: 18px 20px;

            border-radius: 18px;

            text-decoration: none;

            color: #1a237e;

            margin-bottom: 15px;

            transition: 0.3s;

            position: relative;

            z-index: 2;

            background: rgba(26,35,126,0.03);

        }

        .side-item:hover{

            transform: translateX(6px);

            background: rgba(26,35,126,0.08);

            color: #1a237e;

        }

        .side-item i{

            font-size: 1.4rem;

        }

        .side-item span{

            font-weight: 600;

        }

        .dashboard-btn{

            width: 100%;

            border: none;

            border-radius: 24px;

            padding: 24px;

            font-weight: 700;

            font-size: 1rem;

            color: white;

            background: linear-gradient(
                45deg,
                #111827,
                #1f2937
            );

            display: flex;

            justify-content: center;

            align-items: center;

            gap: 12px;

            text-decoration: none;

            transition: 0.3s;

            box-shadow: 0 15px 35px rgba(0,0,0,0.18);

        }

        .dashboard-btn:hover{

            transform: translateY(-4px);

            color: white;

        }

        .section-title{
            color: #64748b;
            font-weight: 700;
        }

        @media(max-width: 991px){

            .tech-sidebar{
                margin-bottom: 25px;
            }

        }

    </style>
</head>

<body>

    <header>

        <nav class="navbar navbar-expand-lg navbar-dark navbar-custom shadow-sm">

            <div class="container">

                <span class="navbar-brand mb-0 h1 fw-bold">
                    SGM | Painel do Gestor
                </span>

                <div class="d-flex align-items-center gap-3">

                    <span class="text-white-50">
                        Olá,
                        <strong>
                            <?php echo $_SESSION['user_nome'] ?? 'João Gestor'; ?>
                        </strong>
                    </span>

                    <a href="api/logout.php"
                    class="btn btn-outline-light btn-sm rounded-3">
                        Sair
                    </a>

                </div>

            </div>

        </nav>

    </header>

    <main class="container py-4">

        <div class="row g-4 align-items-stretch">

            <!-- SIDEBAR -->

            <div class="col-lg-3">

                <div class="sidebar">

                    <div class="sidebar-glow"></div>

                    <h5 class="sidebar-title">
                        Ferramentas
                    </h5>

                    <a href="config_ambientes.php" class="side-item">

                        <i class="bi bi-geo-alt"></i>

                        <span>Ambientes</span>

                    </a>

                    <a href="config_blocos.php" class="side-item">

                        <i class="bi bi-building"></i>

                        <span>Blocos</span>

                    </a>

                    <a href="config_tipos_servico.php" class="side-item">

                        <i class="bi bi-wrench-adjustable"></i>

                        <span>Tipos de Serviço</span>

                    </a>

                    <a href="config_usuarios.php" class="side-item">

                        <i class="bi bi-people"></i>

                        <span>Usuários</span>

                    </a>

                </div>

            </div>


            <!-- DASHBOARD -->

            <div class="col-lg-9">

                <h3 class="section-title mb-4">
                    Visão Geral
                </h3>

                <div class="row g-4 mb-4">

                    <div class="col-md-4">

                        <div class="card card-stat bg-primary text-white shadow-lg">

                            <div class="card-body p-4">

                                <div class="d-flex justify-content-between align-items-center">

                                    <div>

                                        <h6 class="text-uppercase small fw-bold">
                                            Novos Chamados
                                        </h6>

                                        <h1 class="fw-bold mb-0" id="novos-chamados">
                                            -
                                        </h1>

                                    </div>

                                    <i class="bi bi-envelope-paper fs-1"></i>

                                </div>

                            </div>

                        </div>

                    </div>


                    <div class="col-md-4">

                        <div class="card card-stat bg-warning text-dark shadow-lg">

                            <div class="card-body p-4">

                                <div class="d-flex justify-content-between align-items-center">

                                    <div>

                                        <h6 class="text-uppercase small fw-bold">
                                            Em Atendimento
                                        </h6>

                                        <h1 class="fw-bold mb-0" id="em-atendimento">
                                            -
                                        </h1>

                                    </div>

                                    <i class="bi bi-tools fs-1"></i>

                                </div>

                            </div>

                        </div>

                    </div>


                    <div class="col-md-4">

                        <div class="card card-stat bg-danger text-white shadow-lg">

                            <div class="card-body p-4">

                                <div class="d-flex justify-content-between align-items-center">

                                    <div>

                                        <h6 class="text-uppercase small fw-bold">
                                            Críticos/Urgentes
                                        </h6>

                                        <h1 class="fw-bold mb-0" id="urgentes">
                                            -
                                        </h1>

                                    </div>

                                    <i class="bi bi-exclamation-triangle fs-1"></i>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>


                <a href="gestor_chamados.php"
                class="dashboard-btn">

                    <i class="bi bi-list-check"></i>

                    GERENCIAR TODOS OS CHAMADOS

                </a>

            </div>

        </div>

    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Carregar dados da Visão Geral
        async function carregarDashboard() {
            try {
                const response = await fetch('api/dashboard_gestor.php');
                const data = await response.json();

                console.log('Resposta da API:', data);

                if (data.success === false) {
                    console.error('Erro da API:', data.message);
                    return;
                }

                document.getElementById('novos-chamados').textContent = data.abertos || 0;
                document.getElementById('em-atendimento').textContent = data.em_execucao || 0;
                document.getElementById('urgentes').textContent = data.urgentes || 0;
                
                console.log('Dashboard atualizado com sucesso');
            } catch (error) {
                console.error('Erro ao carregar dashboard:', error);
            }
        }

        // Carregar dados ao iniciar a página
        document.addEventListener('DOMContentLoaded', carregarDashboard);
    </script>

</body>

</html>