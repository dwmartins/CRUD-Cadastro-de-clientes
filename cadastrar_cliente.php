<?php

// nesta função vai limpar o texto da area "telefone"
function limpar_texto($str)
{
    return preg_replace("/[^0-9]/", "", $str);
}

if (count($_POST) > 0) {

    include('conexao.php');

    $erro = false;
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $telefone = $_POST['telefone'];
    $nascimento = $_POST['nascimento'];

    if (empty($nome)) {
        $erro = "Preencha o nome";
    }

    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erro = "Preencha o e-mail";
    }

    if (!empty($nascimento)) {
        $pedacos = explode('/', $nascimento);
        if (count($pedacos) == 3) {
            $nascimento = implode('-', array_reverse($pedacos));
        } else {
            $erro = "A data de nascimento deve seguir o padrão dia/mês/ano";
        }
    }

    if (!empty($telefone)) {
        $telefone = limpar_texto($telefone);
        if (strlen($telefone) != 11) {
            $erro = "O telefone deve ser peenchido no padrão (11) 98888-8888";
        }
    }

    if ($erro) {
        echo "<p><b>Erro: $erro <b></p>";
    } else {
        $sql_code = "INSERT INTO clientes (nome, email, telefone, nascimento, data)
        VALUES ('$nome', '$email', '$telefone', '$nascimento', NOW())";
        $deu_certo = $mysqli->query($sql_code) or die($mysqli->error);
        if($deu_certo) {
            echo "<p><b>Cliente cadastrado com sucesso!<b></p>";
            unset($_POST); // aqui vai zerar a variavel
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar cliente</title>
</head>

<body>

    <br><br>
    <a href="#">voltar para a lista</a>

    <form method="POST" action="">

        <label>Nome:</label>
        <input name="nome" type="text" value="<?php if (isset($_POST['nome'])) echo $_POST['nome']; ?>"><br>

        <label>Email:</label>
        <input name="email" type="text" value="<?php if (isset($_POST['email'])) echo $_POST['email']; ?>"><br>

        <label>Telefone:</label>
        <input name="telefone" type="text" placeholder="(00) 0000-0000" value="<?php if (isset($_POST['telefone'])) echo $_POST['telefone']; ?>"><br>

        <label>Data de Nascimento:</label>
        <input name="nascimento" type="text" value="<?php if (isset($_POST['nascimento'])) echo $_POST['nascimento']; ?>"><br>

        <button type="submit">Salvar Cliente</button>


    </form>

</body>

</html>