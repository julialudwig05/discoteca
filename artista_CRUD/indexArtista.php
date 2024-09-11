<?php
    // Conexão com o bd
    $db = new mysqli("localhost", "root", "", "discoteca");
    // Query de consulta
    $query = "select * from artista";
    // Executa a consulta e armazena o resultado
    $resultado = $db->query($query);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Artistas</title>
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
        <h2>Lista de Artistas</h2>
        <?php
            echo "<table>";
            echo "<tr>
                    <th>Nome</th>
                    <th>Ações</th>
                  </tr>";
            if ($resultado->num_rows == 0) {
                echo "<tr><td colspan='2'>Não há artistas cadastrados</td></tr>"; //deixa pra 2 colunas
            } else {
                while ($linha = $resultado->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>{$linha['nome']}</td>";
                    echo "<td>
                            <a href='delArtista.php?artista_ID={$linha['artista_ID']}'>Apagar</a>
                            <a href='form_editar.php?artista_ID={$linha['artista_ID']}'>Editar</a>
                          </td>";
                    echo "</tr>";
                }
            }
            echo "</table>";
            echo "<a href='form_adicionar.php'>Adicionar novo artista</a>";
        ?>  
    </section>
    <footer>
        <p>&copy; 2024 - Discoteca Virtual - 3°TI</p>
    </footer>
</body>
</html>
