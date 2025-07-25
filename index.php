<?php
session_start();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hospital Real Vera Cruz</title>
    <link rel="stylesheet" href="./css/style.css">
</head>
<body>
    <header>
        <h1>Hospital Real Vera Cruz</h1>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <?php if (isset($_SESSION['user_id'])): ?>

                    <li>Pacientes:
                        <a href="/testephp/criarpaciente.php">Adicionar Paciente</a>
                        <a href="/testephp/index-paciente.php">Listar Pacientes</a>
                    </li>
                    <li> Medicos
                        <a href="/testephp/criarmedico.php">Adicionar Medico</a>
                        <a href="/testephp/index-medico.php">Listar Medicos</a>
                    </li>
                    <li> Consultas
                        <a href="/testephp/criarconsultas.php">Criar Consulta</a>
                        <a href="/testephp/index-consultas.php">Lista de Consultas</a>
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
        <h2>Bem-vindo ao Hospital</h2>
        <p>Utilize o menu de acordo com oque vc precisar</p>
    </main>

    <footer>
        <p>&copy; 2025 - Hospital Real Vera Cruz</p>
    </footer>
    
</body>
</html>