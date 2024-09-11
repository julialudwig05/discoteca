<?php
// Conexão com o bd
$db = new mysqli("localhost", "root", "", "discoteca");
// Verifica se a conexão foi bem sucedida
if ($db->connect_error) {
    die("Conexão falhou: " . $db->connect_error);
}
// Determina a ordem de ordenação
$ordenarPor = isset($_GET['ordenar_por']) ? $_GET['ordenar_por'] : 'titulo';
$ordem = isset($_GET['ordem']) && $_GET['ordem'] === 'desc' ? 'DESC' : 'ASC';
// Verifica se o parametro de ordenação é válido
$ordenarPor = in_array($ordenarPor, ['artista_nome', 'ano', 'titulo']) ? $ordenarPor : 'titulo';
// Query de consulta com ordenação
$query = "SELECT disco_ID AS disco_ID, disco.titulo AS titulo, artista.nome AS artista_nome, disco.foto_capa AS foto_capa, disco.ano AS ano
FROM disco
INNER JOIN artista ON disco.artista_ID = artista.artista_ID
ORDER BY $ordenarPor $ordem";
// Executa a consulta e armazena o resultado
$resultado = $db->query($query);
// Verifica se a consulta foi bem sucedida
if (!$resultado) {
    die("Erro na consulta: " . $db->error);
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Discos</title>
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
            max-width: 800px;
            margin: 20px auto;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        img {
            max-width: 100px;
            height: auto;
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
        <h2>Lista de Discos</h2>
        <form method="get" action="">
            <label for="ordenar_por">Ordenar por:</label>
            <select id="ordenar_por" name="ordenar_por">
                <option value="titulo" <?php if ($ordenarPor == 'titulo') echo 'selected'; ?>>Título</option>
                <option value="ano" <?php if ($ordenarPor == 'ano') echo 'selected'; ?>>Ano</option>
                <option value="artista_nome" <?php if ($ordenarPor == 'artista_nome') echo 'selected'; ?>>Artista</option>
            </select>
            <label for="ordem">Ordem:</label>
            <select id="ordem" name="ordem">
                <option value="asc" <?php if ($ordem == 'ASC') echo 'selected'; ?>>Crescente</option>
                <option value="desc" <?php if ($ordem == 'DESC') echo 'selected'; ?>>Descendente</option>
            </select>
            <input type="submit" value="Ordenar">
        </form>
        <?php
            echo "<table>";
            echo "<tr>
                    <th>Título</th>
                    <th>Nome do Artista</th>
                    <th>Ano</th>
                    <th>Foto de Capa</th>
                    <th>Ações</th>
                  </tr>";
            if ($resultado->num_rows == 0) {
                echo "<tr><td colspan='5'>Não há discos cadastrados</td></tr>";
            } else {
                while ($linha = $resultado->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>{$linha['titulo']}</td>";
                    echo "<td>{$linha['artista_nome']}</td>";
                    echo "<td>{$linha['ano']}</td>";
                    echo "<td><img src='{$linha['foto_capa']}' alt='Foto de Capa' width='100'></td>";
                    echo "<td>
                            <a href='delDisco.php?disco_ID={$linha['disco_ID']}'>Apagar</a>
                            <a href='form_editar.php?disco_ID={$linha['disco_ID']}'>Editar</a>
                          </td>";
                    echo "</tr>";
                }
            }
            echo "</table>";
            echo "<a href='form_adicionar.php'>Adicionar novo disco</a>";
        ?>
    </section>
    <footer>
        <p>&copy; 2024 - Discoteca Virtual - 3°TI</p>
    </footer>
</body>
</html>