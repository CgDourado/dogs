<?php
    include '../BD/conecta.php';

    // Recebendo os dados do formulário via POST
    $id = $_POST['id'];
    $nome_cliente = $_POST['nome_cliente'];
    $endereco_cliente = $_POST['endereco_cliente'];
    $telefone_cliente = $_POST['telefone_cliente'];

    // Query de atualização
    $sql = "UPDATE clientes SET nome_cliente=?, endereco_cliente=?, telefone_cliente=? WHERE id=?";

    // Preparando a declaração
    $stmt = $conn->prepare($sql) or die($conn->error);

    if (!$stmt) {
        echo "Erro na atualização! ".$conn->errno.'-'.$conn->error;
    }

    // Associando os parâmetros e executando a declaração
    $stmt->bind_param('sssi', $nome_cliente, $endereco_cliente, $telefone_cliente, $id);
    $stmt->execute();

    // Fechando a declaração
    $stmt->close();

    // Comitando a transação
    mysqli_commit($conn);

    // Redirecionando de volta para a página de listagem dos pets
    header("Location: ../pages/clientes/tabela_clientes.php");
?>