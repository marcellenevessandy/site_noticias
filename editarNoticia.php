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

// Verificar se um ID foi passado para edição
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $noticia = $noticiaObj->lerPorId($id);

    if (!$noticia) {
        echo "Notícia não encontrada!";
        exit();
    }
} else {
    header('Location: gerenciarNoticias.php');
    exit();
}

// Processar o formulário de atualização
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = $_POST['titulo'];
    $conteudo = $_POST['conteudo'];
    $data_publicacao = $_POST['data_publicacao'];
    $imagem = $_FILES['imagem']; // Campo de upload de imagem

    // Atualizar a notícia no banco
    $resultado = $noticiaObj->atualizar($id, $titulo, $conteudo, $imagem, $data_publicacao);

    if ($resultado === true) {
        echo "Notícia atualizada com sucesso!";
        header('Location: gerenciarNoticias.php');
        exit();
    } else {
        echo $resultado; // Exibir erro, caso ocorra
    }
}

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/registrar.css">
    <title>Editar Notícia</title>
</head>

<body>

    <main>
        <form method="POST" enctype="multipart/form-data">
            <div class="container">
                <div class="box">
                    <h1>Editar Notícia</h1>

                    <label for="titulo">Título:</label>
                    <input type="text" id="titulo" name="titulo" value="<?php echo htmlspecialchars($noticia['titulo']); ?>" required>

                    <label for="conteudo">Conteúdo:</label>
                    <input id="conteudo" type="text" name="conteudo" value="<?php echo htmlspecialchars($noticia['conteudo']); ?>" required><br><br>

                    <label for="data_publicacao">Data de Publicação:</label>
                    <input type="date" id="data_publicacao" name="data_publicacao" value="<?php echo htmlspecialchars($noticia['data_publicacao']); ?>" required>
                    <br><br>

                    <label for="imagem">Imagem:</label><br><br>
                    <input type="file" id="imagem" name="imagem" accept="image/jpg, image/jpeg, image/png">
                    <span id="file-name"><?php echo htmlspecialchars($noticia['imagem']); ?></span><br><br>

                    <input type="submit" value="Salvar">
                    <br>
                    <br><a style="color: white;" href="portal.php">Voltar</a>
                </div>
                <script src="./script/imagem.js"></script>
            </div>
        </form>
    </main>
</body>

</html>
