<?php
include 'custom/cabecalho.php';
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
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

        .login-container {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 300px;
            width: 100%;
            text-align: center;
        }

        .login-container h1 {
            margin-bottom: 20px;
            font-size: 24px;
        }

        .login-container input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .login-container button {
            padding: 9px 2px;
            background-color: #007BFF;
            border: none;
            border-radius: 4px;
            color: #fff;
            cursor: pointer;
            font-size: 18px;
            width: 100%;
        }

        .login-container button:hover {
            background-color: #0056b3;
        }

        .no-underline {
            text-decoration: none;
            color: blue; /* Ou a cor que preferir */
        }
        .no-underline:hover {
            text-decoration: underline; /* Opcional: sublinha ao passar o mouse */
        }
    </style>
</head>

<body>
    <div class="login-container">
        <h1>Login</h1>
        <form action="conta/login.php" method="post">
            <?php
            include 'BD/conecta.php'; // Ajuste o caminho conforme necessário

            // Consulta para obter usuários
            $result = $conn->query("SELECT id, nome_usuario FROM usuario");

            if ($result->num_rows > 0) {
                echo '<select class="form-select" aria-label="Default select example" name="usuario_id">';
                echo '<option selected>Selecione seu Usuário</option>';

                // Preencher o <select> com os usuários do banco de dados
                while ($row = $result->fetch_assoc()) {
                    echo '<option value="' . $row['id'] . '">' . $row['nome_usuario'] . '</option>';
                }

                echo '</select>';
            } else {
                echo '<select class="form-select" aria-label="Default select example" name="usuario_id">';
                echo '<option>Não há usuários cadastrados</option>';
                echo '</select>';
            }

            $conn->close();
            ?>
            <br>
            <button type="submit">Entrar</button>
            <br><br>
            <?php
            echo "Não tem um Usuário?"; 
            ?>
            <a href="conta/cad_usuario.php" class="no-underline">Clique Aqui</a>
        </form>
    </div>
</body>

</html>
