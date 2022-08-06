<?php

include('conexao.php');
$id = intval($_GET['id']); 


// nesta função vai limpar o texto da area "telefone"
function limpar_texto($str)
{
    return preg_replace("/[^0-9]/", "", $str);
}

if (count($_POST) > 0) {

    $erro = false;
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $telefone = $_POST['telefone'];
    $nascimento = $_POST['nascimento'];

    if (empty($nome)) {
        $erro = "Preencha o nome!";
    }

    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erro = "Preencha o e-mail!";
    }

    if (!empty($nascimento) || $nascimento == '') {
        $pedacos = explode('/', $nascimento);
        if (count($pedacos) == 3) {
            $nascimento = implode('-', array_reverse($pedacos));
        } else {
            $erro = "A data de nascimento deve seguir o padrão dia/mês/ano";
        }
    }

    if (!empty($telefone) || $telefone == '') {
        $telefone = limpar_texto($telefone);
        if (strlen($telefone) != 11)
            $erro = "O telefone deve ser peenchido no padrão (11) 98888-8888";
    }

    if ($erro) {
        $erro;
    } else {
        $sql_code = "UPDATE clientes
        SET nome = '$nome',
        email = '$email',
        telefone = '$telefone',
        nascimento = '$nascimento'
        WHERE id = '$id' ";

        $deu_certo = $mysqli->query($sql_code) or die($mysqli->error);
        if ($deu_certo) {
            header("Location: cliente_atualizado.html");
            unset($_POST); // aqui vai zerar a variavel
        }
    }
}

$sql_cliente = "SELECT * FROM clientes WHERE id = '$id'";
$quey_cliente = $mysqli->query($sql_cliente) or die ($mysqli->error);
$cliente = $quey_cliente->fetch_assoc();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar cliente</title>

    <link rel="stylesheet" href="./css/style.css">
</head>

<body>

    <section class="cadastro">
        <form method="POST" action="" class="formulario">

            <h2>Atualizar clientes:</h2>

            <label>Nome:</label>
            <input name="nome" type="text" placeholder="Seu nomex" value="<?php echo $cliente['nome']; ?>"><br>

            <label>E-mail:</label>
            <input name="email" type="text" placeholder="exemplo@gmail.com" value="<?php echo $cliente['email']; ?>"><br>

            <label>Telefone:</label>
            <input name="telefone" type="text" placeholder="(00) 0000-0000" value="<?php if(!empty($cliente['telefone'])) echo formatar_telefone($cliente['telefone']); ?>"><br>

            <label>Data de Nascimento:</label>
            <input name="nascimento" type="text" placeholder="10/08/1998" value="<?php if(!empty($cliente['nascimento']))  echo formatar_data($cliente['nascimento']); ?>"><br>


            <div>
                <button type="submit">Atualizar cliente</button>
                <a href="clientes.php">Lista de clientes</a>

                <p class="erroCadastro"><?php echo $erro ?></p>
            </div>


        </form>

    </section>
</body>

</html>