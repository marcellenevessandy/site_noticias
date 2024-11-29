<?php
session_start();

// Verificar se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    header('Location: index.php');
    exit();
}

include_once './config/config.php';
include_once './classes/Usuario.php';

$usuario = new Usuario($db);

// Atualizar dados do usuário
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $nome = $_POST['nome'];
    $sexo = $_POST['sexo'];
    $fone = $_POST['fone'];
    $email = $_POST['email'];

    $usuario->atualizar($id, $nome, $sexo, $fone, $email);
    header('Location: portal.php');
    exit();
}

// Obter dados do usuário para edição
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $row = $usuario->lerPorId($id);
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="./css/registrar.css">
    <title>Editar Usuário</title>
</head>

<body>
    <form method="POST">
        <div class="container">
            <div class="box">
                <h1>Editar Usuário</h1>
                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">

                <label for="nome">Nome:</label>
                <input type="text" name="nome" id="nome" value="<?php echo $row['nome']; ?>" required>
                <br><br>

                <label>Sexo:</label>
                <label for="masculino_editar">
                    <input type="radio" id="masculino_editar" name="sexo" value="M" <?php echo ($row['sexo'] === 'M') ? 'checked' : ''; ?> required> Masculino
                </label>
                <label for="feminino_editar">
                    <input type="radio" id="feminino_editar" name="sexo" value="F" <?php echo ($row['sexo'] === 'F') ? 'checked' : ''; ?> required> Feminino
                </label>
                <br><br>

                <label for="fone">Fone:</label>
                <input type="text" name="fone" id="fone" value="<?php echo $row['fone']; ?>" required>
                <br><br>

                <label for="email">Email:</label>
                <input type="email" name="email" id="email" value="<?php echo $row['email']; ?>" required>
                <br><br>

                <input type="submit" value="Atualizar">
                <br>
                <br><a style="color: white;" href="portal.php">Voltar</a>
            </div>
        </div>
    </form>
</body>

</html>