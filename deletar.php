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

// Verificar se o ID foi fornecido na URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $usuario->deletar($id); // Chama o método deletar para excluir o usuário
    header('Location: portal.php'); // Redireciona para o portal após a exclusão
    exit();
}
?>
