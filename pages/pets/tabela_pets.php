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
$stmt = $conn->prepare("SELECT id, dono_pet, especie_pet, raca_pet, nome_pet, usuario FROM pets WHERE usuario = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

// Consultar os nomes dos clientes associados ao usuário logado
$stmt = $conn->prepare("SELECT nome_cliente FROM clientes WHERE usuario = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result_clientes = $stmt->get_result();

// Gerar as opções para o select
$options = '';
if ($result_clientes->num_rows > 0) {
    while ($row = $result_clientes->fetch_assoc()) {
        $options .= "<option value=\"{$row['nome_cliente']}\">{$row['nome_cliente']}</option>";
    }
} else {
    $options = "<option value=\"\" disabled selected>Não há clientes cadastrados</option>";
}
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
                        <h4 class="my-0 fw-normal"><b><svg width="24" height="24" xmlns="http://www.w3.org/2000/svg" fill-rule="evenodd" clip-rule="evenodd">
                                    <path d="M11.954 11c3.33 0 7.057 6.123 7.632 8.716.575 2.594-.996 4.729-3.484 4.112-1.092-.271-3.252-1.307-4.102-1.291-.925.016-2.379.836-3.587 1.252-2.657.916-4.717-1.283-4.01-4.073.774-3.051 4.48-8.716 7.551-8.716zm10.793-4.39c1.188.539 1.629 2.82.894 5.27-.704 2.341-2.33 3.806-4.556 2.796-1.931-.877-2.158-3.178-.894-5.27 1.274-2.107 3.367-3.336 4.556-2.796zm-21.968.706c-1.044.729-1.06 2.996.082 5.215 1.092 2.12 2.913 3.236 4.868 1.87 1.696-1.185 1.504-3.433-.082-5.215-1.596-1.793-3.824-2.599-4.868-1.87zm15.643-7.292c1.323.251 2.321 2.428 2.182 5.062-.134 2.517-1.405 4.382-3.882 3.912-2.149-.407-2.938-2.657-2.181-5.061.761-2.421 2.559-4.164 3.881-3.913zm-10.295.058c-1.268.451-1.92 2.756-1.377 5.337.519 2.467 2.062 4.114 4.437 3.269 2.06-.732 2.494-3.077 1.377-5.336-1.125-2.276-3.169-3.721-4.437-3.27z" />
                                </svg>&nbsp;&nbsp;Pets</b></h4><br />
                        <button type="button" class="btn btn-primary btn-cadastro" data-toggle="modal" data-target="#cadastroModal">Cadastrar novo Pet</button>
                    </div>
                    <div class="card-body">
                        <?php if ($result->num_rows > 0) : ?>
                            <table id="petsTable" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Nome do Pet</th>
                                        <th>Espécie</th>
                                        <th>Raça</th>
                                        <th>Dono</th>
                                        <th>Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($row = $result->fetch_assoc()) : ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($row['nome_pet']); ?></td>
                                            <td><?php echo htmlspecialchars($row['especie_pet']); ?></td>
                                            <td><?php echo htmlspecialchars($row['raca_pet']); ?></td>
                                            <td><?php echo htmlspecialchars($row['dono_pet']); ?></td>
                                            <td>
                                                <a href="#" class="edit-pet" data-id="<?php echo $row['id']; ?>" style="text-decoration: none;" data-bs-toggle="modal" data-bs-target="#editModal<?php echo $row['id']; ?>">✏️</a>
                                                |
                                                <a href="../../cad_pet/delete_pet.php?id=<?php echo $row['id']; ?>" style="text-decoration: none;" class="delete-pet" onclick="return confirm('Tem certeza que deseja excluir?')">🗑️</a>
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
                                                        <form id="formEditPet<?php echo $row['id']; ?>" method="post" action="../../cad_pet/edita_pet.php">
                                                            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                                            <label class="form-label">Nome do Pet:</label>
                                                            <input type="text" class="form-control" id="edit_nome_pet<?php echo $row['id']; ?>" name="nome_pet" value="<?php echo ($row['nome_pet']); ?>" required>
                                                            <br />
                                                            <label class="form-label">Espécie:</label>
                                                            <input type="text" class="form-control" id="edit_especie_pet" name="especie_pet" value="<?php echo ($row['especie_pet']); ?>" required readonly>
                                                            <br />
                                                            <label class="form-label">Raça:</label>
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
                    <form id="registrationForm" action="/dogs/cad_pet/cadastro_pet.php" method="POST">
                        <div class="form-group">
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
                            <label for="raca">Raça do Pet:</label>
                            <input type="text" class="form-control" id="raca" name="raca_pet" placeholder="Digite a raça" required />
                            <br />
                            <label for="nome_pet">Nome do Pet:</label>
                            <input type="text" class="form-control" id="nome_pet" name="nome_pet" placeholder="Digite o nome" required />
                            <br />
                            <label for="dono_pet">Dono do Pet:</label>
                            <select class="form-control" id="dono_pet_select" name="dono_pet" required>
                                <!-- Opções serão preenchidas dinamicamente pelo PHP -->
                                <?php echo $options; ?>
                            </select>
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
                    url: '/dogs/cad_pet/cadastro_pet.php',
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