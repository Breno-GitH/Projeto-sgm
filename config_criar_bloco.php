<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>SGM - Novo Bloco</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-header text-white" style="background: #1a237e;">
                        <h5 class="mb-0">Cadastrar Novo Bloco</h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Nome do Bloco</label>
                            <input type="text" id="nome_bloco" class="form-control" placeholder="Ex: Bloco A" required>
                        </div>
                        <button onclick="enviar()" class="btn btn-primary w-100 py-2">Registrar Bloco</button>
                        <a href="config_blocos.php" class="btn btn-link w-100 mt-2 text-secondary text-decoration-none">Voltar</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        async function enviar() {
            const nome = document.getElementById('nome_bloco').value;
            if(!nome) return alert("Preencha o nome!");

            const res = await fetch('api/api_blocos.php', {
                method: 'POST',
                headers: {'Content-Type': 'application/json'},
                body: JSON.stringify({ nome: nome })
            });
            const result = await res.json();
            alert(result.message);
            if(result.success) window.location.href = 'config_blocos.php';
        }
    </script>
</body>
</html>