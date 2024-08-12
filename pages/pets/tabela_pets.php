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

        .modal-body .form-label {
        text-align: left;
        display: block;
        margin-bottom: 0.5rem;
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
                        <h4 class="my-0 fw-normal"><b><svg xmlns="http://www.w3.org/2000/svg" width="27" height="27" fill="currentColor" class="bi bi-github" viewBox="0 0 16 16">
                                    <path d="M8 0C3.58 0 0 3.58 0 8c0 3.54 2.29 6.53 5.47 7.59.4.07.55-.17.55-.38 0-.19-.01-.82-.01-1.49-2.01.37-2.53-.49-2.69-.94-.09-.23-.48-.94-.82-1.13-.28-.15-.68-.52-.01-.53.63-.01 1.08.58 1.23.82.72 1.21 1.87.87 2.33.66.07-.52.28-.87.51-1.07-1.78-.2-3.64-.89-3.64-3.95 0-.87.31-1.59.82-2.15-.08-.2-.36-1.02.08-2.12 0 0 .67-.21 2.2.82.64-.18 1.32-.27 2-.27s1.36.09 2 .27c1.53-1.04 2.2-.82 2.2-.82.44 1.1.16 1.92.08 2.12.51.56.82 1.27.82 2.15 0 3.07-1.87 3.75-3.65 3.95.29.25.54.73.54 1.48 0 1.07-.01 1.93-.01 2.2 0 .21.15.46.55.38A8.01 8.01 0 0 0 16 8c0-4.42-3.58-8-8-8" />
                                </svg>&nbsp;&nbsp;Pets</b></h4><br />
                        <button type="button" class="btn btn-primary btn-cadastro" data-toggle="modal" data-target="#cadastroModal">Cadastrar novo Pet</button>
                    </div>
                    <div class="card-body">
                        <?php if ($result->num_rows > 0) : ?>
                            <table id="petsTable" class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Tutor</th>
                                        <th>Endereço Tutor</th>
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
                                            <td><?php echo htmlspecialchars($row['endereco_tutor']); ?></td>
                                            <td><?php echo htmlspecialchars($row['nome_pet']); ?></td>
                                            <td><?php echo htmlspecialchars($row['especie_pet']); ?></td>
                                            <td><?php echo htmlspecialchars($row['raca_pet']); ?></td>
                                            <td>
                                                <a href="#" class="edit-pet" data-id="<?php echo $row['id']; ?>" style="text-decoration: none;" data-bs-toggle="modal" data-bs-target="#editModal<?php echo $row['id']; ?>">✏️</a>
                                                |
                                                <a href="../../cad_dono_dog/delete_dd.php?id=<?php echo $row['id']; ?>" style="text-decoration: none;" class="delete-pet" onclick="return confirm('Tem certeza que deseja excluir?')">🗑️</a>
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
                                                        <form id="formEditPet<?php echo $row['id']; ?>" method="post" action="../../cad_dono_dog/edita_dd.php">
                                                            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                                                <label class="form-label">Nome do Tutor</label>
                                                                <input type="text" class="form-control" id="edit_nome_tutor<?php echo $row['id']; ?>" name="nome_tutor" value="<?php echo ($row['nome_tutor']); ?>" required>
                                                                <br />
                                                                <label class="form-label">Endereço do Tutor</label>
                                                                <input type="text" class="form-control" id="edit_endereco_tutor<?php echo $row['id']; ?>" name="endereco_tutor" value="<?php echo ($row['endereco_tutor']); ?>" required>
                                                                <br />
                                                                <label class="form-label">Nome do Pet</label>
                                                                <input type="text" class="form-control" id="edit_nome_pet<?php echo $row['id']; ?>" name="nome_pet" value="<?php echo ($row['nome_pet']); ?>" required>
                                                                <br />
                                                                <label class="form-label">Espécie</label>
                                                                <input type="text" class="form-control" id="edit_especie_pet" name="especie_pet" value="<?php echo ($row['especie_pet']); ?>" required readonly>
                                                                <br />
                                                                <label class="form-label">Raça</label>
                                                                <input type="text" class="form-control" id="edit_raca_pet" name="raca_pet" value="<?php echo ($row['raca_pet']); ?>" required readonly>
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
                            <select class="form-control" id="especie_pet_select" name="especie_pet_select" required onchange="toggleEspecieInput(this)">
                                <option value="" disabled selected>Selecione a espécie</option>
                                <option value="Cachorro">Cachorro</option>
                                <option value="Gato">Gato</option>
                                <option value="Outra">Outra</option>
                            </select>
                            <!-- Campo adicional para nova espécie -->
                            <input type="text" class="form-control" id="especie_pet" name="especie_pet" placeholder="Digite a espécie do pet" style="display:none;" />
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

    <script>
        function toggleEspecieInput(select) {
            const input = document.getElementById('especie_pet');
            if (select.value === 'Outra') {
                input.style.display = 'block';
                input.required = true;
            } else {
                input.style.display = 'none';
                input.required = false;
                input.value = ''; // Reseta o valor do input caso volte a escolher outra opção
            }
        }
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