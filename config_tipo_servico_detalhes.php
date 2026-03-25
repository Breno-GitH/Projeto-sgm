<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>SGM - Editar Tipo de Serviço</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<main class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-header text-white" style="background: #1a237e;">
                    <h5 class="mb-0">Editar Tipo de Serviço</h5>
                </div>
                <div class="card-body p-4">
                    <form id="formEditar">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Descrição</label>
                            <input type="text" id="nome" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Atualizar</button>
                        <a href="config_tipos_servico.php" class="btn btn-link w-100 mt-2 text-decoration-none">Cancelar</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
const idTipo = new URLSearchParams(window.location.search).get('id');

window.onload = async () => {
    const res = await fetch('api/api_tipos_servico.php');
    const result = await res.json();
    const tipo = result.data.find(t => t.id_tipo == idTipo);
    if(tipo) document.getElementById('nome').value = tipo.nome;
};

document.getElementById('formEditar').onsubmit = async (e) => {
    e.preventDefault();
    const res = await fetch('api/api_tipos_servico.php', {
        method: 'PUT',
        headers: {'Content-Type': 'application/json'},
        body: JSON.stringify({ id_tipo: idTipo, nome: document.getElementById('nome').value })
    });
    const result = await res.json();
    alert(result.message);
    if(result.success) window.location.href = 'config_tipos_servico.php';
};
</script>
</body>
</html>