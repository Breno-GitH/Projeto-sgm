    <!DOCTYPE html>
    <html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>SGM | Gestor</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        
        <style>
            body {
                background-color: #f4f7f6;
                font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
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
            .content-area {
                margin-top: 50px;
            }

            /* Card básico para a mensagem */
            .status-card {
                background: white;
                border-radius: 8px;
                border: 1px solid #e0e0e0;
                padding: 3rem;
                text-align: center;
            }

            .text-info-vazio {
                color: #6c757d;
                font-size: 1.1rem;
                margin-bottom: 0;
            }
        </style>
    </head>
    <body>

    <header>
        <nav class="navbar mb-4 shadow-sm" data-bs-theme="dark" style="background-color: #1a237e; border-bottom: 1px solid #283593;">
            <div class="container">
                <span class="navbar-brand">SGM | Técnico | João</span>
                <div class="ms-auto">
            <a href="api/logout.php" class="btn btn-outline-light btn-sm">Sair</a>
                </div>
            </div>
        </nav>
    </header>
<main class="container content-area">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <h3 class="mb-4 text-dark" style="font-weight: 500;">Minha Fila de Trabalho</h3>
            
            <div id="containerTarefas" class="status-card">
                <p class="text-info-vazio">Carregando tarefas...</p>
            </div>
        </div>
    </div>
</main>

<script>
async function carregarTarefas() {
    try {
        const res = await fetch('api/tecnico_chamados.php');
        const tarefas = await res.json();
        const container = document.getElementById('containerTarefas');

        // Se não houver tarefas, mantém o seu estilo original
        if (!tarefas || tarefas.length === 0) {
            container.innerHTML = `<p class="text-info-vazio">Nenhuma Tarefa Pendente</p>`;
            return;
        }

        // Se houver tarefas, limpa o padding excessivo do status-card para caber a lista
        container.style.padding = "1rem";
        
        // Mapeamento de cores baseado na urgência
        const cores = {
            'alta': '#ffcccc',   // Vermelho claro
            'media': '#fff3cd',  // Amarelo claro
            'baixa': '#d1ecf1'   // Azul claro
        };
        const bordas = {
            'alta': '#dc3545',
            'media': '#ffc107',
            'baixa': '#0dcaf0'
        };

        container.innerHTML = tarefas.map(t => `
            <div class="d-flex align-items-center justify-content-between p-3 mb-2 rounded-3 shadow-sm" 
                 style="background-color: ${cores[t.prioridade] || '#fff'}; 
                        border-left: 8px solid ${bordas[t.prioridade] || '#ccc'};
                        text-align: left;">
                <div style="flex-grow: 1;">
                    <div class="d-flex justify-content-between">
                        <span class="badge bg-dark mb-1">#${t.id_chamado}</span>
                        <small class="text-muted">${new Date(t.data_abertura).toLocaleDateString()}</small>
                    </div>
                    <h6 class="mb-1" style="color: #333;"><strong>${t.ambiente}</strong> - ${t.bloco}</h6>
                    <p class="mb-0 small text-truncate" style="max-width: 400px; color: #555;">${t.descricao_problema}</p>
                </div>
                <div class="ms-3">
                    <a href="tecnico_detalhes.php?id=${t.id_chamado}" class="btn btn-dark btn-sm shadow-sm">
                        Abrir
                    </a>
                </div>
            </div>
        `).join('');

    } catch (error) {
        console.error("Erro ao carregar tarefas:", error);
        document.getElementById('containerTarefas').innerHTML = '<p class="text-danger">Erro de conexão.</p>';
    }
}

carregarTarefas();
</script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    </body>
    </html>