<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css">
</head>
<body>
     <header>
       <nav class="navbar mb-4 shadow-sm" data-bs-theme="dark" style="background-color: #1a237e; border-bottom: 1px solid #283593;">
            <div class="container">
                <a class="navbar-brand" href="#">SGM - Gerenciamento de blocos</a>
                <div class="d-flex align-items-center gap-3">
                    <span class="text-white">Olá, <?php echo $_SESSION['user_nome'] ?? 'Usuário'; ?></span>
                    <a href="api/logout.php" class="btn btn-outline-light btn-sm">Sair</a>
                </div>
            </div>
        </nav>
    </header>
<main>
 <main class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Blocos</h1> 
            <a href="config_criar_bloco.php" class="btn btn-success">+ Novo Bloco</a>
        </div>

        <div class="table-responsive shadow-sm">
            <table class="table table-hover border">
                <thead class="table-light">
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Nome blocos</th>
                        <th scope="col">Editar</th>
                        <th scope="col">Deletar</th>
                          </tr>
                </thead>
     <tr>
      <th scope="row">1</th>
      <td>Bloco Administrativo</td>
      <td><a href="config_blocos_detalhes.php"><button type="button" class="btn btn-primary">Gerenciar</button></a></td>
    <td><button type="button" class="btn btn-danger">Deletar</button></td>
    </tr>
    </main>