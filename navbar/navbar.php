<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Apple-like Navbar</title>
    <style>
        /* Reset de margens e definição da fonte padrão */
        body {
            margin: 0;
            font-family: 'Helvetica', sans-serif;
        }

        /* Estilos para o cabeçalho (barra de navegação) */
        header {
            background-color: #141414;
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
            color: #b3b3b3;
            transition: color 0.3s ease;
        }

        .nav-links a:hover,
        .nav-links a:active,
        .nav-links a:focus {
            color: #0384fc;
        }

        /* Estilos para a logo na barra de navegação */
        .logo {
            margin-right: auto;
        }

        .logo img {
            max-width: 35%;
            height: auto;
            margin-top: -10px;
        }

        /* Estilos específicos para o botão de sair na barra de navegação */
        .nav-links a.logout-btn:hover {
            color: white;
            background-color: #c0392b;
        }

        /* Estilos para o botão de sair na barra de navegação */
        .logout-btn {
            color: #c0392b;
            padding: 10px 15px;
            border-radius: 5px;
            transition: background-color 0.3s ease;
            font-weight: bold;
            text-decoration: none;
        }

        .logout-btn:hover {
            background-color: red;
            color: white;
        }
    </style>

</head>

<body>
    <header>
        <nav class="navbar">
            <!-- <div class="logo"><img src="css/logo.png" alt="logo"></div> -->
            <div class="nav-links-group">
                <ul class="nav-links">
                    <li><a href="home.php">Início</a></li>
                    <!-- <li><a href="usuarios_html.php">Clientes</a></li> -->
                </ul>
            </div>
            <a href="logout.php" class="logout-btn">Sair</a>
        </nav>
    </header>
</body>

</html>
