<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Conexão com o bd
    $db = new mysqli("localhost", "root", "", "discoteca");
    // Verifica se a conexão foi bem sucedida
    if ($db->connect_error) {
        die("Conexão falhou: " . $db->connect_error);
    }
    // Diretório de destino para o arquivo
    $diretorioDestino = "../arquivos/";
    // Verifica se o arquivo foi enviado e é válido
    if (isset($_FILES['foto_capa']) && $_FILES['foto_capa']['error'] === UPLOAD_ERR_OK) {
        // Extrai a extensão do arquivo
        $extensao = strtolower(pathinfo($_FILES['foto_capa']['name'], PATHINFO_EXTENSION));//converte pra minuscula
        // Verifica a extensão do arquivo
        $extensoesPermitidas = ['jpg', 'jpeg', 'png', 'gif'];
        if (!in_array($extensao, $extensoesPermitidas)) {
            die("Tipo de arquivo não permitido. Somente JPG, JPEG, PNG e GIF são aceitos.");
        }
        // Caminho completo onde o arquivo será armazenado
        $destinoArquivo = $diretorioDestino . basename($_FILES['foto_capa']['name']);
        // Move o arquivo para o diretório de destino
        if (!move_uploaded_file($_FILES['foto_capa']['tmp_name'], $destinoArquivo)) {
            die("Erro ao mover o arquivo para o diretório de destino.");
        }
    } else {
        die("Nenhum arquivo enviado ou ocorreu um erro durante o envio.");
    }
    // Prepara a consulta para evitar SQL Injection
    $stmt = $db->prepare("INSERT INTO disco (titulo, artista_ID, ano, foto_capa) VALUES (?, ?, ?, ?)");
    if (!$stmt) {
        die("Erro na preparação da consulta: " . $db->error);
    }
    // Obtém os dados do formulário
    $titulo = $_POST['titulo'];
    $artista_ID = intval($_POST['artista_ID']);
    $ano = intval($_POST['ano']);
    // Verifica se os dados são válidos
    if (empty($titulo) || empty($artista_ID) || empty($ano) || empty($destinoArquivo)) {
        die("Dados inválidos. Verifique os campos do formulário.");
    }
    $stmt->bind_param("siss", $titulo, $artista_ID, $ano, $destinoArquivo);
    // Executa a consulta e verifica o sucesso
    if ($stmt->execute()) {
        // Redireciona para a página de discos após a inserção bem sucedida
        header("Location: indexDisco.php");
        exit();
    } else {
        // Exibe uma mensagem de erro se a inserção falhar
        echo "Erro: " . $stmt->error;
    }
    // Fecha a consulta e a conexão com o bd
    $stmt->close();
    $db->close();
} else {
    // Caso não seja uma requisição POST, redireciona para a página de discos
    header("Location: indexDisco.php");
    exit();
}
?>
