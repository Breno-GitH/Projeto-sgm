<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SGM - Editar Ambiente</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body class="bg-light">

<main class="container py-5">
    <div class="mb-4">
        <a href="config_ambientes.php" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Voltar
        </a>
    </div>   
       
    <section class="row justify-content-center">
        <div class="col-lg-6 col-md-8">
            <div class="card shadow-sm">
                <div class="card-header text-white px-4 py-3" style="background: linear-gradient(45deg, #1a237e, #283593);">
                    <h5 class="mb-0 d-flex align-items-center">
                        <i class="bi bi-pencil-square me-2"></i> Editar Ambiente
                    </h5>
                </div>
                <div class="card-body p-4">
                    <form id="formEditarAmbiente">
                        <input type="hidden" id="id_ambiente">

                        <div class="mb-3">
                            <label for="novoNome" class="form-label fw-bold">Nome do Ambiente</label>
                            <input type="text" id="novoNome" class="form-control" placeholder="Carregando..." required>
                        </div>

                        <div class="mb-3">
                            <label for="selectBloco" class="form-label fw-bold">Bloco</label>
                            <select class="form-select" id="selectBloco" required>
                                <option value="">Carregando blocos...</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-lg w-100 py-3 mt-3 text-white shadow-sm border-0 rounded-3" 
                                id="btnConfirmar" style="background: linear-gradient(45deg, #1a237e, #283593);">
                            <i class="bi bi-check-circle-fill me-2"></i> Salvar Alterações
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>
</main>

<script>
// 1. Pega o ID que veio na URL (?id=...)
const urlParams = new URLSearchParams(window.location.search);
const idDoAmbiente = urlParams.get('id');

window.onload = async function() {
    if (!idDoAmbiente) {
        alert("ID não encontrado na URL!");
        window.location.href = 'config_ambientes.php';
        return;
    }
    await carregarDados();
};

async function carregarDados() {
    try {
        // Primeiro: Carrega os Blocos para o Select
        const resB = await fetch('api/api_ambientes.php?metodo=LISTAR_BLOCOS');
        const dataB = await resB.json();
        const selectB = document.getElementById('selectBloco');
        
        selectB.innerHTML = '<option value="">Selecione o Bloco...</option>';
        dataB.data.forEach(b => {
            selectB.innerHTML += `<option value="${b.id_bloco}">${b.nome}</option>`;
        });

        // Segundo: Busca os dados do ambiente específico
        const resA = await fetch('api/api_ambientes.php');
        const dataA = await resA.json();
        
        // Procura na lista o ambiente que tem o ID igual ao da URL
        const ambiente = dataA.data.find(a => a.id_ambiente == idDoAmbiente);

        if (ambiente) {
            document.getElementById('id_ambiente').value = ambiente.id_ambiente;
            document.getElementById('novoNome').value = ambiente.nome;
            document.getElementById('selectBloco').value = ambiente.id_bloco;
        } else {
            alert("Ambiente não encontrado!");
        }

    } catch (e) {
        console.error("Erro ao carregar:", e);
        alert("Erro ao conectar com o servidor.");
    }
}

// Terceiro: Envia a atualização (PUT)
document.getElementById('formEditarAmbiente').onsubmit = async function(e) {
    e.preventDefault();
    
    const dados = {
        id_ambiente: idDoAmbiente,
        nome: document.getElementById('novoNome').value,
        id_bloco: document.getElementById('selectBloco').value
    };

    try {
        const res = await fetch('api/api_ambientes.php', {
            method: 'PUT',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(dados)
        });

        const result = await res.json();
        
        if (result.success) {
            alert("Ambiente atualizado com sucesso!");
            window.location.href = 'config_ambientes.php';
        } else {
            alert("Erro: " + result.message);
        }
        
    } catch (error) {
        alert("Erro na requisição.");
    }
};
</script>
</body>
</html>