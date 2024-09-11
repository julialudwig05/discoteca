<?php
// Conexão com o bd
$db = new mysqli("localhost", "root", "", "discoteca");
// Verifica se a conexão foi bem sucedida
if ($db->connect_error) {
    die("Conexão falhou: " . $db->connect_error);
}
// Consulta para obter todos os artistas
$query_artistas = "SELECT artista_ID, nome FROM artista";
$resultado_artistas = $db->query($query_artistas);
// Verifica se a consulta foi bem sucedida
if (!$resultado_artistas) {
    die("Erro na consulta de artistas: " . $db->error);
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adicionar Disco</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        header {
            background: #333;
            color: #fff;
            padding: 10px 0;
        }
        header .logo {
            text-align: center;
            font-size: 24px;
        }
        nav ul {
            list-style-type: none;
            padding: 0;
            text-align: center;
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
            margin: 20px;
            background: #fff;
            border-radius: 5px;
        }
        form {
            display: flex;
            flex-direction: column;
        }
        form label {
            margin-bottom: 5px;
            font-weight: bold;
        }
        form input[type="text"], form select {
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        form input[type="submit"] {
            padding: 10px;
            background: #333;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
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
        <h2>Adicionar Novo Disco</h2>
        <form method="post" action="addDisco.php" enctype="multipart/form-data">
            <label for="titulo">Título:</label>
            <input type="text" id="titulo" name="titulo" required>
            <label for="artista_ID">Artista:</label>
            <select id="artista_ID" name="artista_ID" required>
                <?php
                // Preenche o select com artistas
                while ($artista = $resultado_artistas->fetch_assoc()) {
                    echo "<option value='{$artista['artista_ID']}'>{$artista['nome']}</option>";
                }
                ?>
            </select>
            <label for="ano">Ano:</label>
            <input type="text" id="ano" name="ano" required>
            <label for="foto_capa">Foto de Capa:</label>
            <input type="file" id="foto_capa" name="foto_capa" accept="image/*" required>
            <input type="submit" value="Adicionar Disco">
        </form>
    </section>
    <footer>
        <p>&copy; 2024 - Discoteca Virtual - 3°TI</p>
    </footer>
</body>
</html>
<?php
// Fecha a conexão com o bd
$db->close();
?>
