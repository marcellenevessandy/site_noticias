<?php
session_start();
include_once './config/config.php';
require_once "./classes/Noticia.php";

// Verificar se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    header('Location: index.php');
    exit();
}

$noticiaObj = new Noticia($db);

// Processar exclusão de notícia
if (isset($_GET['deletar'])) {
    $id = $_GET['deletar'];
    $noticiaObj->deletar($id);
    header('Location: gerenciarNoticias.php');
    exit();
}

// Obter dados de todas as notícias
$dados = $noticiaObj->ler();

// Função para buscar o nome do usuário baseado no usuario_id
function getNomeUsuario($usuario_id, $db) {
    $query = "SELECT nome FROM usuarios WHERE id = :usuario_id";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':usuario_id', $usuario_id, PDO::PARAM_INT);
    $stmt->execute();
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
    
    // Verificar se o usuário foi encontrado
    if ($usuario) {
        return $usuario['nome'];
    } else {
        return 'Usuário não encontrado';  // Retorna uma mensagem caso o usuário não seja encontrado
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="./imagens/logoClaro.png" type="image/x-icon">
    <link rel="stylesheet" href="./css/portal.css">
    <title>Gerenciar Notícias</title>
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
                    <li class="nav-item"><a href="salvarNoticia.php" class="nav-link">Gerenciar Noticias</a></li>
                </ul>
            </div>

            <div class="login-button">
                <a href="logout.php"><button>SAIR</button></a>
            </div>

            <div class="mobile-menu-icon">
                <button onclick="menuShow()"><img class="icon" src="./assets/img/menu.png" alt="logo menu"></button>
            </div>

        </nav>
        <div class="mobile-menu">
            <ul>
                <li class="nav-item"><a href="portal.php" class="nav-link">Home</a></li>
                <li class="nav-item"><a href="registrar.php" class="nav-link">Cadastrar Usuários</a></li>
                <li class="nav-item"><a href="salvarNoticia.php" class="nav-link">Cadastrar Noticias</a></li>
                <li class="nav-item"><a href="gerenciarUsuarios.php" class="nav-link">Gerenciar Usuários</a></li>
                <li class="nav-item"><a href="salvarNoticia.php" class="nav-link">Gerenciar Noticias</a></li>
            </ul>

            <div class="login-button">
                <button class="btn-contato" onclick="location.href='logout.php'">SAIR</button>
            </div>


        </div>

    </header>

<section class="sessao1">
    <table border="1">
        <tr>
            <th>Título</th>
            <th>Conteudo</th>
            <th>Imagem</th>
            <th>Data de Publicação</th>
            <th>Autor</th>
            <th>Ações</th>
        </tr>
        <?php while ($row = $dados->fetch(PDO::FETCH_ASSOC)) : ?>
            <tr>
                <td><?php echo $row['titulo']; ?></td>
                <td><?php echo $row['conteudo']; ?></td>
                <td><img id="imagemTabela" src="./uploads/<?php echo $row['imagem']; ?>" alt="Imagem da notícia"></td>
                <td><?php echo $row['data_publicacao']; ?></td>
                
                <!-- Buscando o nome do autor com base no usuario_id -->
                <td>
                    <?php 
                        $nomeAutor = getNomeUsuario($row['usuario_id'], $db); 
                        echo $nomeAutor; 
                    ?>
                </td>

                <td>
                    <a href="editarNoticia.php?id=<?php echo $row['id']; ?>">Editar</a>
                    <a href="gerenciarNoticias.php?deletar=<?php echo $row['id']; ?>">Deletar</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
</section>
</body>
<script src="./script/script.js"></script>
</html>
