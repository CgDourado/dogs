<?php

include '../BD/conecta.php'; // Ajuste o caminho conforme necessário

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $email = $_POST['email'];

    // Verifique se $conn está definido
    if ($conn) {
        $stmt = $conn->prepare("INSERT INTO usuario (nome_usuario, email_usuario) VALUES (?, ?)");
        if ($stmt) {
            $stmt->bind_param("ss", $nome, $email);
            $stmt->execute();
            $stmt->close();

            // Redirecione após sucesso
            header('Location: ../index.php'); // Ou qualquer página de sucesso
            exit();
        } else {
            echo "Erro na preparação da consulta: " . $conn->error;
        }
    } else {
        echo "Erro na conexão com o banco de dados.";
    }

} else {
    // Redirecionar de volta para o formulário de cadastro se o acesso for direto a processa_cadastro.php.
    header('Location: index.php');
    exit();
}
?>