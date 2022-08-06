<?php 
if(isset($_POST['confirmar'])) {

    include('conexao.php');
    $id = intval($_GET['id']);
    $sql_code = "DELETE FROM clientes WHERE id = '$id' ";
    $sql_query = $mysqli->query($sql_code) or die($mysqli->error);

    if($sql_query) {
        header("Location: cliente_deletado.php");
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Deletar Cliente</title>
</head>

<body>
    <form action="" method="POST">
        <h1>Tem certeza que deseja deletar este cliente</h1>
        <button name="confirmar" value="1" type="submit">Sim</button>
        <a href="clientes.php">Não</a>
    </form>
</body>

</html>