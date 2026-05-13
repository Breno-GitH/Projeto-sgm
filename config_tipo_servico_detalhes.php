<!DOCTYPE html>
<html lang="pt-br">

<head>

    <meta charset="UTF-8">

    <title>
        SGM - Editar Tipo de Serviço
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

            padding: 28px 35px;

            position: relative;

            overflow: hidden;

        }

        .card-header-custom::before{

            content: "";

            position: absolute;

            width: 220px;
            height: 220px;

            border-radius: 50%;

            background: rgba(255,255,255,0.08);

            top: -120px;
            right: -80px;

        }

        .card-title{

            color: white;

            font-weight: 800;

            font-size: 1.4rem;

            position: relative;

            z-index: 2;

            display: flex;

            align-items: center;

            gap: 15px;

            margin: 0;

        }

        .card-title i{

            font-size: 1.8rem;

            color: #80d8ff;

        }

        .card-body{

            padding: 40px;

        }

        .form-label{

            color: #1a237e;

            font-weight: 700;

            margin-bottom: 10px;

        }

        .form-control{

            border-radius: 16px;

            padding: 14px 18px;

            border: 1px solid rgba(26,35,126,0.10);

            background: rgba(255,255,255,0.85);

            transition: 0.3s;

        }

        .form-control:focus{

            border-color: #1a237e;

            box-shadow: 0 0 0 0.2rem rgba(26,35,126,0.12);

        }

        .btn-update{

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

        .btn-update:hover{

            transform: translateY(-4px);

            color: white;

            box-shadow: 0 16px 35px rgba(26,35,126,0.28);

        }

        .btn-cancel{

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

        .btn-cancel:hover{

            color: #1a237e;

            transform: translateX(-3px);

        }

    </style>

</head>

<body>

<main class="container py-5">

    <div class="row justify-content-center">

        <div class="col-md-6">

            <div class="edit-card">

                <div class="card-header-custom">

                    <h5 class="card-title">

                        <i class="bi bi-wrench-adjustable-circle-fill"></i>

                        Editar Tipo de Serviço

                    </h5>

                </div>

                <div class="card-body">

                    <form id="formEditar">

                        <div class="mb-4">

                            <label class="form-label">

                                Descrição

                            </label>

                            <input type="text"
                            id="nome"
                            class="form-control"
                            required>

                        </div>

                        <button type="submit"
                        class="btn btn-update w-100">

                            <i class="bi bi-check-circle-fill me-2"></i>

                            Atualizar

                        </button>

                        <a href="config_tipos_servico.php"
                        class="btn-cancel w-100">

                            <i class="bi bi-arrow-left"></i>

                            Cancelar

                        </a>

                    </form>

                </div>

            </div>

        </div>

    </div>

</main>

<script>

const idTipo = new URLSearchParams(
    window.location.search
).get('id');

window.onload = async () => {

    const res = await fetch(
        'api/api_tipos_servico.php'
    );

    const result = await res.json();

    const tipo = result.data.find(
        t => t.id_tipo == idTipo
    );

    if(tipo)
        document.getElementById(
            'nome'
        ).value = tipo.nome;

};

document.getElementById(
    'formEditar'
).onsubmit = async (e) => {

    e.preventDefault();

    const res = await fetch(
        'api/api_tipos_servico.php',
        {

            method: 'PUT',

            headers: {
                'Content-Type': 'application/json'
            },

            body: JSON.stringify({

                id_tipo: idTipo,

                nome: document.getElementById(
                    'nome'
                ).value

            })

        }
    );

    const result = await res.json();

    alert(result.message);

    if(result.success)
        window.location.href =
        'config_tipos_servico.php';

};

</script>

</body>
</html>