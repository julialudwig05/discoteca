<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Conexão com o bd
    $db = new mysqli("localhost", "root", "", "discoteca");
    // Verifica se a conexão foi bem sucedida
    if ($db->connect_error) {
        die("Conexão falhou: " . $db->connect_error);
    }
    // Sanitização e validação dos dados do formulário
    $emprestimo_ID = intval($_POST['emprestimo_ID']);
    // Query para deletar o empréstimo
    $query = "DELETE FROM emprestimo WHERE emprestimo_ID = ?";
    if ($stmt = $db->prepare($query)) {
        $stmt->bind_param("i", $emprestimo_ID); // 'i' indica um número inteiro
        if ($stmt->execute()) {
            // Redireciona para a lista de empréstimos após a exclusão
            header("Location: indexEmprestimo.php");
            exit();
        } else {
            echo "<p>Erro ao excluir o empréstimo: " . htmlspecialchars($stmt->error) . "</p>";
        }
        $stmt->close();
    } else {
        echo "<p>Erro ao preparar a consulta: " . htmlspecialchars($db->error) . "</p>";
    }
    // Fecha a conexão com o bd
    $db->close();
} else {
    // Caso não seja uma requisição POST, redireciona para o formulário
    header("Location: form_devolver.php");
    exit();
}
?>
