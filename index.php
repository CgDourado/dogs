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
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

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
            color: #007BFF;
            /* Ou a cor que preferir */
        }

        .no-underline:hover {
            text-decoration: underline;
            /* Opcional: sublinha ao passar o mouse */
        }

        .login-container h1 {
            color: #2c2e2d
        }

        .login-container p1 {
            color: #2c2e2d
        }

        .login-container hr {
            border: 0.01px solid #3b3939;
        }

        .float-btn {
            position: fixed;
            bottom: 20px;
            right: 20px;
            width: 60px;
            height: 60px;
            background-color: #f74343;
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
            cursor: pointer;
            font-size: 24px;
            text-align: center;
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
            <hr>
            <p1>Não tem um Usuário?</p1>
            <a href="conta/cad_usuario.php" class="no-underline">Clique Aqui</a>
        </form>
    </div>
    
    <!-- Floating Button -->
    <div class="float-btn" data-toggle="modal" data-target="#deleteModal" title="Excluir Usuário">
        🗑️
    </div>

    <!-- Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Excluir Conta</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="deleteForm" method="POST" action="conta/delete_users.php" onsubmit="return confirmDelete();">
                        <div class="form-group">
                            <label for="userSelect">Selecione o Usuário</label>
                            <select id="userSelect" name="user_id" class="form-control" required>
                                <!-- Options will be populated by PHP -->
                            </select>
                        </div>
                        <button type="submit" class="btn btn-danger">Excluir</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        $(document).ready(function() {
            $.ajax({
                url: 'conta/get_users.php', // Verifique o caminho
                method: 'GET',
                success: function(data) {
                    const users = JSON.parse(data);
                    const $userSelect = $('#userSelect');
                    $userSelect.empty(); // Limpa as opções existentes
                    users.forEach(user => {
                        $userSelect.append(`<option value="${user.id}">${user.nome_usuario}</option>`);
                    });
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error('Erro ao buscar usuários:', textStatus, errorThrown);
                }
            });
        });

        function confirmDelete() {
            return confirm('Tem certeza de que deseja excluir este usuário?');
        }
    </script>

</body>

</html>