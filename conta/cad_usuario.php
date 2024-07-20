<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Cadastro de Usuário</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }

        .cadastro-container {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 300px;
            width: 100%;
            text-align: center;
        }

        .cadastro-container h1 {
            margin-bottom: 20px;
            font-size: 24px;
        }

        .cadastro-container input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .cadastro-container button {
            padding: 10px 15px;
            background-color: #007BFF;
            border: none;
            border-radius: 4px;
            color: #fff;
            cursor: pointer;
            font-size: 16px;
            margin: 5px;
        }

        .cadastro-container button:hover {
            background-color: #0056b3;
        }

        .cadastro-container button.back-button {
            background-color: #fc4444; /* Vermelho */
        }

        .cadastro-container button.back-button:hover {
            background-color: #a63232; /* Vermelho escuro */
        }
    </style>
</head>

<body>
    <div class="cadastro-container">
        <h1>Cadastro</h1>
        <form action="processa_cadastro.php" method="post">
            <input type="text" name="nome" placeholder="Nome" required>
            <input type="email" name="email" placeholder="Email" required>
            <button type="submit">Cadastrar</button>
            <a href="../index.php">
                <button type="button" class="back-button">Voltar</button>
            </a>
        </form>
    </div>
</body>

</html>
