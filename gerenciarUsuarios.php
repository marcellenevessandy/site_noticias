<?php
session_start();
include_once './config/config.php';
include_once './classes/Usuario.php';

// Verificar se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    header('Location: index.php');
    exit();
}

$usuario = new Usuario($db);

// Processar exclusão de usuário
if (isset($_GET['deletar'])) {
    $id = $_GET['deletar'];
    $usuario->deletar($id);
    header('Location: portal.php');
    exit();
}

// Obter dados do usuário logado
$dados_usuario = $usuario->lerPorId($_SESSION['usuario_id']);
$nome_usuario = $dados_usuario['nome'];

// Obter dados dos usuários
$dados = $usuario->ler();

// Função para determinar a saudação
function saudacao()
{
    $hora = date('H');
    if ($hora >= 6 && $hora < 12) {
        return "Bom dia";
    } elseif ($hora >= 12 && $hora < 18) {
        return "Boa tarde";
    } else {
        return "Boa noite";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="./css/portal.css">
    <title>Portal</title>
</head>

<body>

    <header>
        <nav class="nav-bar">
            <div class="logo">
                <a href="./index.html"><img src="./imagens/logoClaro.png" alt="logo noticias"></a>
            </div>

            <div class="nav-list">
                <ul>
                    <li class="nav-item"><a href="portal.php" class="nav-link">Home</a></li>
                    <li class="nav-item"><a href="registrar.php" class="nav-link">Cadastrar Usuários</a></li>
                    <li class="nav-item"><a href="salvarNoticia.php" class="nav-link">Cadastrar Noticias</a></li>
                    <li class="nav-item"><a href="gerenciarUsuarios.php" class="nav-link">Gerenciar Usuários</a></li>
                    <li class="nav-item"><a href="gerenciarNoticias.php" class="nav-link">Gerenciar Noticias</a></li>
                </ul>
            </div>

            <div class="login-button">
                <a href="logout.php"><button>SAIR</button></a>
            </div>

            <div class="mobile-menu-icon">
                <button onclick="menuShow()"><img class="icon" src="./imagens/menu.png" alt="logo menu"></button>
            </div>

        </nav>
        <div class="mobile-menu">
            <ul>
                <li class="nav-item"><a href="portal.php" class="nav-link">Home</a></li>
                <li class="nav-item"><a href="registrar.php" class="nav-link">Cadastrar Usuários</a></li>
                <li class="nav-item"><a href="salvarNoticia.php" class="nav-link">Cadastrar Noticias</a></li>
                <li class="nav-item"><a href="gerenciarUsuarios.php" class="nav-link">Gerenciar Usuários</a></li>
                <li class="nav-item"><a href="gerenciarNoticias.php" class="nav-link">Gerenciar Noticias</a></li>
            </ul>

            <div class="login-button">
                <button class="btn-contato" onclick="location.href='logout.php'">SAIR</button>
            </div>


        </div>

    </header>

    <section class="sessao1">
        <!-- <h1><?php echo saudacao() . ", " . $nome_usuario; ?>!</h1> -->

        <br><br>
        <table border="1">
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Sexo</th>
                <th>Fone</th>
                <th>Email</th>
                <th>Ações</th>
            </tr>
            <?php while ($row = $dados->fetch(PDO::FETCH_ASSOC)) : ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['nome']; ?></td>
                    <td><?php echo ($row['sexo'] === 'M') ? 'Masculino' : 'Feminino'; ?></td>
                    <td><?php echo $row['fone']; ?></td>
                    <td><?php echo $row['email']; ?></td>
                    <td>
                        <a href="editar.php?id=<?php echo $row['id']; ?>">Editar</a>
                        <a href="portal.php?deletar=<?php echo $row['id']; ?>">Deletar</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>
    </section>
    <script src="./script/script.js"></script>
</body>

</html>