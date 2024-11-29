<?php
session_start();
include_once './config/config.php';
include_once './classes/Noticia.php';
include_once './classes/usuario.php';

//Verificar se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit();
}

// Instância da classe Noticia
$noticia = new Noticia($db);

// Obter todas as notícias
$dados = $noticia->ler();

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="./imagens/logoClaro.png" type="image/x-icon">
    <title>Portal de Notícias</title>
    <link rel="stylesheet" href="./css/portal.css">
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
            <br>

            <div class="login-button">
                <button class="btn-contato" onclick="location.href='logout.php'">SAIR</button>
            </div>


        </div>

    </header>

    <main>
    <?php while ($row = $dados->fetch(PDO::FETCH_ASSOC)) : ?>
        <?php
        $usuario = new Usuario($db);
        $infoUsu = $usuario->lerPorId($row['usuario_id']);
        ?>
        <div id="noticia">
            <div id="foto">
                <img src="./uploads/<?php echo $row['imagem']; ?>" alt="Imagem da notícia">
            </div>
            <div id="info">
                <h1><?php echo htmlspecialchars($row['titulo']); ?></h1>
                <p><?php echo htmlspecialchars($row['conteudo']); ?></p>
                <p><strong>Por:</strong> <?php echo htmlspecialchars($infoUsu['nome']); ?></p>
                <p><strong>Data:</strong> <?php echo htmlspecialchars($row['data_publicacao']); ?></p>
            </div>
        </div>
    <?php endwhile; ?>
</main>

</body>
<script src="./script/script.js"></script>
</html>