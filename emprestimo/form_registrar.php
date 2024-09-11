<?php
// Conexão com o bd
$db = new mysqli("localhost", "root", "", "discoteca");
// Verifica se a conexão foi bem sucedida
if ($db->connect_error) {
    die("Conexão falhou: " . $db->connect_error);
}
// Consulta para listar discos que não estão emprestados
$query = "
    SELECT d.disco_ID, d.titulo 
    FROM disco d 
    LEFT JOIN emprestimo e ON d.disco_ID = e.disco_ID AND e.data_devolucao IS NULL
    WHERE e.disco_ID IS NULL
";
$resultado = $db->query($query);
// Fecha a conexão com o bd
$db->close();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Empréstimo</title>
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
        form {
            display: flex;
            flex-direction: column;
        }
        label {
            margin: 10px 0 5px;
        }
        select, input[type="text"], input[type="date"], input[type="submit"] {
            margin-bottom: 10px;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        input[type="submit"] {
            background-color: #28a745;
            color: #fff;
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
        <h2>Cadastrar Empréstimo</h2>
        <form method="post" action="registrarEmprestimo.php">
            <label for="disco_ID">Disco:</label>
            <select id="disco_ID" name="disco_ID" required>
                <?php
                if ($resultado->num_rows > 0) {
                    while ($disco = $resultado->fetch_assoc()) {
                        echo "<option value='{$disco['disco_ID']}'>" . htmlspecialchars($disco['titulo']) . "</option>";
                    }
                } else {
                    echo "<option value=''>Nenhum disco disponível.</option>";
                }
                ?>
            </select>
            <label for="nome_cliente">Nome do Cliente:</label>
            <input type="text" id="nome_cliente" name="nome_cliente" required>
            <label for="email_cliente">E-mail do Cliente:</label>
            <input type="text" id="email_cliente" name="email_cliente" required>
            <label for="data_emprestimo">Data do Empréstimo:</label>
            <input type="date" id="data_emprestimo" name="data_emprestimo" required>
            <input type="submit" value="Registrar Empréstimo">
        </form>
    </section>
    <footer>
        <p>&copy; 2024 - Discoteca Virtual - 3°TI</p>
    </footer>
</body>
</html>
