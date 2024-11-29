<?php
session_start();
include_once './config/config.php';
include_once './classes/Usuario.php';
$usuario = new Usuario($db);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['login'])) {
        // Processar login
        $email = $_POST['email'];
        $senha = $_POST['senha'];

        if ($dados_usuario = $usuario->login($email, $senha)) {
            $_SESSION['usuario_id'] = $dados_usuario['id'];
            header('Location: portal.php');
            exit();
        } else {
            $mensagem_erro = "Credenciais inválidas!";
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="./css/login.css">
    <link rel="shortcut icon" href="./imagens/logoClaro.png" type="image/x-icon">
    <title>Login</title>
</head>
<body>
    <div class="container">
        <div class="box">
            <h1>LOGIN</h1>
            <form method="POST">
                <input type="email" name="email" placeholder="Usuário:" required>
                <br><br>
                <input type="password" name="senha" placeholder="Senha:" required>
                <br><br>
                <input type="submit" name="login" value="Entrar">
            </form>
            <br>
            <p><a href="./registrar.php">Registre-se</a></p>
            <div class="mensagem">
                <?php if (isset($mensagem_erro)) echo '<p>' . $mensagem_erro . '</p>'; ?>
            </div>
        </div>
    </div>
</body>
</html>
