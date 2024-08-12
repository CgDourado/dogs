<?php
    include '../BD/conecta.php';

    // Recebendo os dados do formulário via POST
    $id = $_POST['id'];
    $nome_tutor = $_POST['nome_tutor'];
    $endereco_tutor = $_POST['endereco_tutor'];
    $nome_pet = $_POST['nome_pet'];
    $especie_pet = $_POST['especie_pet'];
    $raca_pet = $_POST['raca_pet'];

    // Query de atualização
    $sql = "UPDATE dono_dog SET nome_tutor=?, endereco_tutor=?, especie_pet=?, nome_pet=?, raca_pet=? WHERE id=?";

    // Preparando a declaração
    $stmt = $conn->prepare($sql) or die($conn->error);

    if (!$stmt) {
        echo "Erro na atualização! ".$conn->errno.'-'.$conn->error;
    }

    // Associando os parâmetros e executando a declaração
    $stmt->bind_param('sssssi', $nome_tutor, $endereco_tutor, $especie_pet, $nome_pet, $raca_pet, $id);
    $stmt->execute();

    // Fechando a declaração
    $stmt->close();

    // Comitando a transação
    mysqli_commit($conn);

    // Redirecionando de volta para a página de listagem dos pets
    header("Location: ../pages/pets/tabela_pets.php");
?>
