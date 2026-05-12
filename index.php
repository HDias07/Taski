<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Taski - Login</title>
    <link rel="shortcut icon" href="img/favicon-16x16.png" type="image/x-icon">

    <style>
        * {
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            margin: 0;
            background: #4a2ca5;
        }

        /* CABEÇALHO */
        header {
            width: 100%;
            height: 70px;
            background: linear-gradient(90deg, #4a00e0, #8e2de2); /* cor nova */
            display: flex;
            justify-content: center;
            align-items: center;
        }

        header img {
            height: 100px;
        }

        /* LOGIN */
        .main {
            height: calc(100vh - 70px);
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .container {
            width: 300px;
            padding: 30px;
            border-radius: 25px;
            background: linear-gradient(135deg, #0f8b8d, #5b3c88);
            text-align: center;
        }

        h2 {
            color: #fff;
            margin-bottom: 25px;
        }

        .input-group {
            margin-bottom: 15px;
            text-align: left;
        }

        .input-group label {
            color: #ddd;
            font-size: 13px;
        }

        .input-group input {
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 20px;
            margin-top: 5px;
            background-color: #eee;
        }

        .btn {
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 20px;
            background-color: #4a90c2;
            color: white;
            font-size: 15px;
            cursor: pointer;
            margin-top: 10px;
        }

        .btn:hover {
            background-color: #3b7aa3;
        }

        .link {
            display: block;
            margin-top: 12px;
            color: #fff;
            font-size: 13px;
            text-decoration: none;
        }

        .link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<header>
    <img src="img/logo-taski-png.png" alt="Taski">
</header>

<div class="main">
    <div class="container">
        <form method="POST" action="login.php">
            <h2>Login</h2>

            <div class="input-group">
                <label>Login</label>
                <input type="text" name="usuario" required>
            </div>

            <div class="input-group">
                <label>Senha</label>
                <input type="password" name="senha" required>
            </div>

            <input class="btn" type="submit" value="Login">
        </form>

        <a class="link" href="cadastro.php">Criar conta</a>
    </div>
</div>

</body>
</html>