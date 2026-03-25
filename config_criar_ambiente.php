<?php 
session_start();
if(!isset($_SESSION['user_id']) || $_SESSION['user_perfil'] !== 'gestor'){
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/视觉/icons/bootstrap-icons.css">
    <title>SGM - Novo Ambiente</title>
</head>
<body class="bg-light">
    <div class="container d-flex align-items-center" style="min-height: 100vh; padding: 20px 0;">
        <div class="w-100 m-auto shadow-lg" style="max-width: 600px;">
            <header class="text-white d-flex justify-content-between align-items-center rounded-top-4 px-4 py-3" style="background: linear-gradient(45deg, #1a237e, #283593);">
                <h2 class="mb-0 h4 d-flex align-items-center">Criar Ambiente</h2>
                <a href="config_ambientes.php" class="btn btn-sm btn-outline-light">Voltar</a>
            </header>

            <main class="p-4 border rounded-bottom bg-white">
                <div class="mb-3">
                    <label for="nome_ambiente" class="form-label fw-bold">Nome do Ambiente</label>
                    <input type="text" id="nome_ambiente" class="form-control" placeholder="Ex: Laboratório 01" required>
                    
                    <label for="id_bloco" class="form-label fw-bold mt-3">Bloco Pertencente</label>
                    <select id="id_bloco" class="form-select" required>
                        <option value="">Carregando blocos...</option>
                    </select>
                </div>

                <button class="btn btn-lg w-100 py-3 mt-3 text-white shadow-sm border-0 rounded-3" 
                        type="button" onclick="enviarAmbiente()" id="btnEnviar" 
                        style="background: linear-gradient(45deg, #1a237e, #283593);">
                    Registrar Ambiente
                </button> 
            </main>
        </div>
    </div>

    <script>
        // Carrega os blocos assim que a página abre
        window.onload = async function() {
            const selectBloco = document.getElementById('id_bloco');
            try {
                // Rota que busca os blocos existentes no banco
                const res = await fetch('api/api_ambientes.php?metodo=LISTAR_BLOCOS'); 
                const response = await res.json();

                if(response.success) {
                    selectBloco.innerHTML = '<option value="">Selecione o Bloco...</option>';
                    response.data.forEach(bloco => {
                        selectBloco.innerHTML += `<option value="${bloco.id_bloco}">${bloco.nome}</option>`;
                    });
                }
            } catch (error) {
                selectBloco.innerHTML = '<option value="">Erro ao carregar blocos</option>';
            }
        };

        async function enviarAmbiente() {
            const nome = document.getElementById('nome_ambiente').value;
            const id_bloco = document.getElementById('id_bloco').value;

            if (!nome || !id_bloco) {
                alert("Preencha todos os campos!");
                return;
            }

            try {
                const res = await fetch('api/api_ambientes.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ nome: nome, id_bloco: id_bloco })
                });
                
                const result = await res.json();
                if (result.success) {
                    alert(result.message);
                    window.location.href = 'config_ambientes.php';
                } else {
                    alert('Erro: ' + result.message);
                }
            } catch (error) {
                alert('Erro na comunicação.');
            }
        }
    </script>
</body>
</html>