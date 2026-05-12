<?php
session_start();

$mensagem = "";

if (!isset($_SESSION['usuario'])) { // verifica login
    header("Location: index.php");
    exit();
}

$conn = new mysqli("localhost", "root", "", "sistema_usuarios"); // conecta com o banco de dados

if ($conn->connect_error) {
    die("Erro de conexão: " . $conn->connect_error);
}

if (isset($_GET['excluir'])) { // função excluir tarefa
    $id = $_GET['excluir'];

    $stmt = $conn->prepare("DELETE FROM tarefas WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") { // cadastro de tarefas
    $titulo = $_POST['titulo'];
    $descricao = $_POST['descricao'];

    $stmt = $conn->prepare("
        INSERT INTO tarefas (titulo, descricao, status)
        VALUES (?, ?, 'pendente')
    ");

    $stmt->bind_param("ss", $titulo, $descricao);

    if ($stmt->execute()) {
        $mensagem = "Tarefa cadastrada com sucesso!";
    } else {
        $mensagem = "Erro: " . $stmt->error;
    }

    $stmt->close();
}

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Sistema de Tarefas</title>
    <link rel="shortcut icon" href="img/favicon-16x16.png" type="image/x-icon">
    <style>
        * {
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            margin: 0;
            background: #4a2ca5;
            color: #1f1735;
        }

        header {
            width: 100%;
            min-height: 70px;
            padding: 10px 20px;
            background: linear-gradient(90deg, #4a00e0, #8e2de2);
            display: flex;
            justify-content: center;
            align-items: center;
        }

        header img {
            height: 84px;
            max-width: 100%;
            object-fit: contain;
        }

        .page {
            width: min(1100px, calc(100% - 32px));
            margin: 30px auto;
            display: grid;
            gap: 24px;
        }

        .hero,
        .panel,
        .task-card,
        .empty-state {
            border-radius: 24px;
            box-shadow: 0 18px 45px rgba(18, 8, 44, 0.22);
        }

        .hero {
            padding: 28px;
            background: linear-gradient(135deg, #0f8b8d, #5b3c88);
            color: #fff;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 20px;
            flex-wrap: wrap;
        }

        .hero h2 {
            margin: 0 0 10px;
            font-size: 30px;
        }

        .hero p {
            margin: 0;
            max-width: 680px;
            color: rgba(255, 255, 255, 0.9);
            line-height: 1.5;
        }

        .logout-link {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 12px 18px;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.18);
            color: #fff;
            text-decoration: none;
            font-weight: bold;
            transition: background-color 0.2s ease;
        }

        .logout-link:hover {
            background: rgba(255, 255, 255, 0.28);
        }

        .content {
            display: grid;
            grid-template-columns: minmax(280px, 340px) 1fr;
            gap: 24px;
            align-items: start;
        }

        .panel {
            padding: 24px;
            background: #ffffff;
        }

        .panel h3,
        .tasks-section h3 {
            margin-top: 0;
            margin-bottom: 18px;
            color: #34215f;
            font-size: 24px;
        }

        .status-message {
            margin-bottom: 18px;
            padding: 12px 14px;
            border-radius: 14px;
            background: #eef7ff;
            color: #274d72;
            font-size: 14px;
        }

        .field {
            margin-bottom: 16px;
        }

        .field label {
            display: block;
            margin-bottom: 6px;
            color: #55457d;
            font-size: 14px;
            font-weight: bold;
        }

        .field input,
        .field textarea {
            width: 100%;
            padding: 12px 14px;
            border: 1px solid #d6d2e5;
            border-radius: 16px;
            background: #f7f6fb;
            color: #1f1735;
            font-size: 14px;
        }

        .field textarea {
            min-height: 130px;
            resize: vertical;
        }

        .btn {
            width: 100%;
            padding: 12px 16px;
            border: none;
            border-radius: 16px;
            background-color: #4a90c2;
            color: #fff;
            font-size: 15px;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.2s ease, transform 0.2s ease;
        }

        .btn:hover {
            background-color: #3b7aa3;
            transform: translateY(-1px);
        }

        .tasks-section {
            display: grid;
            gap: 16px;
        }

        .task-card {
            padding: 20px;
            background: #ffffff;
        }

        .task-top {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 12px;
            margin-bottom: 12px;
        }

        .task-title {
            margin: 0;
            color: #34215f;
            font-size: 21px;
        }

        .task-description {
            margin: 0;
            color: #55457d;
            line-height: 1.55;
        }

        .status-link {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 128px;
            padding: 10px 14px;
            border-radius: 999px;
            text-decoration: none;
            font-weight: bold;
            font-size: 14px;
        }

        .status-pendente {
            background: #fff4d6;
            color: #aa6b00;
        }

        .status-concluido {
            background: #dcf7e5;
            color: #14703d;
        }

        .task-actions {
            display: flex;
            gap: 12px;
            margin-top: 18px;
            flex-wrap: wrap;
        }

        .action-link {
            text-decoration: none;
            font-weight: bold;
            font-size: 14px;
        }

        .action-edit {
            color: #366bb3;
        }

        .action-delete {
            color: #c23852;
        }

        .empty-state {
            padding: 28px;
            background: rgba(255, 255, 255, 0.92);
            color: #55457d;
            text-align: center;
        }

        @media (max-width: 860px) {
            .content {
                grid-template-columns: 1fr;
            }

            .hero h2 {
                font-size: 26px;
            }
        }
    </style>
</head>
<body>
<header>
    <img src="img/logo-taski-png.png" alt="Taski">
</header>

<main class="page">
    <section class="hero">
        <div>
            <h2>Bem-vindo!</h2>
            <p>
                Bem-vindo à Taski! Aqui você organiza suas tarefas e acompanha seu progresso de um jeito simples.
            </p>
        </div>
        <a class="logout-link" href="logout.php">Sair</a>
    </section>

    <section class="content">
        <div class="panel">
            <h3>Cadastrar Tarefa</h3>

            <?php if (!empty($mensagem)) { ?>
                <div class="status-message"><?php echo $mensagem; ?></div>
            <?php } ?>

            <form method="POST">
                <div class="field">
                    <label for="titulo">Título</label>
                    <input
                        id="titulo"
                        type="text"
                        name="titulo"
                        placeholder="Digite o título da tarefa"
                        required
                    >
                </div>

                <div class="field">
                    <label for="descricao">Descrição</label>
                    <textarea
                        id="descricao"
                        name="descricao"
                        placeholder="Descreva a tarefa"
                        required
                    ></textarea>
                </div>

                <button class="btn" type="submit">
                    Cadastrar
                </button>
            </form>
        </div>

        <div class="tasks-section">
            <h3>Lista de Tarefas</h3>

<?php

if (isset($_GET['status']) && isset($_GET['id'])) {
    $id = $_GET['id'];
    $novoStatus = $_GET['status']; // status da tarefa

    $stmt = $conn->prepare("
        UPDATE tarefas
        SET status = ?
        WHERE id = ? 
    ");

    $stmt->bind_param("si", $novoStatus, $id);
    $stmt->execute(); // executa o status da tarefa
    $stmt->close();
}

if (isset($_GET['excluir'])) {
    $id = $_GET['excluir'];

    $stmt = $conn->prepare("
        DELETE FROM tarefas
        WHERE id = ?
    ");

    $stmt->bind_param("i", $id);
    $stmt->execute(); // exclui a tarefa
    $stmt->close();
}

$sql = "SELECT * FROM tarefas ORDER BY id DESC";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) { // lista de tarefas
        echo "<div class='task-card'>";
        echo "<div class='task-top'>";
        echo "<h4 class='task-title'>" . $row['titulo'] . "</h4>";

        if ($row['status'] == 'pendente') { // mostra na tela um botão de pendente
            echo "
            <a href='?id=" . $row['id'] . "&status=concluido' class='status-link status-pendente'>
               Pendente
            </a>
            ";
        } else { // se clicar em \"pendente\", fica em concluído
            echo "
            <a href='?id=" . $row['id'] . "&status=pendente' class='status-link status-concluido'>
               Concluído
            </a>
            ";
        }

        echo "</div>";
        echo "<p class='task-description'>" . $row['descricao'] . "</p>"; // mostra a descrição da tabela

        echo "
        <div class='task-actions'>
            <a class='action-link action-edit' href='editar_tarefa.php?id=" . $row['id'] . "'>
               Editar
            </a>

            <a class='action-link action-delete' href='?excluir=" . $row['id'] . "' 
               onclick=\"return confirm('Deseja excluir?')\">
               Excluir
            </a>
        </div>";

        echo "</div>";
    }
} else {
    echo "<div class='empty-state'>Nenhuma tarefa cadastrada.</div>";
}

$conn->close();

?>
        </div>
    </section>
</main>

</body>
</html>
