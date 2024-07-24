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
$stmt = $conn->prepare("SELECT id, nome_tutor, endereco_tutor, especie_pet, nome_pet, raca_pet, usuario FROM dono_dog WHERE usuario = ?");
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
    </style>
</head>

<body>
    <div class="container-fluid">
        <br><br>
        <div class="row row-cols-1 mb-3 text-center">
            <div class="col">
                <div class="card mb-4 rounded-3 shadow-sm border-dark">
                    <div class="card-header py-2">
                        <h4 class="my-0 fw-normal"><b><svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-paw" viewBox="0 0 16 16">
                                    <path d="M8 1a2 2 0 0 1 2 2 2 2 0 0 1-2 2A2 2 0 0 1 6 3 2 2 0 0 1 8 1zM8 5a3 3 0 0 0 3-3 3 3 0 0 0-6 0 3 3 0 0 0 3 3zm0 1a4 4 0 0 1 4 4v2a4 4 0 0 1-8 0V10a4 4 0 0 1 4-4z" />
                                </svg>&nbsp;&nbsp;Pets</b></h4>
                        <br />
                        <button type="button" class="btn btn-primary btn-cadastro" data-toggle="modal" data-target="#cadastroModal">Cadastrar novo Pet</button>
                    </div>
                    <div class="card-body">
                        <?php if ($result->num_rows > 0) : ?>
                            <table id="petsTable" class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Tutor</th>
                                        <th>Nome do Pet</th>
                                        <th>Espécie</th>
                                        <th>Raça</th>
                                        <th>Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($row = $result->fetch_assoc()) : ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($row['nome_tutor']); ?></td>
                                            <td><?php echo htmlspecialchars($row['nome_pet']); ?></td>
                                            <td><?php echo htmlspecialchars($row['especie_pet']); ?></td>
                                            <td><?php echo htmlspecialchars($row['raca_pet']); ?></td>
                                            <td>
                                                <a href="#" class="edit-pet" data-id="<?php echo $row['id']; ?>" data-bs-toggle="modal" data-bs-target="#editModal<?php echo $row['id']; ?>">✏️</a>
                                                |
                                                <a href="excluir_pet.php?id=<?php echo $row['id']; ?>" class="delete-pet" onclick="return confirm('Tem certeza que deseja excluir?')">🗑️</a>
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
                                                        <form id="formEditPet<?php echo $row['id']; ?>" method="post" action="editar_pet.php">
                                                            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                                            <div class="mb-3">
                                                                <label for="edit_nome_tutor<?php echo $row['id']; ?>" class="form-label">Nome do Tutor</label>
                                                                <input type="text" class="form-control" id="edit_nome_tutor<?php echo $row['id']; ?>" name="nome_tutor" value="<?php echo htmlspecialchars($row['nome_tutor']); ?>" required>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="edit_nome_pet<?php echo $row['id']; ?>" class="form-label">Nome do Pet</label>
                                                                <input type="text" class="form-control" id="edit_nome_pet<?php echo $row['id']; ?>" name="nome_pet" value="<?php echo htmlspecialchars($row['nome_pet']); ?>" required>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="edit_especie_pet<?php echo $row['id']; ?>" class="form-label">Espécie</label>
                                                                <input type="text" class="form-control" id="edit_especie_pet<?php echo $row['id']; ?>" name="especie_pet" value="<?php echo htmlspecialchars($row['especie_pet']); ?>" required>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="edit_raca_pet<?php echo $row['id']; ?>" class="form-label">Raça</label>
                                                                <input type="text" class="form-control" id="edit_raca_pet<?php echo $row['id']; ?>" name="raca_pet" value="<?php echo htmlspecialchars($row['raca_pet']); ?>" required>
                                                            </div>
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
                            <p>Você não tem pets cadastrados.</p>
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
                    <form id="registrationForm" action="/dogs/cad_dono_dog/cadastro_dd.php" method="POST">
                        <div class="form-group">
                            <label for="nome">Nome do Tutor:</label>
                            <input type="text" class="form-control" id="nome_tutor" name="nome_tutor" placeholder="Digite o nome" required />
                            <br />
                            <label for="endereco">Endereço do Tutor:</label>
                            <input type="text" class="form-control" id="endereco" name="endereco_tutor" placeholder="Digite o endereço" required />
                            <br />
                            <label for="especie">Espécie do Pet:</label>
                            <input type="text" class="form-control" id="especie_pet" name="especie_pet" placeholder="Digite a espécie do pet" required />
                            <br />
                            <label for="nome_pet">Nome do Pet:</label>
                            <input type="text" class="form-control" id="nome_pet" name="nome_pet" placeholder="Digite o nome" required />
                            <br />
                            <label for="raca">Raça do Pet:</label>
                            <input type="text" class="form-control" id="raca" name="raca_pet" placeholder="Digite a raça" required />
                            <br />
                        </div>
                        <button type="submit" id="submit" class="btn btn-primary">Cadastrar</button>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>

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
                    url: '/dogs/cad_dono_dog/cadastro_dd.php',
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