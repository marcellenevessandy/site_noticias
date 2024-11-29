<?php
include_once './config/config.php';
include_once './classes/Usuario.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = new Usuario($db);

    $nome = $_POST['nome'];
    $sexo = $_POST['sexo'];
    $fone = $_POST['fone'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $usuario->register($nome, $sexo, $fone, $email, $senha);
    header('Location: portal.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="./css/registrar.css">
    <link rel="shortcut icon" href="./imagens/logoClaro.png" type="image/x-icon">
    <title>Adicionar Usuário</title>
</head>

<body>

    <form method="POST">
        <div class="container">
            <div class="box">
                <h1>Adicionar Usuário</h1>

                <label for="nome">Nome:</label>
                <input type="text" id="nome" name="nome" required>
                <br><br>

                <label for="fone">Fone:</label>
                <input type="text" id="fone" name="fone" required>
                <br><br>

                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
                <br><br>

                <label for="senha">Senha:</label>
                <input type="password" id="senha" name="senha" required>
                <br><br>

                <label>Sexo:</label><br>
                <label for="masculino">
                    <input type="radio" id="masculino" name="sexo" value="M" required> Masculino
                </label>
                <label for="feminino">
                    <input type="radio" id="feminino" name="sexo" value="F" required> Feminino
                </label>
                <br><br>

                <input type="submit" value="Adicionar">
                <br>
                <br><a style="color: white;" href="portal.php">Voltar</a>
            </div>
        </div>
    </form>

</body>

</html>