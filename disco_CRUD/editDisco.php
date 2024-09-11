<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verifica se o parametro disco_ID está presente na URL e no POST
    if (isset($_POST['disco_ID'])) {
        // Conexão com o bd
        $db = new mysqli("localhost", "root", "", "discoteca");
        // Verifica se a conexão foi bem sucedida
        if ($db->connect_error) {
            die("Conexão falhou: " . $db->connect_error);
        }
        // Obtém os dados do formulário
        $disco_ID = intval($_POST['disco_ID']);
        $titulo = $_POST['titulo'] ?? '';
        $ano = $_POST['ano'] ?? '';
        $foto_capa = null;
        // Verifica se um arquivo foi enviado e é válido
        if (isset($_FILES['foto_capa']) && $_FILES['foto_capa']['error'] === UPLOAD_ERR_OK) {
            $extensao = strtolower(pathinfo($_FILES['foto_capa']['name'], PATHINFO_EXTENSION));
            $extensoesPermitidas = ['jpg', 'jpeg', 'png', 'gif'];
            if (in_array($extensao, $extensoesPermitidas)) {
                $diretorioDestino = "../arquivos/";
                $destinoArquivo = $diretorioDestino . basename($_FILES['foto_capa']['name']);
                if (move_uploaded_file($_FILES['foto_capa']['tmp_name'], $destinoArquivo)) {
                    $foto_capa = $destinoArquivo;
                } else {
                    die("Erro ao mover o arquivo para o diretório de destino.");
                }
            } else {
                die("Tipo de arquivo não permitido. Somente JPG, JPEG, PNG e GIF são aceitos.");
            }
        }
        // Prepara a consulta para evitar SQL Injection
        $query = "UPDATE disco SET titulo = ?, ano = ?" . ($foto_capa ? ", foto_capa = ?" : "") . " WHERE disco_ID = ?";
        $stmt = $db->prepare($query);
        if ($foto_capa) {
            $stmt->bind_param("sisi", $titulo, $ano, $foto_capa, $disco_ID);
        } else {
            $stmt->bind_param("ssi", $titulo, $ano, $disco_ID);
        }
        // Executa a consulta e verifica o sucesso
        if ($stmt->execute()) {
            // Redireciona para a página de discos após a edição bem sucedida
            header("Location: indexDisco.php");
            exit();
        } else {
            // Exibe uma mensagem de erro se a edição falhar
            echo "Erro: " . $stmt->error;
        }
        // Fecha a conexão com o bd
        $stmt->close();
        $db->close();
    } else {
        echo "ID do disco não fornecido.";
        exit;
    }
} else {
    echo "Método de requisição inválido.";
    exit;
}
?>
