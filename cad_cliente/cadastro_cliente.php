<?php
session_start();
include '../BD/conecta.php'; // Ajuste o caminho conforme necessário

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome_cliente = $_POST['nome_cliente'];
    $endereco_cliente = $_POST['endereco_cliente'];
    $telefone_cliente = $_POST['telefone_cliente'];

    // Verifica se o usuário está logado
    if (isset($_SESSION['usuario_id'])) {
        $usuario_id = $_SESSION['usuario_id'];

        // Verifica se a conexão com o banco de dados foi estabelecida
        if ($conn) {
            // Verifica se já existe um registro com o mesmo nome_tutor e nome_pet
            $checkStmt = $conn->prepare("SELECT COUNT(*) FROM clientes WHERE nome_cliente = ? AND endereco_cliente = ? AND telefone_cliente = ? AND usuario = ?");
            $checkStmt->bind_param("sssi", $nome_cliente, $endereco_cliente, $telefone_cliente, $usuario_id);
            $checkStmt->execute();
            $checkStmt->bind_result($count);
            $checkStmt->fetch();
            $checkStmt->close();

            if ($count > 0) {
                echo "Registro já existe.";
            } else {
                // Prepara a consulta SQL para inserir os dados
                $stmt = $conn->prepare("INSERT INTO clientes (nome_cliente, endereco_cliente, telefone_cliente, usuario) VALUES (?, ?, ?, ?)");
                
                if ($stmt) {
                    $stmt->bind_param("sssi", $nome_cliente, $endereco_cliente, $telefone_cliente, $usuario_id);
                    if ($stmt->execute()) {
                        $stmt->close();
                        echo 'success'; // Resposta de sucesso
                    } else {
                        echo "Erro na execução da consulta: " . $conn->error;
                    }
                } else {
                    echo "Erro na preparação da consulta: " . $conn->error;
                }
            }
        } else {
            echo "Erro na conexão com o banco de dados.";
        }
    } else {
        echo "Usuário não está logado.";
    }
} else {
    // Redirecionar de volta para o formulário se o acesso for direto a cadastro_dd.php
    header('Location: ../pages/clientes/tabela_clientes.php');
    exit();
}
?>