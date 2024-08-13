<?php
session_start();
include '../BD/conecta.php'; // Ajuste o caminho conforme necessário

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $dono_pet = $_POST['dono_pet']; // Nome do dono selecionado no formulário

    // Verifica se o usuário selecionou uma espécie do dropdown ou digitou uma nova
    if ($_POST['especie_pet_select'] === 'Outra') {
        $especie_pet = $_POST['especie_pet']; // Usa o valor do input de texto
    } else {
        $especie_pet = $_POST['especie_pet_select']; // Usa o valor do select
    }

    $raca_pet = $_POST['raca_pet'];
    $nome_pet = $_POST['nome_pet'];

    // Verifica se o usuário está logado
    if (isset($_SESSION['usuario_id'])) {
        $usuario_id = $_SESSION['usuario_id'];

        // Verifica se a conexão com o banco de dados foi estabelecida
        if ($conn) {
            // Verifica se já existe um registro com o mesmo nome_tutor e nome_pet
            $checkStmt = $conn->prepare("SELECT COUNT(*) FROM pets WHERE dono_pet = ? AND nome_pet = ? AND usuario = ?");
            $checkStmt->bind_param("ssi", $dono_pet, $nome_pet, $usuario_id);
            $checkStmt->execute();
            $checkStmt->bind_result($count);
            $checkStmt->fetch();
            $checkStmt->close();

            if ($count > 0) {
                echo "Registro já existe.";
            } else {
                // Prepara a consulta SQL para inserir os dados
                $stmt = $conn->prepare("INSERT INTO pets (dono_pet, especie_pet, raca_pet, nome_pet, usuario) VALUES (?, ?, ?, ?, ?)");
                
                if ($stmt) {
                    $stmt->bind_param("ssssi", $dono_pet, $especie_pet, $raca_pet, $nome_pet, $usuario_id);
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
    header('Location: ../pages/page_home/home.php');
    exit();
}
?>