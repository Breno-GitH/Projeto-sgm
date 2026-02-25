<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel de Chamados</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">

<main class="container-fluid py-4">
    <div class="mb-4">
        <a href="gestor_chamados.php" class="btn btn-outline-secondary">Voltar</a>
    </div>

    <div class="row g-4">
        <section class="col-lg-4 col-md-5"> 
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <h5 class="card-title">Dados da Solicitação</h5>
                    <div id="detalhesChamado">
                        <p class="text-muted">Carregando dados do chamado...</p>
                    </div>
                </div>
                <div class="card-footer bg-white border-top-0" id="areaFechamento">
                    </div>
            </div>
        </section>

        <section class="col-lg-8 col-md-7">
            <div class="card shadow-sm h-100 ">
                <div class="card-header text-white px-4 py-3" style="background: linear-gradient(45deg, #1a237e, #283593); border-bottom: 2px solid #283593;">
    <h5 class="mb-0 d-flex align-items-center">
        <i class="bi bi-person-badge-fill me-2"></i> Atribuição de Técnico
    </h5>
</div>
                <div class="card-body">
                    <form id="formAtribuir"> <div class="mb-3">
                            <label for="selectTecnico" class="form-label">Técnico Responsável</label>
                            <select class="form-select" id="selectTecnico" required>
                                <option value="">Carregando técnicos...</option>
                            </select>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="prioridade" class="form-label">Prioridade</label>
                                <select class="form-select" id="prioridade" required>
                                    <option value="">Selecione...</option>
                                    <option value="baixa">Baixa</option>
                                    <option value="media">Média</option>
                                    <option value="alta">Alta</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="data_prevista" class="form-label">Data Prevista</label>
                                <input type="date" class="form-control" id="data_prevista" required>
                            </div>
                        </div>
                        <hr>
                        <button type="submit" class="btn btn-lg w-100 py-3 mt-3 text-white shadow border-0 rounded-3 d-flex align-items-center justify-content-center" 
        id="btnConfirmar" 
        style="background: linear-gradient(45deg, #1a237e, #283593); transition: transform 0.2s, background 0.3s;">
    <i class="bi bi-check-circle-fill me-2"></i> 
    <strong>Confirmar Atribuição</strong>
</button>
                    </form>
                </div>
            </div>
        </section>
    </div>
</main></main>

<script>
        
const urlParams = new URLSearchParams(window.location.search);
const chamadoId = urlParams.get('id');

async function carregarDados() {
    if (!chamadoId) {
        console.error("ID do chamado não encontrado na URL.");
        document.getElementById('detalhesChamado').innerHTML = '<p class="text-danger">Erro: ID do chamado não especificado na URL.</p>';
        return;
    }

    try {
       
        const resTec = await fetch('api/usuarios.php');
        if (!resTec.ok) throw new Error("Erro ao buscar técnicos");
        
        const tecnicos = await resTec.json();
        const select = document.getElementById('selectTecnico');
        
        if (select) {
            select.innerHTML = '<option value="">Selecione um técnico...</option>';
            tecnicos.forEach(t => {
                const option = document.createElement('option');
                option.value = t.id_usuario;
                option.textContent = t.nome;
                select.appendChild(option);
            });
        }

        
        const resChamado = await fetch(`api/chamados.php?id=${chamadoId}`);
        const c = await resChamado.json();

        if (c) {
            document.getElementById('detalhesChamado').innerHTML = `
                <p><strong>Status:</strong> <span class="badge bg-secondary">${c.status.toUpperCase()}</span></p>
                <p><strong>Descrição:</strong> ${c.descricao_problema || 'N/A'}</p>
                <p><strong>Local:</strong> ${c.bloco_nome} - ${c.ambiente_nome}</p>
                <p><strong>Solicitante:</strong> ${c.solicitante_nome}</p>
                <p><strong>Abertura:</strong> ${new Date(c.data_abertura).toLocaleString()}</p>
                <div id="fotosContainer"></div>
            `;

           
            if(c.id_tecnico) document.getElementById('selectTecnico').value = c.id_tecnico;
            if(c.prioridade) document.getElementById('prioridade').value = c.prioridade;
            if(c.data_previsao_conclusao) document.getElementById('data_prevista').value = c.data_previsao_conclusao;
        }

        

    } catch (error) {
        console.error("Erro na requisição:", error);
    }
    
document.getElementById('formAtribuir').addEventListener('submit', async (e) => {
    e.preventDefault(); 

    
    const dados = {
        id_chamado: chamadoId,
        id_tecnico: document.getElementById('selectTecnico').value,
        prioridade: document.getElementById('prioridade').value,
        data_prevista: document.getElementById('data_prevista').value
    };

    try {
       
        const response = await fetch('api/atribuir_chamado.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(dados)
        });

        const resultado = await response.json();

        if (resultado.success) {
            alert("Sucesso: Chamado atribuído!");
            
            window.location.href = 'gestor_chamados.php'; 
        } else {
            alert("Erro ao salvar: " + resultado.message);
        }
    } catch (error) {
        console.error("Erro na requisição:", error);
        alert("Ocorreu um erro técnico ao tentar salvar.");
    }
});
}
carregarDados();
</script>


<script src=https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js</script>
</body>
</html>