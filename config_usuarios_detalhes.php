<!DOCTYPE html>
<html lang="pt-br">

<head>

    <meta charset="UTF-8">

    <title>
        SGM - Editar Usuário
    </title>

    <meta name="viewport"
    content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
    rel="stylesheet">

    <link rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>

        body{
            background: #f5f7fb;
            overflow-x: hidden;
            position: relative;
            font-family: "Segoe UI", sans-serif;
        }

        body::before{

            content: "";

            position: fixed;

            inset: 0;

            background:

            radial-gradient(
                circle at 20% 20%,
                rgba(26,35,126,0.04) 0%,
                transparent 25%
            ),

            radial-gradient(
                circle at 80% 70%,
                rgba(40,53,147,0.04) 0%,
                transparent 25%
            ),

            linear-gradient(
                rgba(26,35,126,0.025) 1px,
                transparent 1px
            ),

            linear-gradient(
                90deg,
                rgba(26,35,126,0.025) 1px,
                transparent 1px
            );

            background-size:
                auto,
                auto,
                40px 40px,
                40px 40px;

            z-index: -1;
        }

        .edit-card{

            background: rgba(255,255,255,0.92);

            backdrop-filter: blur(10px);

            border-radius: 30px;

            overflow: hidden;

            border: 1px solid rgba(26,35,126,0.08);

            box-shadow: 0 20px 45px rgba(0,0,0,0.06);

        }

        .card-header-custom{

            background: linear-gradient(
                45deg,
                #1a237e,
                #283593
            );

            padding: 30px 35px;

            position: relative;

            overflow: hidden;

        }

        .card-header-custom::before{

            content: "";

            position: absolute;

            width: 240px;
            height: 240px;

            border-radius: 50%;

            background: rgba(255,255,255,0.08);

            top: -130px;
            right: -80px;

        }

        .card-title{

            position: relative;

            z-index: 2;

            color: white;

            font-weight: 800;

            display: flex;

            align-items: center;

            gap: 14px;

            margin: 0;

        }

        .card-title i{

            color: #80d8ff;

            font-size: 1.8rem;

        }

        .card-body{

            padding: 40px;

        }

        .form-label{

            color: #1a237e;

            font-weight: 700;

            margin-bottom: 10px;

        }

        .form-control,
        .form-select{

            border-radius: 16px;

            padding: 14px 18px;

            border: 1px solid rgba(26,35,126,0.10);

            background: rgba(255,255,255,0.85);

            transition: 0.3s;

        }

        .form-control:focus,
        .form-select:focus{

            border-color: #1a237e;

            box-shadow: 0 0 0 0.2rem rgba(26,35,126,0.12);

        }

        .password-label{

            color: #dc3545;

        }

        .btn-save{

            border: none;

            border-radius: 18px;

            padding: 16px;

            font-weight: 700;

            font-size: 1rem;

            background: linear-gradient(
                45deg,
                #1a237e,
                #283593
            );

            color: white;

            transition: 0.3s;

            box-shadow: 0 12px 30px rgba(26,35,126,0.20);

        }

        .btn-save:hover{

            transform: translateY(-4px);

            color: white;

            box-shadow: 0 16px 35px rgba(26,35,126,0.28);

        }

        .btn-back{

            display: inline-flex;

            align-items: center;

            justify-content: center;

            gap: 8px;

            margin-top: 18px;

            color: #64748b;

            font-weight: 600;

            text-decoration: none;

            transition: 0.3s;

        }

        .btn-back:hover{

            color: #1a237e;

            transform: translateX(-3px);

        }

    </style>

</head>

<body class="bg-light">

<main class="container py-5">

    <div class="row justify-content-center">

        <div class="col-md-6">

            <div class="edit-card">

                <div class="card-header-custom">

                    <h5 class="card-title">

                        <i class="bi bi-person-gear"></i>

                        Editar Perfil do Usuário

                    </h5>

                </div>

                <div class="card-body">

                    <form id="formUsuario">

                        <div class="mb-4">

                            <label class="form-label">

                                Nome

                            </label>

                            <input type="text"
                            id="nome"
                            class="form-control"
                            required>

                        </div>

                        <div class="mb-4">

                            <label class="form-label">

                                E-mail

                            </label>

                            <input type="email"
                            id="email"
                            class="form-control"
                            required>

                        </div>

                        <div class="mb-4">

                            <label class="form-label">

                                Perfil

                            </label>

                            <select id="perfil"
                            class="form-select">

                                <option value="solicitante">
                                    Solicitante
                                </option>

                                <option value="tecnico">
                                    Técnico
                                </option>

                                <option value="gestor">
                                    Gestor
                                </option>

                            </select>

                        </div>

                        <div class="mb-4">

                            <label class="form-label password-label">

                                Nova Senha
                                (deixe em branco para não alterar)

                            </label>

                            <input type="password"
                            id="senha"
                            class="form-control">

                        </div>

                        <button type="submit"
                        class="btn btn-save w-100">

                            <i class="bi bi-check-circle-fill me-2"></i>

                            Salvar Alterações

                        </button>

                        <a href="config_usuarios.php"
                        class="btn-back w-100">

                            <i class="bi bi-arrow-left"></i>

                            Voltar

                        </a>

                    </form>

                </div>

            </div>

        </div>

    </div>

</main>

<script>

const idUser = new URLSearchParams(
    window.location.search
).get('id');

window.onload = async () => {

    const res = await fetch(
        'api/api_usuarios.php'
    );

    const result = await res.json();

    const u = result.data.find(
        user => user.id_usuario == idUser
    );

    if(u) {

        document.getElementById(
            'nome'
        ).value = u.nome;

        document.getElementById(
            'email'
        ).value = u.email;

        document.getElementById(
            'perfil'
        ).value = u.perfil;

    }

};

document.getElementById(
    'formUsuario'
).onsubmit = async (e) => {

    e.preventDefault();

    const dados = {

        id_usuario: idUser,

        nome: document.getElementById(
            'nome'
        ).value,

        email: document.getElementById(
            'email'
        ).value,

        perfil: document.getElementById(
            'perfil'
        ).value,

        senha: document.getElementById(
            'senha'
        ).value

    };

    const res = await fetch(
        'api/api_usuarios.php',
        {

            method: 'PUT',

            headers: {
                'Content-Type': 'application/json'
            },

            body: JSON.stringify(
                dados
            )

        }
    );

    const result = await res.json();

    alert(result.message);

    if(result.success)
        window.location.href =
        'config_usuarios.php';

};

</script>

</body>
</html>