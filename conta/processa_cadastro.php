<?php

include '../BD/conecta.php'; // Ajuste o caminho conforme necessário

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $email = $_POST['email'];

    // Verifique se $conn está definido
    if ($conn) {
        // Verifique se já existe um usuário com o mesmo email
        $stmt = $conn->prepare("SELECT id FROM usuario WHERE email_usuario = ?");
        if ($stmt) {
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $stmt->store_result();

            if ($stmt->num_rows > 0) {
                // Usuário já existe com o mesmo email
                $stmt->close();
                echo "<script>alert('Já existe um usuário cadastrado com este email.'); window.location.href='cad_usuario.php';</script>";
                exit();
            } else {
                $stmt->close();

                // Insere o novo usuário no banco de dados
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
            }
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
