CREATE DATABASE IF NOT EXISTS sistema_usuarios;
USE sistema_usuarios;

CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario VARCHAR(50) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL,
    data_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO usuarios (usuario, senha)
VALUES ('admin', 'admin');

CREATE TABLE tarefas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(100) NOT NULL,
    descricao TEXT NOT NULL,
    status VARCHAR(50) NOT NULL,
    data_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

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