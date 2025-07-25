<?php
require_once 'dbteste.php';

require_once 'authenticate.php';


$stmt = $pdo->query("SELECT medicos.*, usuarios.username FROM medicos LEFT JOIN usuarios ON medicos.usuario_id = usuarios.id");
$medicos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Medicos</title>
    <link rel="stylesheet" href="./css/style.css">
</head>
<body>
    <header>
        <h1>Lista de Medicos</h1>
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
                    <li><a href="/php/logout.php">Logout (<?= $_SESSION['username'] ?>)</a></li>
                <?php else: ?>
                    <li><a href="/php/user-login.php">Login</a></li>
                    <li><a href="/php/user-register.php">Registrar</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>
    <main>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Especialidade</th>
                    
                </tr>
            </thead>
            <tbody>
                <?php foreach ($medicos as $medico): ?>
                    <tr>
                        <td><?= $medico['id'] ?></td>
                        <td><?= $medico['nome'] ?></td>
                        <td><?= $medico['especialidade'] ?></td>
                        <td><?= $medico['username'] ?></td>
                        <td>
                            <a href="read-medico.php?id=<?= $medico['id'] ?>">Visualizar</a>
                            <a href="update-medico.php?id=<?= $medico['id'] ?>">Editar</a>
                            <a href="delete-medico.php?id=<?= $medico['id'] ?>" onclick="return confirm('Tem certeza que deseja excluir este medico?');">Excluir</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </main>
</body>
</html>