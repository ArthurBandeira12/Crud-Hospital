<?php

require_once 'dbteste.php';

$stmt = $pdo->query("SELECT * FROM pacientes");

$pacientes = $stmt->fetchAll(PDO::FETCH_ASSOC);


?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crud pacientes</title>
    <link rel="stylesheet" href="./css/style.css">
</head>
<body>
    <header>
        <h1>Genrenciamento de pacientes</h1>

        <nav>
            <ul>

           
            <li><a href="/index.php">Home</a></li>
            <?php if (isset($_SESSION['user_id'])): ?>

            <li>Pacientes:
                <a href="/testephp/criarpaciente.php">Adicionar</a>
                <a href="/testephp/index-paciente.php">Listar</a>

            </li>

            <li>Medicos:
                <a href="/testephp/criarmedico.php">Adicionar</a>
                <a href="/testephp/index-medico.php">Listar</a>
            </li>
            <li><a href="/testephp/logout.php">Logout(<? $_SESSION['username'] ?>)</a></li>
            <?php else: ?>
                <li><a href="/testephp/user-login.php">Login</a></li>
                <li><a href="/testephp/user-register.php">Registrar</a></li>

            <?php endif; ?>
            </ul>
        </nav>
    </header>

    <main>
        <h2>Lista de Pacientes:</h2>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Idade</th>
                    <th>Data de Nascimento</th>
                    <th>Tipo Sanguineo</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($pacientes as $paciente): ?>
                    <tr>
                        <td><?= $paciente['id']?></td>
                        <td><?= $paciente['nome']?></td>
                        <td><?= $paciente['idade']?></td>
                        <td><?= $paciente['data_nascimento']?></td>
                        <td><?= $paciente['tipo_sangue']?></td>
                        <td>
                            <a href="visu-paciente.php?id=<?= $paciente['id'] ?>">Visualizar</a>
                            <a href="edit-paciente.php?id=<?= $paciente['id'] ?>">Editar</a>
                            <a href="delete-paciente.php?id=<?= $paciente['id'] ?>">Deletar</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
            </tbody>
        </table>
    </main>

    <footer>
        <p>Sistema Hospital Vera Cruz - 2025</p>
    </footer>
    
</body>
</html>
