<?php 
session_start();

if(!isset($_SESSION['user_id']) || $_SESSION['user_perfil'] !== 'gestor'){
    header("Location: login.php");
    exit;
}

$id_chamado = isset($_GET['id']) ? intval($_GET['id']) : 0;

if (!$id_chamado) {
    header("Location: gestor_chamados.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SGM - Detalhes do Chamado</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body {
            background: #f5f7fb;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .navbar-custom {
            background: linear-gradient(45deg, #1a237e, #283593);
        }

        .page-header {
            background: rgba(255,255,255,0.92);
            backdrop-filter: blur(10px);
            border-radius: 28px;
            padding: 30px;
            border: 1px solid rgba(26,35,126,0.08);
            box-shadow: 0 15px 40px rgba(0,0,0,0.05);
            margin-bottom: 30px;
        }

        .page-title {
            color: #1a237e;
            font-weight: 800;
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .page-title i {
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

        .detail-card {
            background: white;
            border-radius: 22px;
            padding: 30px;
            margin-bottom: 25px;
            border: 1px solid rgba(26,35,126,0.06);
            box-shadow: 0 10px 25px rgba(0,0,0,0.04);
        }

        .detail-section {
            margin-bottom: 30px;
        }

        .detail-section h6 {
            color: #1a237e;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-size: 0.85rem;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 2px solid rgba(26,35,126,0.1);
        }

        .detail-row {
            display: flex;
            gap: 30px;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }

        .detail-item {
            flex: 1;
            min-width: 200px;
        }

        .detail-label {
            color: #64748b;
            font-size: 0.85rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 5px;
        }

        .detail-value {
            color: #1a237e;
            font-size: 1.1rem;
            font-weight: 600;
        }

        .badge-status {
            padding: 10px 16px;
            border-radius: 12px;
            font-size: 0.85rem;
            font-weight: 700;
            letter-spacing: 0.5px;
        }

        .badge-status.aberto {
            background: #e7f3ff;
            color: #0066cc;
        }

        .badge-status.em_execucao {
            background: #fff3e0;
            color: #ff6b00;
        }

        .badge-status.concluido {
            background: #e8f5e9;
            color: #2e7d32;
        }

        .form-section {
            background: #f9fafb;
            border-radius: 18px;
            padding: 25px;
            margin-top: 20px;
        }

        .form-section h6 {
            color: #1a237e;
            font-weight: 700;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .btn-submit {
            background: linear-gradient(45deg, #1a237e, #283593);
            border: none;
            border-radius: 14px;
            padding: 12px 28px;
            color: white;
            font-weight: 700;
            transition: 0.3s;
            box-shadow: 0 10px 25px rgba(26,35,126,0.18);
        }

        .btn-submit:hover {
            transform: translateY(-3px);
            color: white;
        }

        .btn-submit:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }

        .btn-voltar {
            background: #e9ecef;
            border: none;
            border-radius: 14px;
            padding: 12px 28px;
            color: #1a237e;
            font-weight: 700;
            transition: 0.3s;
            text-decoration: none;
        }

        .btn-voltar:hover {
            background: #dee2e6;
            color: #1a237e;
        }

        .loading {
            display: none;
            text-align: center;
        }

        .spinner-border {
            width: 3rem;
            height: 3rem;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark navbar-custom shadow-sm">
        <div class="container">
            <span class="navbar-brand fw-bold">SGM | Gestor</span>
            <div class="ms-auto">
                <a href="gestor_chamados.php" class="btn btn-outline-light btn-sm rounded-3 me-2">
                    <i class="bi bi-arrow-left"></i> Voltar
                </a>
                <a href="api/logout.php" class="btn btn-outline-light btn-sm rounded-3">
                    <i class="bi bi-box-arrow-right"></i> Sair
                </a>
            </div>
        </div>
    </nav>

    <main class="container py-4">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <!-- HEADER -->
                <div class="page-header">
                    <h3 class="page-title">
                        <i class="bi bi-clipboard-check-fill"></i>
                        Detalhes do Chamado
                    </h3>
                </div>

                <!-- CARD COM DETALHES -->
                <div class="detail-card" id="detalhesCard">
                    <div class="loading">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Carregando...</span>
                        </div>
                        <p class="mt-3 text-muted">Carregando detalhes do chamado...</p>
                    </div>
                </div>

                <!-- SEÇÃO DE ATRIBUIÇÃO -->
                <div class="detail-card" id="secaoAtribuicao">
                    <form id="formAtribuir">
                        <h5 class="mb-4">
                            <i class="bi bi-person-badge-fill me-2"></i>
                            Atribuição de Técnico
                        </h5>

                        <div class="form-section">
                            <h6>
                                <i class="bi bi-person-fill"></i>
                                Técnico Responsável
                            </h6>
                            <select class="form-select" id="selectTecnico" required>
                                <option value="">Carregando técnicos...</option>
                            </select>
                        </div>

                        <div class="form-section">
                            <h6>
                                <i class="bi bi-exclamation-triangle-fill"></i>
                                Prioridade
                            </h6>
                            <select class="form-select" id="prioridade" required>
                                <option value="">Selecione...</option>
                                <option value="baixa">Baixa</option>
                                <option value="media">Média</option>
                                <option value="alta">Alta</option>
                            </select>
                        </div>

                        <div class="form-section">
                            <h6>
                                <i class="bi bi-calendar2-event"></i>
                                Data Prevista
                            </h6>
                            <input type="date" class="form-control" id="data_prevista" required>
                        </div>

                        <div class="mt-4 d-flex gap-2">
                            <button type="submit" class="btn btn-submit" id="btnConfirmar">
                                <i class="bi bi-check2-all me-2"></i>
                                Confirmar Atribuição
                            </button>
                            <a href="gestor_chamados.php" class="btn btn-voltar">
                                <i class="bi bi-x-lg me-2"></i>
                                Cancelar
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        const chamadoId = new URLSearchParams(window.location.search).get('id');

        // Carregador de detalhes
        async function carregarDetalhes() {
            try {
                const res = await fetch(`api/chamados.php?id=${chamadoId}`);
                if (!res.ok) throw new Error('Erro na resposta');

                const chamado = await res.json();

                const detalhesCard = document.getElementById('detalhesCard');
                
                const statusClass = {
                    'aberto': 'aberto',
                    'agendado': 'aberto',
                    'em_execucao': 'em_execucao',
                    'concluido': 'concluido',
                    'fechado': 'concluido',
                    'cancelado': 'aberto'
                }[chamado.status] || 'aberto';

                detalhesCard.innerHTML = `
                    <div class="detail-section">
                        <div class="detail-row">
                            <div class="detail-item">
                                <div class="detail-label">ID do Chamado</div>
                                <div class="detail-value">#${chamado.id_chamado}</div>
                            </div>
                            <div class="detail-item">
                                <div class="detail-label">Status</div>
                                <span class="badge badge-status ${statusClass}">
                                    ${chamado.status.replace('_', ' ').toUpperCase()}
                                </span>
                            </div>
                            <div class="detail-item">
                                <div class="detail-label">Data de Abertura</div>
                                <div class="detail-value">${new Date(chamado.data_abertura).toLocaleDateString('pt-BR')}</div>
                            </div>
                        </div>
                    </div>

                    <div class="detail-section">
                        <h6>Localização</h6>
                        <div class="detail-row">
                            <div class="detail-item">
                                <div class="detail-label">Bloco</div>
                                <div class="detail-value">${chamado.bloco_nome}</div>
                            </div>
                            <div class="detail-item">
                                <div class="detail-label">Ambiente</div>
                                <div class="detail-value">${chamado.ambiente_nome}</div>
                            </div>
                        </div>
                    </div>

                    <div class="detail-section">
                        <h6>Informações do Serviço</h6>
                        <div class="detail-row">
                            <div class="detail-item">
                                <div class="detail-label">Tipo de Serviço</div>
                                <div class="detail-value">${chamado.tipo_nome}</div>
                            </div>
                            <div class="detail-item">
                                <div class="detail-label">Solicitante</div>
                                <div class="detail-value">${chamado.solicitante_nome}</div>
                            </div>
                        </div>
                    </div>

                    <div class="detail-section">
                        <h6>Descrição do Problema</h6>
                        <p style="color: #555; line-height: 1.6;">${chamado.descricao_problema}</p>
                    </div>
                `;

                // Carregar técnicos
                await carregarTecnicos(chamado);

                // Preencher campos com dados atuais
                if(chamado.id_tecnico) document.getElementById('selectTecnico').value = chamado.id_tecnico;
                if(chamado.prioridade) document.getElementById('prioridade').value = chamado.prioridade;
                if(chamado.data_previsao_conclusao) document.getElementById('data_prevista').value = chamado.data_previsao_conclusao;

            } catch (error) {
                console.error('Erro ao carregar detalhes:', error);
                document.getElementById('detalhesCard').innerHTML = `
                    <div class="alert alert-danger">
                        <i class="bi bi-exclamation-triangle-fill"></i>
                        Erro ao carregar detalhes do chamado. Tente novamente.
                    </div>
                `;
            }
        }

        // Carregar técnicos
        async function carregarTecnicos(chamado) {
            try {
                const resTec = await fetch('api/api_usuarios.php');
                if (!resTec.ok) throw new Error("Erro ao buscar técnicos");
                
                const respostaTec = await resTec.json();
                const select = document.getElementById('selectTecnico');
                
                if (select && respostaTec.success) {
                    select.innerHTML = '<option value="">Selecione um técnico...</option>';
                    
                    // Filtra apenas os usuários que são do perfil 'tecnico'
                    const apenasTecnicos = respostaTec.data.filter(u => u.perfil === 'tecnico');
                    
                    apenasTecnicos.forEach(t => {
                        const option = document.createElement('option');
                        option.value = t.id_usuario;
                        option.textContent = t.nome;
                        select.appendChild(option);
                    });

                    if(chamado.id_tecnico) select.value = chamado.id_tecnico;
                } else if (!respostaTec.success) {
                    console.error("Erro da API de usuários:", respostaTec.message);
                }
            } catch (error) {
                console.error("Erro ao carregar técnicos:", error);
            }
        }

        // Enviar atribuição
        document.getElementById('formAtribuir').addEventListener('submit', async (e) => {
            e.preventDefault();

            const dados = {
                id_chamado: chamadoId,
                id_tecnico: document.getElementById('selectTecnico').value,
                prioridade: document.getElementById('prioridade').value,
                data_prevista: document.getElementById('data_prevista').value
            };

            const btnConfirmar = document.getElementById('btnConfirmar');
            btnConfirmar.disabled = true;
            btnConfirmar.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Processando...';

            try {
                const response = await fetch('api/atribuir_chamado.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(dados)
                });

                if (!response.ok) throw new Error('Erro na resposta do servidor');

                const resultado = await response.json();

                if (resultado.success) {
                    alert('✓ Chamado atribuído com sucesso!');
                    window.location.href = 'gestor_chamados.php'; 
                } else {
                    alert('❌ Erro: ' + resultado.message);
                    btnConfirmar.disabled = false;
                    btnConfirmar.innerHTML = '<i class="bi bi-check2-all me-2"></i>Confirmar Atribuição';
                }
            } catch (error) {
                console.error('Erro:', error);
                alert('❌ Erro ao atribuir chamado. Tente novamente.');
                btnConfirmar.disabled = false;
                btnConfirmar.innerHTML = '<i class="bi bi-check2-all me-2"></i>Confirmar Atribuição';
            }
        });

        // Carregar ao iniciar
        carregarDetalhes();
    </script>
</body>

</html>