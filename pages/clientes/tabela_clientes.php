<?php
session_start();
if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
    header('Location: ../../index.php');
    exit();
}

include '../../BD/conecta.php'; // Ajuste o caminho conforme necessário
include '../../custom/cabecalho.php';
include '../../navbar/navbar.php'; // Inclua a navbar

// Recuperar informações do usuário
$user_id = $_SESSION['usuario_id'];
$user_nome = $_SESSION['user_nome'];

// Consultar os cães associados ao usuário
$stmt = $conn->prepare("SELECT id, nome_cliente, endereco_cliente, telefone_cliente, usuario FROM clientes WHERE usuario = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
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

        table,
        th,
        td {
            border: 1px solid #ddd;
        }

        th,
        td {
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

        .btn-cadastro {
            margin: 20px 0;
        }

        .modal-body .form-label {
            text-align: left;
            display: block;
            margin-bottom: 0.5rem;
        }

        .mb-4 {
            border-color: #a65012;
        }
    </style>
</head>

<body>
    <div class="container-fluid">
        <br><br>
        <div class="row row-cols-1 mb-3 text-center">
            <div class="col">
                <div class="card mb-4 rounded-3 shadow-sm">
                    <div class="card-header py-2">
                        <h4 class="my-0 fw-normal"><b><svg xmlns="http://www.w3.org/2000/svg" width="27" height="27" fill="currentColor" class="bi bi-person-workspace" viewBox="0 0 16 16">
                                    <path d="M4 16s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1zm4-5.95a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5" />
                                    <path d="M2 1a2 2 0 0 0-2 2v9.5A1.5 1.5 0 0 0 1.5 14h.653a5.4 5.4 0 0 1 1.066-2H1V3a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v9h-2.219c.554.654.89 1.373 1.066 2h.653a1.5 1.5 0 0 0 1.5-1.5V3a2 2 0 0 0-2-2z" />
                                </svg>&nbsp;&nbsp;Clientes</b></h4><br />
                        <button type="button" class="btn btn-primary btn-cadastro" data-toggle="modal" data-target="#cadastroModal">Cadastrar novo Cliente</button>
                    </div>
                    <div class="card-body">
                        <?php if ($result->num_rows > 0) : ?>
                            <table id="ClienteTable" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Nome</th>
                                        <th>Endereço</th>
                                        <th>Telefone</th>
                                        <th>Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($row = $result->fetch_assoc()) : ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($row['nome_cliente']); ?></td>
                                            <td><?php echo htmlspecialchars($row['endereco_cliente']); ?></td>
                                            <td><?php echo htmlspecialchars($row['telefone_cliente']); ?></td>
                                            <td>
                                                <a href="#" class="edit-pet" data-id="<?php echo $row['id']; ?>" style="text-decoration: none;" data-bs-toggle="modal" data-bs-target="#editModal<?php echo $row['id']; ?>">✏️</a>
                                                |
                                                <a href="../../cad_cliente/delete_cliente.php?id=<?php echo $row['id']; ?>" style="text-decoration: none;" class="delete-cliente" onclick="return confirm('Tem certeza que deseja excluir?')">🗑️</a>
                                            </td>
                                        </tr>

                                        <!-- Modal de Edição -->
                                        <div class="modal fade" id="editModal<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="editModalLabel<?php echo $row['id']; ?>" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="editModalLabel<?php echo $row['id']; ?>">Editar Pet</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form id="formEditCliente<?php echo $row['id']; ?>" method="post" action="../../cad_cliente/edita_cliente.php">
                                                            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                                            <label class="form-label">Nome do Cliente:</label>
                                                            <input type="text" class="form-control" id="edit_nome_cliente<?php echo $row['id']; ?>" name="nome_cliente" value="<?php echo ($row['nome_cliente']); ?>" required>
                                                            <br />
                                                            <label class="form-label">Endereço do Cliente:</label>
                                                            <input type="text" class="form-control" id="edit_endereco_cliente<?php echo $row['id']; ?>" name="endereco_cliente" value="<?php echo ($row['endereco_cliente']); ?>" required>
                                                            <br />
                                                            <label class="form-label">Telefone do Cliente:</label>
                                                            <input type="tel" class="form-control" id="edit_telefone_cliente<?php echo $row['id']; ?>" name="telefone_cliente" value="<?php echo ($row['telefone_cliente']); ?>" required>
                                                            <br />
                                                            <button type="submit" class="btn btn-primary">Salvar Alterações</button>
                                                        </form>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Fechar</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                        <?php else : ?>
                            <p>Você não tem Clientes cadastrados.</p>
                        <?php endif; ?>

                        <?php
                        // Fechar a declaração e a conexão
                        $stmt->close();
                        $conn->close();
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="cadastroModal" tabindex="-1" role="dialog" aria-labelledby="cadastroModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="cadastroModalLabel">Cadastro</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Formulário de Cadastro -->
                    <form id="registrationForm" action="/dogs/cad_cliente/cadastro_cliente.php" method="POST">
                        <div class="form-group">
                            <label>Nome do Cliente:</label>
                            <input type="text" class="form-control" id="nome_cliente" name="nome_cliente" placeholder="Digite o nome" required />
                            <br />
                            <label>Endereço do Cliente:</label>
                            <input type="text" class="form-control" id="endereco" name="endereco_cliente" placeholder="Digite o endereço" required />
                            <br />
                            <label>Telefone do Cliente:</label>
                            <input type="tel" class="form-control" id="telefone_cliente" name="telefone_cliente" placeholder="Ex: (XX) XXXXX-XXXX" required />
                            <br />
                        </div>
                        <button type="submit" id="submit" class="btn btn-success">Cadastrar</button>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Função para aplicar a máscara de telefone
        function applyPhoneMask(input) {
            let value = input.value.replace(/\D/g, ''); // Remove tudo que não for dígito
            if (value.length > 10) {
                value = value.replace(/^(\d{2})(\d{5})(\d{4}).*/, '($1) $2-$3');
            } else if (value.length > 5) {
                value = value.replace(/^(\d{2})(\d{4})(\d{0,4}).*/, '($1) $2-$3');
            } else if (value.length > 2) {
                value = value.replace(/^(\d{2})(\d{0,5})/, '($1) $2');
            } else {
                value = value.replace(/^(\d*)/, '($1');
            }
            input.value = value;
        }

        // Aplica a máscara ao campo de telefone no cadastro
        document.getElementById('telefone_cliente').addEventListener('input', function(e) {
            applyPhoneMask(e.target);
        });

        // Aplica a máscara em todos os campos de telefone dos modais de edição
        document.querySelectorAll('[id^="edit_telefone_cliente"]').forEach(function(element) {
            element.addEventListener('input', function(e) {
                applyPhoneMask(e.target);
            });
        });
    </script>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#registrationForm').on('submit', function(e) {
                e.preventDefault();

                $.ajax({
                    type: 'POST',
                    url: '/dogs/cad_cliente/cadastro_cliente.php',
                    data: $(this).serialize(),
                    success: function(response) {
                        if (response.trim() === 'success') {
                            alert('Cadastro realizado com sucesso!');
                            // Redirecionar para a mesma página
                            window.location.reload();
                        } else {
                            alert(response);
                        }
                    },
                    error: function() {
                        alert('Erro ao cadastrar.');
                    }
                });
            });
        });
    </script>
</body>

</html>