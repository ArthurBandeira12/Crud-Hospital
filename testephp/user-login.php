<?php

require_once 'dbteste.php';

session_start();

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if($user && password_verify($password, $user['password'])){
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        header('Location: /index.php');
        exit();
      
    } else {
    echo "Nome de usuario ou senha incorretos!";
  }
}

?>


<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="./css/style.css">
</head>
<body>
<header>
    <h1>Sistema de Genrenciamento de Pacientes</h1>
    <nav>
        <ul>
            <li><a href="/index.php">Home</a></li>
            <?php if (isset($_SESSION['user_id'])):?>
                <li ><a href="/testephp/index-paciente.php">Listar Pacientes</a></li>
                <li ><a href="/testephp/criarpaciente.php">Adicionar Pacientes</a></li>
                <li ><a href="/testephp/logout.php">Logout(<?= $_SESSION['username']?>)</a></li>
             <?php else: ?>
                <li><a href="/testephp/user-login.php">Login</a></li>
                <li><a href="/testephp/user-register.php">Registrar</a></li>
              <?php endif; ?>  
        </ul>
    </nav>
    <h1>Login</h1>
</header>
<main>
    <form method="POST">
        <label for="username"> Nome de Usuario:</label>
        <input type="text" id="username" name="username" required>

        <label for="password">Senha:</label>
        <input type="password" id="password" name="password" required>
        <button type="submit">Login</button>
    </form>
</main>
    
</body>
</html>