<?php

$conn = new mysqli("localhost", "root", "", "sistema_usuarios");

if ($conn->connect_error) {
    die("Erro de conexão: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titulo = $_POST['titulo'];
    $descricao = $_POST['descricao'];

    // Usando prepared statement (mais seguro)
    $stmt = $conn->prepare("INSERT INTO tarefas (titulo, descricao, status) VALUES (?, ?, 'pendente')");
    $stmt->bind_param("ss", $titulo, $descricao);

    if ($stmt->execute()) {
        echo "Tarefa cadastrada com sucesso!";
    } else {
        echo "Erro ao cadastrar: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
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