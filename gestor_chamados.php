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
      <a class="navbar-brand" href="#">SGM - Admin</a>
      <a class="navbar-brand"class="d-flex justify-content-between" href="#">Chamados</a>
       <a class="navbar-brand" href="#">Locais</a>
     <a href="api/logout.php"<button type="button"class="btn btn-outline-light" >Sair</button></a>
    </div>
  </nav>
</div></header>
<main>
        <h1>Todos os Chamados</h1> 
        <button type="button" class="btn btn-outline-secondary">Todos</button>
        <button type="button" class="btn btn-outline-primary">Aberto</button>
        <button type="button" class="btn btn-outline-warning">Em execução</button>
        <button type="button" class="btn btn-outline-success">Concluidos</button>
   </div>

   <table class="table">
  <thead>
    <tr>
      <th scope="col">ID</th>
      <th scope="col">Solicitante</th>
      <th scope="col">Local/Tipo</th>
      <th scope="col">Prioridade</th>
      <th scope="col">Tecnico</th>
      <th scope="col">Status</th>
      <th scope="col">Ações</th>
    </tr>
  </thead>
  <tbody class="table-group-divider">
    <tr>
      <th scope="row">1</th>
      <td>Luiz Solicitante</td>
      <td>Recepção</td>
      <td <i class="bi bi-arrow-up-circle"></i>
      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-up-circle" viewBox="0 0 16 16">
  <path fill-rule="evenodd" d="M1 8a7 7 0 1 0 14 0A7 7 0 0 0 1 8m15 0A8 8 0 1 1 0 8a8 8 0 0 1 16 0m-7.5 3.5a.5.5 0 0 1-1 0V5.707L5.354 7.854a.5.5 0 1 1-.708-.708l3-3a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708L8.5 5.707z"/>
</svg>
      ALTA</td>
      <td>Nicolas Técnico</td>
      <td><span class="badge text-bg-primary">Fechado</span></td>
      <td><span class="badge text-bg-primary"
      <i class="bi bi-pencil-fill"></i>
      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-fill" viewBox="0 0 16 16">
  <path d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.5.5 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11z"/>
</svg>
      Gerenciar</span></td>
    </tr>
  </tbody>
</table>
</main>
<script src=https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js</script>
</body>
</html>