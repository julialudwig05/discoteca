<?php
// Verifica se a requisição é do tipo POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Conexão com o bd
    $db = new mysqli("localhost", "root", "", "discoteca");
    // Verifica se a conexão foi bem sucedida
    if ($db->connect_error) {
        die("Conexão falhou: " . $db->connect_error);
    }
    // Prepara a consulta para evitar SQL Injection
    $stmt = $db->prepare("UPDATE artista SET nome = ? WHERE artista_ID = ?");
    $stmt->bind_param("si", $_POST['nome'], $_POST['artista_ID']);
    // Executa a consulta e verifica o sucesso
    if ($stmt->execute()) {
        // Redireciona para a página de artistas após a atualização bem sucedida
        header("Location: indexArtista.php");
        exit();
    } else {
        // Exibe uma mensagem de erro se a atualização falhar
        echo "Erro: " . $stmt->error;
    }
    // Fecha a conexão com o bd
    $stmt->close();
    $db->close();
} else {
    // Caso não seja uma requisição POST, redireciona para a página de artistas
    header("Location: indexArtista.php");
    exit();
}
?>
