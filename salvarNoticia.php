<?php
session_start();
include_once './config/config.php';
require_once "./classes/Noticia.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verificar se o usuário está logado
    if (!isset($_SESSION['usuario_id'])) {
        die("Você precisa estar logado para adicionar uma notícia.");
    }

    // Coletar dados do formulário
    $titulo = $_POST['titulo'];
    $autor = $_SESSION['usuario_id'];
    $conteudo = $_POST['conteudo'];
    $data_publicacao = $_POST['data_publicacao'];
    //print_r($_FILES);
    $imagem = $_FILES['imagem'];

    // Validações do upload da imagem
    $nomeImagem = "";
    if ($imagem['error'] === UPLOAD_ERR_OK) {
        $extensao = strtolower(pathinfo($imagem['name'], PATHINFO_EXTENSION));
        $tamanhoMaximo = 10 * 1024 * 1024; // 10 MB

        // Validar tipo de arquivo
        $tiposPermitidos = ['jpg', 'jpeg', 'png'];
        if (!in_array($extensao, $tiposPermitidos)) {
            die("Apenas arquivos JPG ou PNG são permitidos.");
        }

        // Validar tamanho do arquivo
        if ($imagem['size'] > $tamanhoMaximo) {
            die("O tamanho do arquivo não pode exceder 10 MB.");
        }

        // Gerar nome único para o arquivo
        $nomeImagem = uniqid() . "." . $extensao;
        $destino = "uploads/" . $nomeImagem;

        // Mover o arquivo para o diretório
        if (!move_uploaded_file($imagem['tmp_name'], $destino)) {
            die("Erro ao salvar a imagem.");
        }
    } else if ($imagem['error'] !== UPLOAD_ERR_NO_FILE) {
        die("Erro ao fazer upload da imagem.");
    }

    // Instanciar o objeto de Notícia
    $noticiaObj = new Noticia($db);

    // Salvar a notícia no banco de dados
    $resultado = $noticiaObj->salvar($titulo, $conteudo, $nomeImagem, $data_publicacao, $autor);
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="./imagens/logoClaro.png" type="image/x-icon">
    <title>Adicionar Notícia</title>
    <link rel="stylesheet" href="./css/registrar.css">
</head>

<body>

    <div class="container">
        <div class="box">
            <h1>Adicionar Notícia</h1>
            <form method="POST" enctype="multipart/form-data">

                <label for="titulo">Título:</label>
                <input type="text" id="titulo" name="titulo" required><br><br>

                <label for="conteudo">Conteúdo:</label><br>
                <input id="conteudo" type="text" name="conteudo" required></input><br><br>

                <label for="data_publicacao">Data de Publicação:</label><br>
                <input type="date" id="data_publicacao" name="data_publicacao" required><br><br>

                <label for="imagem">Imagem:</label>
                <input type="file" id="imagem" name="imagem" accept="image/jpg, image/jpeg, image/png" required>
                <span id="file-name">Nenhum arquivo escolhido</span><br>


                <input type="submit" value="Salvar">
                <br>
                <br><a style="color: white;" href="portal.php">Voltar</a>
            </form>
        </div>
    </div>
    <script src="./script/imagem.js"></script>
    <script src="./script/script.js"></script>
</body>

</html>