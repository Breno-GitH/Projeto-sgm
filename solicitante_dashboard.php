<?php 
session_start();
require_once 'config/database.php'; 

if(!isset($_SESSION['user_id']) || $_SESSION['user_perfil'] !== 'solicitante'){
    header("Location: login.php");
    exit;
}

$id_usuario = $_SESSION['user_id'];

// SQL MELHORADO: Busca o chamado e tenta trazer o caminho da foto se ele existir (LEFT JOIN)
$sql = "SELECT c.id_chamado, c.descricao_problema, c.status, c.data_abertura, a.nome as nome_ambiente, ca.caminho_arquivo
        FROM chamados c
        JOIN ambientes a ON c.id_ambiente = a.id_ambiente
        LEFT JOIN chamados_anexos ca ON c.id_chamado = ca.id_chamado
        WHERE c.id_solicitante = $id_usuario
        ORDER BY c.id_chamado DESC";

$resultado = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SGM - Painel</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body>
    <header>
       <nav class="navbar mb-4 shadow-sm" data-bs-theme="dark" style="background-color: #1a237e; border-bottom: 1px solid #283593;">
            <div class="container">
                <a class="navbar-brand" href="#">SGM - Painel do Solicitante</a>
                <div class="d-flex align-items-center gap-3">
                    <span class="text-white">Olá, <?php echo $_SESSION['user_nome'] ?? 'Usuário'; ?></span>
                    <a href="api/logout.php" class="btn btn-outline-light btn-sm">Sair</a>
                </div>
            </div>
        </nav>
    </header>

    <main class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Minhas Solicitações</h1> 
            <a href="solicitante_abrir_chamado.php" class="btn btn-success">+ Nova Solicitação</a>
        </div>

        <div class="table-responsive shadow-sm">
            <table class="table table-hover border">
                <thead class="table-light">
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
                    <?php if ($resultado && $resultado->num_rows > 0): ?>
                        <?php while($row = $resultado->fetch_assoc()): ?>
                            <tr>
                                <th scope="row">#<?php echo $row['id_chamado']; ?></th>
                                <td>
                                    <?php if(!empty($row['caminho_arquivo'])): ?>
                                        <img src="<?php echo $row['caminho_arquivo']; ?>" alt="Foto" style="width: 50px; height: 50px; object-fit: cover;" class="rounded border">
                                    <?php else: ?>
                                        <span class="text-muted small">Sem foto</span>
                                    <?php endif; ?>
                                </td>
                                <td><?php echo $row['nome_ambiente']; ?></td>
                                <td title="<?php echo $row['descricao_problema']; ?>">
                                    <?php echo mb_strimwidth($row['descricao_problema'], 0, 40, "..."); ?>
                                </td>
                                <td><?php echo date('d/m/Y', strtotime($row['data_abertura'])); ?></td>
                                <td>
                                    <?php 
                                        $status = strtolower($row['status']);
                                        $badge_class = ($status == 'aberto') ? 'text-bg-warning' : 'text-bg-success';
                                    ?>
                                    <span class="badge <?php echo $badge_class; ?>">
                                        <?php echo ucfirst($status); ?>
                                    </span>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">Você ainda não possui solicitações registradas.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>