<?php
//Inserir no banco
$sql = "INSERT INTO cliente (nome, email, senha) VALUES (?,?,?)";

$stmt = $CONN->prepare($sql);
$stml->bind_param("sss", $nome, $email, $senha);

if ($start->execute()) {
    echo "Cadastro realizado com sucesso!";
} else {
    echo "Erro ao cadastrar.";
}

$stmt->close();
$conn->close();

?>