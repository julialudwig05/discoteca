<?php
// Verifica se o parametro artista_ID esta presente e é um número válido
if (isset($_GET['artista_ID']) && is_numeric($_GET['artista_ID'])) {
    // Conexão com o bd
    $db = new mysqli("localhost", "root", "", "discoteca");
    // Verifica se a conexão foi bem sucedida
    if ($db->connect_error) {
        die("Conexão falhou: " . $db->connect_error);
    }
    // Inicia uma transação para garantir a integridade dos dados
    $db->begin_transaction();
    try {
        // Exclui os discos associados ao artista
        $stmt = $db->prepare("DELETE FROM disco WHERE artista_ID = ?");
        $stmt->bind_param("i", $_GET['artista_ID']);
        $stmt->execute();
        $stmt->close();
        // Exclui o artista
        $stmt = $db->prepare("DELETE FROM artista WHERE artista_ID = ?");
        $stmt->bind_param("i", $_GET['artista_ID']);
        $stmt->execute();
        $stmt->close();
        // Confirma a transação
        $db->commit();
        // Redireciona para a página de artistas após a exclusão bem sucedida
        header("Location: indexArtista.php");
        exit();
    } catch (Exception $e) {
        // Reverte a transação em caso de erro
        $db->rollback();
        echo "Erro: " . $e->getMessage();
    }
    // Fecha a conexão com o bd
    $db->close();
} else {
    // Caso o parametro artista_ID não esteja presente ou não seja válido, redireciona para a página de artistas
    header("Location: indexArtista.php");
    exit();
}
?>
