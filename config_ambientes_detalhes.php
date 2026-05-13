<!DOCTYPE html>
<html lang="pt-br">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
    content="width=device-width, initial-scale=1.0">

    <title>
        SGM - Editar Ambiente
    </title>

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

        .btn-back{

            border-radius: 14px;

            padding: 10px 18px;

            font-weight: 600;

            border: 1px solid rgba(26,35,126,0.15);

            background: rgba(255,255,255,0.8);

            color: #1a237e;

            transition: 0.3s;

        }

        .btn-back:hover{

            transform: translateY(-3px);

            background: #1a237e;

            color: white;

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

    </style>

</head>

<body>

<main class="container py-5">

    <div class="mb-4">

        <a href="config_ambientes.php"
        class="btn btn-back">

            <i class="bi bi-arrow-left"></i>

            Voltar

        </a>

    </div>


    <section class="row justify-content-center">

        <div class="col-lg-6 col-md-8">

            <div class="edit-card">

                <div class="card-header-custom">

                    <h5 class="card-title">

                        <i class="bi bi-pencil-square"></i>

                        Editar Ambiente

                    </h5>

                </div>

                <div class="card-body">

                    <form id="formEditarAmbiente">

                        <input type="hidden"
                        id="id_ambiente">


                        <div class="mb-4">

                            <label for="novoNome"
                            class="form-label">

                                Nome do Ambiente

                            </label>

                            <input type="text"
                            id="novoNome"
                            class="form-control"
                            placeholder="Carregando..."
                            required>

                        </div>


                        <div class="mb-4">

                            <label for="selectBloco"
                            class="form-label">

                                Bloco

                            </label>

                            <select class="form-select"
                            id="selectBloco"
                            required>

                                <option value="">
                                    Carregando blocos...
                                </option>

                            </select>

                        </div>


                        <button type="submit"
                        class="btn btn-save w-100">

                            <i class="bi bi-check-circle-fill me-2"></i>

                            Salvar Alterações

                        </button>

                    </form>

                </div>

            </div>

        </div>

    </section>

</main>


<script>

const urlParams = new URLSearchParams(window.location.search);

const idDoAmbiente = urlParams.get('id');

window.onload = async function() {

    if (!idDoAmbiente) {

        alert("ID não encontrado na URL!");

        window.location.href = 'config_ambientes.php';

        return;

    }

    await carregarDados();

};


async function carregarDados() {

    try {

        const resB = await fetch(
            'api/api_ambientes.php?metodo=LISTAR_BLOCOS'
        );

        const dataB = await resB.json();

        const selectB = document.getElementById('selectBloco');

        selectB.innerHTML =
        '<option value="">Selecione o Bloco...</option>';

        dataB.data.forEach(b => {

            selectB.innerHTML += `

                <option value="${b.id_bloco}">

                    ${b.nome}

                </option>

            `;

        });


        const resA = await fetch(
            'api/api_ambientes.php'
        );

        const dataA = await resA.json();

        const ambiente = dataA.data.find(
            a => a.id_ambiente == idDoAmbiente
        );

        if (ambiente) {

            document.getElementById(
                'id_ambiente'
            ).value = ambiente.id_ambiente;

            document.getElementById(
                'novoNome'
            ).value = ambiente.nome;

            document.getElementById(
                'selectBloco'
            ).value = ambiente.id_bloco;

        } else {

            alert("Ambiente não encontrado!");

        }

    } catch (e) {

        console.error("Erro ao carregar:", e);

        alert("Erro ao conectar com o servidor.");

    }

}


document.getElementById(
    'formEditarAmbiente'
).onsubmit = async function(e) {

    e.preventDefault();

    const dados = {

        id_ambiente: idDoAmbiente,

        nome: document.getElementById(
            'novoNome'
        ).value,

        id_bloco: document.getElementById(
            'selectBloco'
        ).value

    };

    try {

        const res = await fetch(
            'api/api_ambientes.php',
            {

                method: 'PUT',

                headers: {
                    'Content-Type': 'application/json'
                },

                body: JSON.stringify(dados)

            }
        );

        const result = await res.json();

        if (result.success) {

            alert("Ambiente atualizado com sucesso!");

            window.location.href = 'config_ambientes.php';

        } else {

            alert("Erro: " + result.message);

        }

    } catch (error) {

        alert("Erro na requisição.");

    }

};

</script>

</body>
</html>