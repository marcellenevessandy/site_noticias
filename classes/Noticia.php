<?php
class Noticia
{
    private $conn;
    private $table_name = "noticias";

    // Construtor recebe a conexão do banco de dados
    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function lerComNomeDeAutor()
    {
        $query = "
                SELECT n.id, n.titulo, n.conteudo, n.imagem, n.data_publicacao, u.nome 
                FROM noticias n
                JOIN usuarios u ON n.usuario_id = u.id
            ";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Método para criar uma nova notícia associada a um usuário
    public function salvar($titulo, $conteudo, $imagem, $data_publicacao, $usuario_id)
    {


        // Preparar e executar a query para salvar a notícia
        try {
            $query = "INSERT INTO " . $this->table_name . " (titulo, conteudo, imagem, data_publicacao, usuario_id) 
                      VALUES (?, ?, ?, ?, ?)";
            $stmt = $this->conn->prepare($query);
            $stmt->execute([$titulo, $conteudo, $imagem, $data_publicacao, $usuario_id]);
            return true;
        } catch (PDOException $e) {
            // Em caso de erro na execução da query, retorna o erro
            return "Erro: " . $e->getMessage();
        }
    }

    // Método para ler todas as notícias
    public function ler()
    {
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY data_publicacao DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Método para ler uma notícia específica pelo ID
    public function lerPorId($id)
    {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function atualizar($id, $titulo, $conteudo, $imagem, $data_publicacao)
    {
        // Verificar se há imagem e processá-la
        if ($imagem['error'] === UPLOAD_ERR_OK) {
            $extensao = strtolower(pathinfo($imagem['name'], PATHINFO_EXTENSION));
            $tiposPermitidos = ['jpg', 'jpeg', 'png'];
            if (!in_array($extensao, $tiposPermitidos)) {
                return "Erro: O tipo de arquivo não é permitido. Apenas JPG, JPEG e PNG são aceitos.";
            }

            // Validar tamanho do arquivo (máximo de 10MB)
            $tamanhoMaximo = 10 * 1024 * 1024; // 10 MB
            if ($imagem['size'] > $tamanhoMaximo) {
                return "Erro: O tamanho da imagem excede o limite de 10MB.";
            }

            // Gerar nome único para a imagem
            $nomeImagem = uniqid() . "." . $extensao;
            $destino = "uploads/" . $nomeImagem;
            if (!move_uploaded_file($imagem['tmp_name'], $destino)) {
                return "Erro ao salvar a imagem.";
            }
        } else {
            $nomeImagem = null; // Caso não haja imagem, podemos armazenar como null
        }

        // Atualizar a notícia no banco de dados
        try {
            $query = "UPDATE " . $this->table_name . " SET titulo = ?, conteudo = ?, imagem = ?, data_publicacao = ? WHERE id = ?";
            $stmt = $this->conn->prepare($query);
            $stmt->execute([$titulo, $conteudo, $nomeImagem, $data_publicacao, $id]);

            return true; // Retorna true quando a atualização for bem-sucedida
        } catch (PDOException $e) {
            return "Erro ao atualizar a notícia: " . $e->getMessage(); // Retorna a mensagem de erro em caso de falha
        }
    }

    // Método para deletar uma notícia pelo ID
    public function deletar($id)
    {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$id]);
        return $stmt;
    }

    // Método para listar todas as notícias de um usuário específico
    public function listarPorUsuario($usuario_id)
    {
        $query = "SELECT * FROM " . $this->table_name . " WHERE usuario_id = ? ORDER BY data_publicacao DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$usuario_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
