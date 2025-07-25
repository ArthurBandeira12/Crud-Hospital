<?php
require_once 'dbteste.php';

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE username = ?");
    $stmt->execute([$username]);

    if($stmt->rowCount() > 0){
        echo "Nome de usuario ja existe!";
    } else {
        $stmt = $pdo->prepare("INSERT INTO usuarios (username, password) VALUES (?, ?)");
        if($stmt->execute([$username, $password])){
            echo "Usuario registrado com sucesso!";
            header('Location: user-login.php');
        } else{
            echo "Erro ao registrar usuario.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Usuario</title>
    <link rel="stylesheet" href="./css/style.css">
</head>
<body>
    <header>
        <h1>Registrar usuario</h1>
    </header>
    <main>
        <form method="POST">
            <label for="username">Nome de Usuario:</label>
            <input type="text" id="username" name="username" required>

            <label for="password">Senha:</label>
            <input type="password" id="password" name="password" required>

            <button type="submit">Registrar</button>
        </form>
    </main>
    
</body>
</html>