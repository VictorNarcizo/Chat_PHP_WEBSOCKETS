<?php
session_start();

ob_start();
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>

<body>
    <h1>Acessar o chat</h1>

    <?php
    $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

    if (!empty($dados['acessar'])) {
        $_SESSION['usuario'] = $dados['usuario'];

        header("Location: chat.php");
    }
    ?>

    <form action="" method="post">
        <label for="">Nome</label>
        <input type="text" name="usuario" placeholder="Digite seu nome...">
        <br><br>
        <input type="submit" name="acessar" value="Acessar">
        <br><br>
    </form>
</body>

</html>