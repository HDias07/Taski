<?php
// conexão com banco
$conn = new mysqli("localhost", "root", "", "tarefas");

if ($conn->connect_error) {
    die("Erro de conexão: " . $conn->connect_error);
}

// cadastrar tarefa
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titulo = $_POST['titulo'];
    $descricao = $_POST['descricao'];

    $sql = "INSERT INTO tarefas (titulo, descricao) VALUES ('$titulo', '$descricao')";
    $conn->query($sql);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Sistema de Tarefas</title>
</head>
<body>

<h2>Cadastrar Tarefa</h2>

<form method="POST">
    <input type="text" name="titulo" placeholder="Título" required><br><br>
    <textarea name="descricao" placeholder="Descrição" required></textarea><br><br>
    <button type="submit">Cadastrar</button>
</form>

<hr>

<h2>Lista de Tarefas</h2>

<?php
$sql = "SELECT * FROM tarefas";
$result = $conn->query($sql);

while($row = $result->fetch_assoc()) {
    echo "<h3>" . $row['titulo'] . "</h3>";
    echo "<p>" . $row['descricao'] . "</p>";
    echo "<hr>";
}

$conn->close();
?>

</body>
</html>