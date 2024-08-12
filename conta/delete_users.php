<?php
include '../BD/conecta.php';

// Checar conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

if (isset($_POST['user_id'])) {
    $user_id = intval($_POST['user_id']);
    
    // Iniciar uma transação
    $conn->begin_transaction();

    try {
        // Excluir registros relacionados na tabela dono_dog
        $sql_dono_dog = "DELETE FROM dono_dog WHERE usuario = $user_id";
        if (!$conn->query($sql_dono_dog)) {
            throw new Exception("Erro ao excluir dados relacionados na tabela dono_dog: " . $conn->error);
        }
        
        // Excluir o usuário
        $sql_user = "DELETE FROM usuario WHERE id = $user_id";
        if ($conn->query($sql_user) === TRUE) {
            // Confirmar a transação
            $conn->commit();
            // Mensagem de sucesso
            echo "<script>
                    alert('Usuário e dados relacionados excluídos com sucesso.');
                    window.location.href = '../index.php';
                  </script>";
        } else {
            throw new Exception("Erro ao excluir usuário: " . $conn->error);
        }
    } catch (Exception $e) {
        // Reverter a transação em caso de erro
        $conn->rollback();
        // Mensagem de erro
        echo "<script>
                alert('" . $e->getMessage() . "');
                window.location.href = '../index.php';
              </script>";
    }
}

$conn->close();
?>
