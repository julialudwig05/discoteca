<?php
// Conexão com o bd
$db = new mysqli("localhost", "root", "", "discoteca");
// Verifica se a conexão foi bem sucedida
if ($db->connect_error) {
    die("Conexão falhou: " . $db->connect_error);
}
// Consulta para listar todos os empréstimos
$query = "SELECT e.emprestimo_ID, e.nome_cliente, e.email_cliente, d.titulo AS titulo_disco, e.data_emprestimo, e.data_devolucao 
          FROM emprestimo e 
          JOIN disco d ON e.disco_ID = d.disco_ID";
$resultado = $db->query($query);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Empréstimos</title>
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
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #333;
            color: white;
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
        .botao {
            background-color: #28a745;
            color: white;
            padding: 5px 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            margin: 5px;
        }
        .botao:hover {
            background-color: #218838;
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
        <h2>Lista de Empréstimos</h2>
        <a href="form_registrar.php" class="botao">Cadastrar Empréstimo</a>
        <a href="form_devolver.php" class="botao">Devolver Empréstimo</a>
        <?php if ($resultado->num_rows > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>ID Empréstimo</th>
                        <th>Nome do Cliente</th>
                        <th>Email do Cliente</th>
                        <th>Disco</th>
                        <th>Data de Empréstimo</th>
                        <th>Data de Devolução</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($emprestimo = $resultado->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($emprestimo['emprestimo_ID']); ?></td>
                            <td><?php echo htmlspecialchars($emprestimo['nome_cliente']); ?></td>
                            <td><?php echo htmlspecialchars($emprestimo['email_cliente']); ?></td>
                            <td><?php echo htmlspecialchars($emprestimo['titulo_disco']); ?></td>
                            <td><?php echo htmlspecialchars($emprestimo['data_emprestimo']); ?></td>
                            <td><?php echo htmlspecialchars($emprestimo['data_devolucao']); ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>Nenhum empréstimo registrado.</p>
        <?php endif; ?>
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