<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>SGM - Editar Bloco</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<main class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-header text-white" style="background: linear-gradient(45deg, #1a237e, #283593);">
                    <h5 class="mb-0">Editar Bloco</h5>
                </div>
                <div class="card-body p-4">
                    <form id="formEditar">
                        <input type="hidden" id="id_bloco">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Nome do Bloco</label>
                            <input type="text" id="nome" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Salvar Alterações</button>
                        <a href="config_blocos.php" class="btn btn-link w-100 mt-2 text-decoration-none text-secondary">Voltar</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
const urlParams = new URLSearchParams(window.location.search);
const idBloco = urlParams.get('id');

window.onload = async () => {
    const res = await fetch('api/api_blocos.php');
    const result = await res.json();
    const bloco = result.data.find(b => b.id_bloco == idBloco);
    if(bloco) {
        document.getElementById('id_bloco').value = bloco.id_bloco;
        document.getElementById('nome').value = bloco.nome;
    }
};

document.getElementById('formEditar').onsubmit = async (e) => {
    e.preventDefault();
    const res = await fetch('api/api_blocos.php', {
        method: 'PUT',
        headers: {'Content-Type': 'application/json'},
        body: JSON.stringify({
            id_bloco: idBloco,
            nome: document.getElementById('nome').value
        })
    });
    const result = await res.json();
    alert(result.message);
    if(result.success) window.location.href = 'config_blocos.php';
};
</script>
</body>
</html>