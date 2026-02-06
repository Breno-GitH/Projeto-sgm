<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css">
</head>
<body>
    <header>
        <nav class="navbar bg-dark border-bottom border-body" data-bs-theme="dark"><div class="container">
    <div class="container-fluid d-flex justify-content-between">
      <a class="navbar-brand" href="#">SGM - Painel do Solicitante</a>
      <a class="navbar-brand" href="#">Olá, Maria Solicitante</a>
     <a href="api/logout.php"<button type="button"class="btn btn-outline-light" >Sair</button></a>
    </div>
  </nav>
</div></header>
<main>
   <div class="d-flex justify-content-between">
        <h1>Minhas Solicitações</h1> 
      <button type="button" class="btn btn-success">+ Nova Solicitação</button>
   </div>

   <table class="table">
  <thead>
    <tr>
      <th scope="col">ID</th>
      <th scope="col">Foto</th>
      <th scope="col">Local</th>
      <th scope="col">Descrição</th>
      <th scope="col">Data</th>
      <th scope="col">Status</th>
    </tr>
  </thead>
  <tbody class="table-group-divider">
    <tr>
      <th scope="row">1</th>
      <td>#</td>
      <td>Recepção</td>
      <td>Quebrado...</td>
      <td>28/09/2026</td>
      <td><span class="badge text-bg-primary">Fechado</span></td>
    </tr>
  </tbody>
</table>
</main>
<script src=https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js</script>
</body>
</html>