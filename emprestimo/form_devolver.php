<?php
// Conexão com o bd
$db = new mysqli("localhost", "root", "", "discoteca");
// Verifica se a conexão foi bem sucedida
if ($db->connect_error) {
    die("Conexão falhou: " . $db->connect_error);
}
// Consulta para listar todos os empréstimos em aberto
$query = "SELECT e.emprestimo_ID, e.nome_cliente, e.email_cliente, d.titulo AS titulo_disco, e.data_emprestimo 
          FROM emprestimo e 
          JOIN disco d ON e.disco_ID = d.disco_ID 
          WHERE e.data_devolucao IS NULL";
$resultado = $db->query($query);
// Verifica se a consulta foi bem sucedida
if ($resultado === false) {
    die("Erro na consulta: " . htmlspecialchars($db->error));
}
// Fecha a conexão com o bd
$db->close();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Devolver Empréstimo</title>
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
            max-width: 800px;
        }
        label {
            margin: 10px 0 5px;
        }
        select, input[type="date"], input[type="submit"] {
            margin-bottom: 10px;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        input[type="submit"] {
            background-color: #28a745;
            color: white;
            border: none;
            padding: 10px 15px;
            cursor: pointer;
            font-weight: bold;
        }
        input[type="submit"]:hover {
            background-color: #218838;
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
        <h1>Discoteca Virtual</h1>
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
        <h2>Devolver Empréstimo</h2>
        <form method="post" action="devolverEmprestimo.php">
            <label for="emprestimo_ID">Empréstimo:</label>
            <select id="emprestimo_ID" name="emprestimo_ID" required>
                <?php
                if ($resultado->num_rows > 0) {
                    while ($emprestimo = $resultado->fetch_assoc()) {
                        echo "<option value='{$emprestimo['emprestimo_ID']}'>" . htmlspecialchars($emprestimo['titulo_disco']) . " - " . htmlspecialchars($emprestimo['nome_cliente']) . "</option>";
                    }
                } else {
                    echo "<option value=''>Nenhum empréstimo em aberto.</option>";
                }
                ?>
            </select>
            <label for="data_devolucao">Data de Devolução:</label>
            <input type="date" id="data_devolucao" name="data_devolucao" required>
            <input type="submit" value="Devolver Empréstimo">
        </form>
    </section>
    <footer>
        <p>&copy; 2024 - Discoteca Virtual - 3°TI</p>
    </footer>
</body>
</html>
