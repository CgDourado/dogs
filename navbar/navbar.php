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
            flex: 1;
            /* Ocupa o espaço disponível */
            display: flex;
            justify-content: center;
            /* Centraliza horizontalmente */
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
            color: #FFFFFF;
            /* Branco */
            transition: color 0.3s ease;
        }

        .nav-links a:hover,
        .nav-links a:active,
        .nav-links a:focus {
            color: #FFA07A;
            /* Laranja Claro */
        }

        /* Estilos específicos para o botão de sair na barra de navegação */
        .logout-btn {
            color: #FFFFFF;
            /* Branco */
            background-color: #ff0f0f;
            /* Vermelho Brilhante */
            padding: 10px 15px;
            border-radius: 5px;
            border: 2px solid transparent;
            /* Borda inicial invisível */
            transition: background-color 0.3s ease, border-color 0.3s ease;
            font-weight: bold;
            text-decoration: none;
            display: inline-block;
        }

        .logout-btn:hover {
            background-color: #ba0404;
            /* Vermelho Claro */
            color: white;
            text-decoration: none;
        }
    </style>
</head>

<body>
    <header>
        <nav class="navbar">
            <div class="nav-links-group">
                <ul class="nav-links">
                    <li><a href="../page_home/home.php">Início</a></li>
                    <li><a href="../pets/tabela_pets.php">Pets</a></li>
                </ul>
            </div>
            <a href="../page_home/logout.php" class="logout-btn">Sair</a>
        </nav>
    </header>
</body>

</html>
