<?php 
session_start();
require_once 'dbteste.php';



if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $nome = $_POST['nome'];
    $idade = $_POST['idade'];
    $data_nascimento = $_POST['data_nascimento'];
    $tipo_sangue = $_POST['tipo_sangue'];
    $usuario_id = $_SESSION['user_id'];  

    
    
    $stmt = $pdo-> prepare("INSERT INTO pacientes(nome, idade, data_nascimento, tipo_sangue, usuario_id) VALUES(?, ?, ?, ?, ?)");
    $stmt->execute([$nome, $idade, $data_nascimento, $tipo_sangue, $usuario_id]);
}


   

?>

<!DOCTYPE html>
<html lang="pt-BR   ">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adicionar Pacientes</title>
    <link rel="stylesheet" href="./css/style.css">
</head>
<body>

<header>
    <h1>Adicionar Pacientes</h1>
</header>

<main>
    <form method="POST">
        <label for="nome"> Nome:</label>
        <input type="text" id="nome" name="nome" required>


        <label for="idade"> Idade:</label>
        <input type="number" id="idade" name="idade" required>
        
        
        <label for="data_nascimento">Data De Nascimento:</label>
        <input type="date" name="data_nascimento" id="data_nascimento">



        <label for="tipo_sangue"> Tipo sanguineo:</label>
        <select name ="tipo_sangue" id="tipo_sangue" required>
            <option value="A+">A+</option>
            <option value="A-">A-</option>
            <option value="B+">B+</option>
            <option value="B-">B-</option>
            <option value="AB+">AB+</option>
            <option value="AB-">AB-</option>
            <option value="O+">O+</option>
            <option value="O-">O-</option>

        

        </select>

        <button type="submit">Adicionar</button>


    </form>
</main>
    
</body>
</html>