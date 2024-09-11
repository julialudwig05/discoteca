<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Conexão com o bd
    $db = new mysqli("localhost", "root", "", "discoteca");
    // Verifica se a conexão foi bem sucedida
    if ($db->connect_error) {
        die("Conexão falhou: " . $db->connect_error);
    }
    // Sanitização e validação dos dados do formulário
    $disco_ID = intval($_POST['disco_ID']);
    $nome_cliente = trim($_POST['nome_cliente']);
    $email_cliente = trim($_POST['email_cliente']);
    $data_emprestimo = $_POST['data_emprestimo'];
    // Validação do nome e e-mail do cliente
    if (empty($nome_cliente)) {
        die("Nome do cliente é obrigatório.");
    }
    if (empty($email_cliente) || !filter_var($email_cliente, FILTER_VALIDATE_EMAIL)) {
        die("E-mail inválido.");
    }
    // Verifica se o disco já está emprestado
    $queryVerifica = "SELECT COUNT(*) as total FROM emprestimo WHERE disco_ID = ? AND data_devolucao IS NULL";
    if ($stmt = $db->prepare($queryVerifica)) {
        $stmt->bind_param("i", $disco_ID);
        $stmt->execute();
        $stmt->bind_result($total);
        $stmt->fetch();
        $stmt->close();
        if ($total > 0) {
            die("Este disco já está emprestado e não pode ser registrado novamente.");
        }
    } else {
        die("Erro ao verificar o disco: " . htmlspecialchars($db->error));
    }
    // Query para inserir um novo empréstimo
    $query = "INSERT INTO emprestimo (disco_ID, nome_cliente, email_cliente, data_emprestimo) VALUES (?, ?, ?, ?)";
    if ($stmt = $db->prepare($query)) {
        $stmt->bind_param("isss", $disco_ID, $nome_cliente, $email_cliente, $data_emprestimo);
        if ($stmt->execute()) {
            // Redireciona para a lista de empréstimos após o sucesso
            header("Location: indexEmprestimo.php");
            exit();
        } else {
            echo "<p>Erro ao registrar o empréstimo: " . htmlspecialchars($stmt->error) . "</p>";
        }
        $stmt->close();
    } else {
        echo "<p>Erro ao preparar a consulta: " . htmlspecialchars($db->error) . "</p>";
    }
    // Fecha a conexão com o bd
    $db->close();
} else {
    // Caso não seja uma requisição POST, redireciona para a página de empréstimos
    header("Location: indexEmprestimo.php");
    exit();
}
?>