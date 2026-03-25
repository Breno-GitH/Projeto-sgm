<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>SGM - Novo Tipo de Serviço</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-header text-white" style="background: #1a237e;">
                        <h5 class="mb-0">Novo Tipo de Serviço</h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Descrição do Serviço</label>
                            <input type="text" id="nome_tipo" class="form-control" placeholder="Ex: Manutenção Elétrica" required>
                        </div>
                        <button onclick="enviar()" class="btn btn-primary w-100 py-2">Salvar Tipo</button>
                        <a href="config_tipos_servico.php" class="btn btn-link w-100 mt-2 text-secondary text-decoration-none">Cancelar</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        async function enviar() {
            const nome = document.getElementById('nome_tipo').value;
            const res = await fetch('api/api_tipos_servico.php', {
                method: 'POST',
                headers: {'Content-Type': 'application/json'},
                body: JSON.stringify({ nome: nome })
            });
            const result = await res.json();
            alert(result.message);
            if(result.success) window.location.href = 'config_tipos_servico.php';
        }
    </script>
</body>
</html>