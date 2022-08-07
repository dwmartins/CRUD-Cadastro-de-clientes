<?php

include('conexao.php');

$sql_clientes = "SELECT * FROM clientes";
$query_clientes = $mysqli->query($sql_clientes) or die($mysqli->error);
$num_clientes = $query_clientes->num_rows;

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Clientes</title>

    <link rel="stylesheet" href="./css/style.css">
</head>

<body>

    <section class="listaClientes">
        <div class="tabela">
            <div class="title-tabela">
                <h1>Lista de Clientes:</h1>
                <p>Estes são os clientes cadastrado no seu sistema:</p>

                <a href="cadastrar_cliente.php">Cadastrar novo cliente</a>
            </div>

            <div class="div_table">
                <table>
                    <thead>
                        <th>Id</th>
                        <th>Nome</th>
                        <th>E-mail</th>
                        <th>Telefone</th>
                        <th>Nascimento</th>
                        <th>Data de cadastro</th>
                        <th>Ações</th>
                    </thead>

                    <tbody>

                        <?php
                        if ($num_clientes == 0) { ?>

                            <tr>
                                <td colspan="6">Nenhum cliente foi cadastrado</td>
                            </tr>

                            <?php
                        } else {
                            while ($cliente = $query_clientes->fetch_assoc()) {

                                $telefone = "Não informado";
                                if (!empty($cliente['telefone'])) {
                                    $telefone = formatar_telefone($cliente['telefone']);
                                }

                                $nascimento = "Não informado";
                                if (!empty($cliente['nascimento'])) {
                                    $nascimento = formatar_data($cliente['nascimento']);
                                }

                                $data_cadastro = date("d/m/y H:i", strtotime($cliente['data']));
                            ?>
                                <tr>
                                    <td align="center"><?php echo $cliente['id'] ?></td>
                                    <td><?php echo $cliente['nome'] ?></td>
                                    <td><?php echo $cliente['email'] ?></td>
                                    <td align="center"><?php echo $telefone ?></td>
                                    <td align="center"><?php echo $nascimento ?></td>
                                    <td align="center"><?php echo $data_cadastro ?></td>
                                    <td class="btnS">
                                        <a class="btn_editar" href="editar_cliente.php?id=<?php echo $cliente['id']; ?>">Editar</a>

                                        <a class="btn_deletar" href="deletar_cliente.php?id=<?php echo $cliente['id']; ?>">Deletar</a>
                                    </td>
                                </tr>
                        <?php
                            }
                        } ?>


                    </tbody>
                </table>
            </div>

        </div>
    </section>
</body>

</html>