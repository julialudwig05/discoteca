<?php
if (isset($_GET['disco_ID'])) {
    // Conexão com o bd
    $db = new mysqli("localhost", "root", "", "discoteca");
    // Verifica se a conexão foi bem sucedida
    if ($db->connect_error) {
        die("Conexão falhou: " . $db->connect_error);
    }
    // Prepara a consulta para evitar SQL Injection
    $stmt = $db->prepare("DELETE FROM disco WHERE disco_ID = ?");
    $stmt->bind_param("i", $_GET['disco_ID']);
    // Executa a consulta e verifica o sucesso
    if ($stmt->execute()) {
        // Redireciona para a página de discos após a exclusão bem sucedida
        header("Location: indexDisco.php");
        exit();
    } else {
        // Exibe uma mensagem de erro se a exclusão falhar
        echo "Erro: " . $stmt->error;
    }
    // Fecha a conexão com o bd
    $stmt->close();
    $db->close();
} else {
    // Caso o parametro 'disco_ID' não esteja presente, redireciona para a página de discos
    header("Location: indexDisco.php");
    exit();
}
?>
