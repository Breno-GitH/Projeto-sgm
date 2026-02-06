<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel de Chamados</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">

<main class="container-fluid py-4"> <div class="mb-4">
        <button type="button" class="btn btn-outline-secondary">Voltar</button>
    </div>

    <div class="row g-4">
        
        <section class="col-lg-4 col-md-5"> 
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <h5 class="card-title">Dados da Solicitante</h5>
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item"><strong>Status:</strong> <span class="badge text-bg-primary">Fechado</span></li>
                    <li class="list-group-item"><strong>Descrição:</strong> Quebrado...</li>
                    <li class="list-group-item"><strong>Local:</strong> Recepção</li>
                    <li class="list-group-item"><strong>Solicitante:</strong> Luiz Solicitante</li>
                    <li class="list-group-item"><strong>Abertura:</strong> 08/09/2026</li>
                    <li class="list-group-item"><strong>Evidências:</strong></li>
                </ul>
                <div class="card-body">
                    <div class="row g-2">
                        <div class="col-6"><img src="# class="img-fluid rounded" alt="evidencia 1"></div>
                        <div class="col-6"><img src="#" class="img-fluid rounded" alt="evidencia 2"></div>
                    </div>
                </div>
                <div class="card-footer bg-white border-top-0">
                    <button type="button" class="btn btn-warning w-100">Reabrir chamado</button>
                </div>
            </div>
        </section>

        <section class="col-lg-8 col-md-7">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Atribuição de Técnico</h5>
                </div>
                <div class="card-body">
                    <form>
                        <div class="mb-3">
                            <label for="tecnico" class="form-label">Técnico Responsável</label>
                            <input type="text" class="form-control" id="tecnico" placeholder="Nome do técnico">
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="prioridade" class="form-label">Prioridade</label>
                                <select class="form-select" id="prioridade">
                                    <option selected>Selecione...</option>
                                    <option value="1">Baixa</option>
                                    <option value="2">Média</option>
                                    <option value="3">Alta</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="data" class="form-label">Data Prevista</label>
                                <input type="date" class="form-control" id="data">
                            </div>
                        </div>
                        <hr>
                        <button type="submit" class="btn btn-primary btn-lg">Confirmar Atribuição</button>
                    </form>
                </div>
            </div>
        </section>

    </div> </main>

<script src=https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js</script>
</body>
</html>