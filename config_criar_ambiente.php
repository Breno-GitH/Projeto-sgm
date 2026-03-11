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
    <title>SGM - Novo Ambiente</title>
</head>

<body class="bg-light">
    <div class="container d-flex align-items-center" style="min-height: 100vh; padding: 20px 0;">
        <form action="api/salvar_mudancas.php" method="POST" enctype="multipart/form-data" class="w-100 m-auto shadow-lg" id="formChamado" style="max-width: 600px;">
            <header class="text-white d-flex justify-content-between align-items-center rounded-top-4 px-4 py-3" style="background: linear-gradient(45deg, #1a237e, #283593);">
                <h2 class="mb-0 h4 d-flex align-items-center">
                    <i class="bi bi-plus-circle-fill me-2"></i> Criar Ambiente
                </h2>
                 <a href="config_ambientes.php" class="btn btn-sm btn-outline-light">Voltar</a>
</header>

            <main class="p-4 border rounded-bottom bg-white">
    <div class="mb-3">
        <label for="nome_ambiente" class="form-label fw-bold">Nome do Ambiente</label>
        <input type="text" id="nome_ambiente" class="form-control" placeholder="Ex: Laboratório 01" required>
        
        <label for="id_bloco" class="form-label fw-bold mt-3">ID do Bloco</label>
       <select id="sala" name="id_ambiente" class="form-select" required disabled>
                        <option value="">Selecione o Bloco </option>
        </select>
    </div>

    <button class="btn btn-lg w-100 py-3 mt-3 text-white shadow-sm border-0 rounded-3" 
            type="button" onclick="enviarAmbiente()" id="btnEnviar" 
            style="background: linear-gradient(45deg, #1a237e, #283593);">
        <i class="bi bi-check2-all me-2"></i> Registrar Ambiente
    </button>   
</main>
            </main>
        </form>
    </div>
    <script>
                const blocos = await resB.json();
                preencherSelect('bloco', blocos, 'id_bloco', 'nome', 'Selecione o Bloco..');
            
        
        async function criarAmbiente(id) {
        if (confirm('Tem certeza que deseja criar este ambiente?')) {
            try {
                const response = await fetch('api/api_ambientes.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ id_ambiente: id })
                });
                
                const result = await response.json();
                
                if (result.success) {
                    alert(result.message);
                    carregarAmbientes();
                } else {
                    alert('Erro: ' + result.message);
                }
            } catch (error) {
                alert('Erro na comunicação com o servidor.');
            }
        }
    }
    async function carregarAmbientes(id_bloco) {
            const selA = document.getElementById('sala');
            
            if (!id_bloco) {
                selA.innerHTML = '<option value="">Selecione o Bloco primeiro...</option>';
                selA.disabled = true;
                return;
            }

            try {
                selA.disabled = true;
                selA.innerHTML = '<option value="">Carregando...</option>';
                
                const res = await fetch(`api/localizacoes.php?acao=listar_ambientes&id_bloco=${id_bloco}`);
                const ambientes = await res.json();
                
                preencherSelect('sala', ambientes, 'id_ambiente', 'nome', 'Selecione a Sala...');
                selA.disabled = false;
            } catch (erro) {
                console.error("Erro ao carregar ambientes:", erro);
                selA.innerHTML = '<option value="">Erro ao carregar</option>';
            }
        }
    </script>
</body>
</html>