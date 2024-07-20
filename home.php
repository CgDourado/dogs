<?php
session_start();
include 'BD/conecta.php'; // Ajuste o caminho conforme necessário
include '../dogs/navbar/navbar.php'; // Inclua a navbar

// Verificar se o usuário está logado
if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
    header('Location: index.php');
    exit();
}

// Recuperar informações do usuário
$user_id = $_SESSION['user_id'];
$user_nome = $_SESSION['user_nome'];

// Consultar os cães associados ao usuário
$stmt = $conn->prepare("SELECT id, nome_dog, raca_dog, dono_do_dog FROM dog WHERE usuario = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }

        .home-container {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 800px;
            margin: 50px auto;
            text-align: center;
        }

        table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #007BFF;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <div class="home-container">
        <h1>Bem-vindo, <?php echo htmlspecialchars($user_nome); ?>!</h1>
        <p>Você está logado.</p>
        
        <h2>Meus Cães</h2>
        <?php if ($result->num_rows > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Raça</th>
                        <th>Dono</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['id']); ?></td>
                            <td><?php echo htmlspecialchars($row['nome_dog']); ?></td>
                            <td><?php echo htmlspecialchars($row['raca_dog']); ?></td>
                            <td><?php echo htmlspecialchars($row['dono_do_dog']); ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>Você não tem cães cadastrados.</p>
        <?php endif; ?>

        <?php
        // Fechar a declaração e a conexão
        $stmt->close();
        $conn->close();
        ?>
    </div>
</body>
</html>
