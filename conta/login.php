<?php
session_start();
include '../BD/conecta.php'; // Ajuste o caminho conforme necessário

// Verificar se os dados do formulário foram enviados
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['usuario_id'])) {
        $usuario_id = $_POST['usuario_id'];

        // Preparar e executar a consulta
        $stmt = $conn->prepare("SELECT id, nome_usuario FROM usuario WHERE id = ?");
        $stmt->bind_param("i", $usuario_id);
        $stmt->execute();
        $stmt->store_result();

        // Verificar se o usuário existe
        if ($stmt->num_rows > 0) {
            $stmt->bind_result($id, $nome_usuario);
            $stmt->fetch();

            // Iniciar a sessão e armazenar informações do usuário
            $_SESSION['user_id'] = $id;
            $_SESSION['user_nome'] = $nome_usuario;
            $_SESSION['logged_in'] = true;

            // Redirecionar para a página protegida
            header('Location: ../home.php');
            exit();
        } else {
            echo "<script>alert('Selecione um Usuário.'); window.location.href = '../index.php';</script>";
        }

        $stmt->close();
    } else {
        echo "<script>alert('Selecione um usuário.'); window.location.href = '../index.php';</script>";
    }

    $conn->close();
} else {
    // Redirecionar para o formulário de login se o acesso for direto a login.php
    header('Location: ../index.php');
    exit();
}
?>
