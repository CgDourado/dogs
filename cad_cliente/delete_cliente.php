<?php
    include '../BD/conecta.php';
    $id = $_GET['id'];
    mysqli_begin_transaction($conn);
    $sql1 = "DELETE FROM clientes WHERE id=$id";
    if (mysqli_query($conn, $sql1)) {
        mysqli_commit($conn);
        echo "<script language='javascript' type='text/javascript'>
        window.location.href='../pages/clientes/tabela_clientes.php';
        </script>";
    } else {
        mysqli_rollback($conn);
        echo "<script language='javascript' type='text/javascript'>
        alert('Não foi possivel Excluir!');
        window.location.href='../pages/clientes/tabela_clientes.php';
        </script>";
    }
?>