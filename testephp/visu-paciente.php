<?php
require_once 'dbteste.php';
require_once 'authenticate.php';

$id = $_GET['id'];


$stmt = $pdo->prepare("SELECT pacientes.*, usuarios.username FROM pacientes LEFT JOIN usuarios ON pacientes.usuario_id = usuarios.id WHERE pacientes.id = ?");
$stmt->execute([$id]);
$paciente = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalhes do Paciente</title>
    <link rel="stylesheet" href="./css/style.css">
</head>
<body>
    <header>
        <h1>Detalhes do Paciente</h1>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <li>Pacientes: 
                        <a href="/testephp/criarpaciente.php">Adicionar</a> | 
                        <a href="/testephp/index-paciente.php">Listar</a>
                    </li>
                    <li>Medicos: 
                        <a href="/testephp/criarmedico.php">Adicionar</a> | 
                        <a href="/testephp/index-medico.php">Listar</a>
                    </li>
                    
                    <li><a href="/testephp/logout.php">Logout (<?= $_SESSION['username'] ?>)</a></li>
                <?php else: ?>
                    <li><a href="/testephp/user-login.php">Login</a></li>
                    <li><a href="/testephp/user-register.php">Registrar</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>
    <main>
        <?php if ($paciente): ?>
            <p><strong>ID:</strong> <?= $paciente['id'] ?></p>
            <p><strong>Nome:</strong> <?= $paciente['nome'] ?></p>
            <p><strong>Idade:</strong> <?= $paciente['idade'] ?></p>
            <p><strong>Tipo Sanguineo:</strong> <?= $paciente['tipo_sangue'] ?></p>
            
            <p><strong>Usuário Associado:</strong> <?= $paciente['username'] ?></p>
            <p>
                <a href="edit-paciente.php?id=<?= $paciente['id'] ?>">Editar</a>
                <a href="delete-paciente.php?id=<?= $paciente['id'] ?>">Excluir</a>
            </p>
        <?php else: ?>
            <p>Paciente não encontrado.</p>
        <?php endif; ?>
    </main>
</body>
</html>