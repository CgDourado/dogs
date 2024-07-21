<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../cabecalho/stylesheet.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        /* Reset de margens e definição da fonte padrão */
        body {
            margin: 0;
            font-family: 'Helvetica', sans-serif;
        }

        /* Estilos para o cabeçalho (barra de navegação) */
        header {
            background-color: #a65012;
            padding: 1px 20px;
            height: 80px;
            box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.5);
            display: flex;
            align-items: center;
            width: 100%;
        }

        /* Estilos para a barra de navegação */
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 100%;
        }

        /* Estilos para o grupo centralizado */
        .nav-links-group {
            flex: 1; /* Ocupa o espaço disponível */
            display: flex;
            justify-content: center; /* Centraliza horizontalmente */
        }

        /* Estilos para a lista de links na barra de navegação */
        .nav-links {
            list-style: none;
            display: flex;
            padding: 0;
            margin: 0;
        }

        /* Estilos para cada item da lista de links */
        .nav-links li {
            margin: 0 20px;
        }

        /* Estilos para os links na barra de navegação */
        .nav-links a {
            text-decoration: none;
            color: #FFFFFF; /* Branco */
            transition: color 0.3s ease;
        }

        .nav-links a:hover,
        .nav-links a:active,
        .nav-links a:focus {
            color: #FFA07A; /* Laranja Claro */
        }

        /* Estilos específicos para o botão de sair na barra de navegação */
        .logout-btn {
            color: #FFFFFF; /* Branco */
            background-color: #ff0f0f; /* Vermelho Brilhante */
            padding: 10px 15px;
            border-radius: 5px;
            border: 2px solid transparent; /* Borda inicial invisível */
            transition: background-color 0.3s ease, border-color 0.3s ease;
            font-weight: bold;
            text-decoration: none;
            display: inline-block;
        }

        .logout-btn:hover {
            background-color: #ba0404; /* Vermelho Claro */
            color: white;
        }
    </style>
</head>

<body>
    <header>
        <nav class="navbar">
            <div class="nav-links-group">
                <ul class="nav-links">
                    <li><a href="../page_home/home.php">Início</a></li>
                    <li><a href="#" data-toggle="modal" data-target="#cadastroModal">Cadastro</a></li>
                </ul>
            </div>
            <a href="../page_home/logout.php" class="logout-btn">Sair</a>
        </nav>
    </header>

    <!-- Modal -->
    <div class="modal fade" id="cadastroModal" tabindex="-1" role="dialog" aria-labelledby="cadastroModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="cadastroModalLabel">Cadastro</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Formulário de Cadastro -->
                    <form id="registrationForm" action="cad_dono_dog/cadastro_dd.php" method="POST">
                        <div class="form-group">
                            <label for="nome_tutor">Nome do Tutor:</label>
                            <input type="text" class="form-control" id="nome_tutor" name="nome_tutor" placeholder="Digite o nome">
                        </div>
                        <div class="form-group">
                            <label for="endereco">Endereço do Tutor:</label>
                            <input type="text" class="form-control" id="endereco" name="endereco" placeholder="Digite o endereço">
                        </div>
                        <div class="form-group">
                            <label for="nome_pet">Nome do Pet:</label>
                            <input type="text" class="form-control" id="nome_pet" name="nome_pet" placeholder="Digite o nome">
                        </div>
                        <div class="form-group">
                            <label for="raca">Raça do Pet:</label>
                            <input type="text" class="form-control" id="raca" name="raca" placeholder="Digite a raça">
                        </div>
                        <button type="submit" class="btn btn-primary">Cadastrar</button>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
