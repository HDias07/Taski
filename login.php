<?php
session_start();
include("conexao.php");

$usuario = $_POST['usuario'];
$senha = $_POST['senha'];

$sql = "SELECT * FROM usuarios WHERE usuario = '$usuario' AND senha = '$senha'";
$resultado = mysqli_query($conexao, $sql);

if (mysqli_num_rows($resultado) > 0) {
    $_SESSION['usuario'] = $usuario;
    header("Location: home.php");
    exit();
} else {
    echo "Usuário ou senha incorretos!";
}
?>