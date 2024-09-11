<?php
// Verifica se o parametro disco_ID está presente na URL
if (isset($_GET['disco_ID'])) {
    // Conexão com o bd
    $db = new mysqli("localhost", "root", "", "discoteca");
    // Verifica se a conexão foi bem sucedida
    if ($db->connect_error) {
        die("Conexão falhou: " . $db->connect_error);
    }
    // Query de consulta para obter os dados do disco
    $disco_ID = intval($_GET['disco_ID']);
    $query = "SELECT * FROM disco WHERE disco_ID = $disco_ID";
    $resultado = $db->query($query);
    // Verifica se a consulta foi bem sucedida
    if (!$resultado) {
        die("Erro na consulta: " . $db->error);
    }
    // Obtém os dados do disco
    $disco = $resultado->fetch_assoc();
    // Fecha a conexão com o bd
    $db->close();
} else {
    echo "ID do disco não fornecido.";
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Disco - Discoteca</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        header {
            background: #333;
            color: #fff;
            padding: 10px 0;
            text-align: center;
        }
        nav ul {
            list-style-type: none;
            padding: 0;
            text-align: center;
            margin: 0;
        }
        nav ul li {
            display: inline;
            margin: 0 15px;
        }
        nav ul li a {
            color: #fff;
            text-decoration: none;
            font-weight: bold;
        }
        nav ul li a:hover {
            text-decoration: underline;
        }
        section.content {
            padding: 20px;
            margin: 20px auto;
            background: #fff;
            border-radius: 5px;
            max-width: 500px; /* Ajusta a largura do formulário */
        }
        form {
            display: flex;
            flex-direction: column;
        }
        form label {
            margin-bottom: 5px;
            font-weight: bold;
        }
        form input[type="text"],
        form input[type="number"],
        form input[type="file"] {
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px; /* Ajusta o tamanho da fonte */
        }
        form input[type="submit"] {
            padding: 10px;
            background: #333;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px; /* Ajusta o tamanho da fonte */
        }
        form input[type="submit"]:hover {
            background: #555;
        }
        footer {
            text-align: center;
            padding: 10px;
            background: #333;
            color: #fff;
            position: fixed;
            width: 100%;
            bottom: 0;
        }
    </style>
</head>
<body>
    <header>
        <div class="logo">
            <h1>Discoteca Virtual</h1>
        </div>
        <nav>
            <ul>
                <li><a href="http://localhost/discoteca/interface/index.html">Início</a></li>
                <li><a href="http://localhost/discoteca/disco_CRUD/indexDisco.php">Discos</a></li>
                <li><a href="http://localhost/discoteca/artista_CRUD/indexArtista.php">Artistas</a></li>
                <li><a href="http://localhost/discoteca/emprestimo/indexEmprestimo.php">Empréstimos</a></li>
            </ul>
        </nav>
    </header>
    <section class="content">
        <h2>Editar Disco</h2>
        <form method="post" action="editDisco.php" enctype="multipart/form-data">
            <label for="titulo">Título:</label>
            <input type="text" id="titulo" name="titulo" required value="<?php echo htmlspecialchars($disco['titulo']); ?>">
            <label for="ano">Ano:</label>
            <input type="number" id="ano" name="ano" required value="<?php echo htmlspecialchars($disco['ano']); ?>">
            <label for="foto_capa">Link para foto de capa:</label>
            <input type="file" id="foto_capa" name="foto_capa">
            <input type="hidden" id="disco_ID" name="disco_ID" value="<?php echo htmlspecialchars($disco['disco_ID']); ?>">
            <input type="submit" name="botao" value="Editar">
        </form>
    </section>
    <footer>
        <p>&copy; 2024 - Discoteca Virtual - 3°TI</p>
    </footer>
</body>
</html>