<!DOCTYPE html>
<html lang="pt-br">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
    content="width=device-width, initial-scale=1.0">

    <title>SGM - Login</title>

    <link rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">

    <link rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>

        body{
            background: #f5f7fb;
            overflow-x: hidden;
            position: relative;
            font-family: "Segoe UI", sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
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

        .login-card{
            width: 100%;
            max-width: 420px;
            background: rgba(255,255,255,0.92);
            backdrop-filter: blur(10px);
            border-radius: 28px;
            padding: 48px;
            border: 1px solid rgba(26,35,126,0.08);
            box-shadow: 0 15px 40px rgba(0,0,0,0.05);
            position: relative;
            z-index: 1;
        }

        .login-title{
            font-weight: 800;
            color: #1a237e;
            margin-bottom: 32px;
            text-align: center;
        }

        .form-label{
            font-weight: 600;
            color: #1a237e;
            margin-bottom: 10px;
        }

        .form-control{
            border: 1px solid rgba(26,35,126,0.15);
            border-radius: 12px;
            padding: 12px 16px;
            font-size: 0.95rem;
            transition: 0.3s;
        }

        .form-control:focus{
            border-color: #1a237e;
            box-shadow: 0 0 0 3px rgba(26,35,126,0.1);
        }

        .login-btn{
            width: 100%;
            border: none;
            border-radius: 12px;
            padding: 12px 24px;
            font-weight: 700;
            font-size: 0.95rem;
            color: white;
            background: linear-gradient(
                45deg,
                #1a237e,
                #283593
            );
            transition: 0.3s;
            margin-top: 8px;
        }

        .login-btn:hover{
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(26,35,126,0.3);
        }

        .mensagem-erro{
            margin-top: 16px;
            padding: 12px 16px;
            border-radius: 12px;
            background: rgba(220,38,38,0.1);
            color: #dc2626;
            font-size: 0.9rem;
            border-left: 4px solid #dc2626;
        }

    </style>

</head>

<body>

    <div class="login-card">

        <h3 class="login-title">

            <i class="bi bi-shield-lock me-2"></i>SGM - Acesso

        </h3>

        <form id="formLogin">

            <div class="mb-4">

                <label class="form-label" for="email">
                    E-mail
                </label>

                <input type="email"
                id="email"
                class="form-control"
                placeholder="seu@email.com"
                required>

            </div>

            <div class="mb-4">

                <label class="form-label" for="senha">
                    Senha
                </label>

                <input type="password"
                id="senha"
                class="form-control"
                placeholder="••••••••"
                required>

            </div>

            <button type="submit"
            class="btn login-btn">
                Entrar
            </button>

            <div id="mensagem" class="mensagem-erro d-none"></div>

        </form>

    </div>

    <script src="assets/js/login.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>