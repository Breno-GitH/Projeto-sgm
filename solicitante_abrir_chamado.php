<?php 
session_start();

if(!isset($_SESSION['user_id']) || $_SESSION['user_perfil'] !== 'solicitante'){
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
    <title>SGM - Nova Solicitação</title>
</head>

<body class="bg-light">
    <div class="container d-flex align-items-center" style="min-height: 100vh; padding: 20px 0;">
        <form action="api/salvar_chamados.php" method="POST" enctype="multipart/form-data" class="w-100 m-auto shadow-lg" id="formChamado" style="max-width: 600px;">
            <header class="text-white d-flex justify-content-between align-items-center rounded-top-4 px-4 py-3" style="background: linear-gradient(45deg, #1a237e, #283593);">
                <h2 class="mb-0 h4 d-flex align-items-center">
                    <i class="bi bi-plus-circle-fill me-2"></i> Abrir Chamado
                </h2>
                <a href="solicitante_dashboard.php" class="btn btn-sm btn-outline-light">Voltar</a>
            </header>
            
            <main class="p-4 border rounded-bottom bg-white">
                <div class="mb-3">
                    <label for="bloco" class="form-label fw-bold">Bloco</label>
                    <select id="bloco" name="id_bloco" class="form-select" required onchange="carregarAmbientes(this.value)">
                        <option value="">Carregando blocos...</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="sala" class="form-label fw-bold">Ambiente / Sala</label>
                    <select id="sala" name="id_ambiente" class="form-select" required disabled>
                        <option value="">Selecione o Bloco primeiro...</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="tipo" class="form-label fw-bold">Tipo de Serviço</label>
                    <select id="tipo" name="id_tipo" class="form-select" required>
                        <option value="">Selecione o tipo...</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="descricao" class="form-label fw-bold">Descrição do Problema</label>
                    <textarea id="descricao" name="descricao" class="form-control" rows="4" required placeholder="Ex: Lâmpada queimada ou vazamento na pia..."></textarea>
                </div>

                <div class="mb-4">
                    <label for="foto" class="form-label fw-bold">Foto da Ocorrência (Opcional)</label>
                    <input type="file" id="foto" name="foto" accept="image/*" class="form-control">
                </div>

               <button class="btn btn-lg w-100 py-3 mt-3 text-white shadow-sm border-0 rounded-3" type="submit" id="btnEnviar" style="background: linear-gradient(45deg, #1a237e, #283593); transition: 0.3s;">
                    <i class="bi bi-check2-all me-2"></i> Registrar Solicitação
                </button>   
            </main>
        </form>
    </div>

    <script>
        function preencherSelect(idElemento, dados, campoId, campoNome, textoPadrao) {
            const select = document.getElementById(idElemento);
            let html = `<option value="">${textoPadrao}</option>`;
            
            if (Array.isArray(dados)) {
                dados.forEach(item => {
                    html += `<option value="${item[campoId]}">${item[campoNome]}</option>`;
                });
            }
            select.innerHTML = html;
        }

        async function iniciar() {
            try {
                const resB = await fetch('api/localizacoes.php?acao=listar_blocos');
                const blocos = await resB.json();
                preencherSelect('bloco', blocos, 'id_bloco', 'nome', 'Selecione o Bloco..');

                const resT = await fetch('api/localizacoes.php?acao=listar_tipos');
                const tipos = await resT.json();
                preencherSelect('tipo', tipos, 'id_tipo', 'nome', 'Selecione o tipo...');
            } catch (erro) {
                console.error("Erro ao carregar dados iniciais:", erro);
                document.getElementById('bloco').innerHTML = '<option value="">Erro ao carregar</option>';
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

        document.getElementById('formChamado').addEventListener('submit', async (e) => {
            e.preventDefault();
            
            const btn = document.getElementById('btnEnviar');
            const originalText = btn.innerText;
            
            btn.disabled = true;
            btn.innerText = "Enviando...";

            try {
                
                const formData = new FormData(e.target);

                const response = await fetch('api/salvar_chamados.php', {
                    method: 'POST',
                    body: formData
                });

                if (!response.ok) {
                    throw new Error("Erro na resposta do servidor.");
                }

                const result = await response.json();

                if (result.success) {
                    alert(result.message || "Solicitação enviada!");
                    window.location.href = 'solicitante_dashboard.php';
                } else {
                    alert("Atenção: " + result.message);
                    btn.disabled = false;
                    btn.innerText = originalText;
                }
            } catch (erro) {
                console.error("Erro no envio:", erro);
                alert("Falha ao registrar chamado. Verifique sua conexão ou tente novamente.");
                btn.disabled = false;
                btn.innerText = originalText;
            }
        });

        iniciar();
    </script>
</body>
</html>