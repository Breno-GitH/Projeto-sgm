<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>SGM - Editar Usuário</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<main class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow border-0">
                <div class="card-header text-white p-3" style="background: #1a237e;">
                    <h5 class="mb-0">Editar Perfil do Usuário</h5>
                </div>
                <div class="card-body p-4 bg-white">
                    <form id="formUsuario">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Nome</label>
                            <input type="text" id="nome" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">E-mail</label>
                            <input type="email" id="email" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Perfil</label>
                            <select id="perfil" class="form-select">
                                <option value="solicitante">Solicitante</option>
                                <option value="tecnico">Técnico</option>
                                <option value="gestor">Gestor</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold text-danger">Nova Senha (deixe em branco para não alterar)</label>
                            <input type="password" id="senha" class="form-control">
                        </div>
                        <button type="submit" class="btn btn-success w-100 py-2 fw-bold">Salvar Alterações</button>
                        <a href="config_usuarios.php" class="btn btn-link w-100 mt-2 text-muted">Voltar</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
const idUser = new URLSearchParams(window.location.search).get('id');

window.onload = async () => {
    const res = await fetch('api/api_usuarios.php');
    const result = await res.json();
    const u = result.data.find(user => user.id_usuario == idUser);
    if(u) {
        document.getElementById('nome').value = u.nome;
        document.getElementById('email').value = u.email;
        document.getElementById('perfil').value = u.perfil;
    }
};

document.getElementById('formUsuario').onsubmit = async (e) => {
    e.preventDefault();
    const dados = {
        id_usuario: idUser,
        nome: document.getElementById('nome').value,
        email: document.getElementById('email').value,
        perfil: document.getElementById('perfil').value,
        senha: document.getElementById('senha').value // A API ignora se estiver vazio
    };

    const res = await fetch('api/api_usuarios.php', {
        method: 'PUT',
        headers: {'Content-Type': 'application/json'},
        body: JSON.stringify(dados)
    });
    const result = await res.json();
    alert(result.message);
    if(result.success) window.location.href = 'config_usuarios.php';
};
</script>
</body>
</html>