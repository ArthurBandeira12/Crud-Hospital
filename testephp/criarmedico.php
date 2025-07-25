<?php 
require_once 'dbteste.php';



if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $nome = $_POST['nome'];
    $especialidade = $_POST['especialidade'];
    
    
    
    $stmt = $pdo-> prepare("INSERT INTO medicos (nome, especialidade) VALUES(?, ?)");
    $stmt->execute([$nome, $especialidade,]);


   
}

?>

<!DOCTYPE html>
<html lang="pt-BR   ">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adicionar Medico</title>
    <link rel="stylesheet" href="./css/style.css">
</head>
<body>

<header>
    <h1>Adicionar Medico</h1>
</header>

<main>
    <form method="POST">
        <label for="nome"> Nome:</label>
        <input type="text" id="nome" name="nome" required>


        <label for="especialidade">Especialidade:</label>
        <input type="text" id="especialidade" name="especialidade"required>


        

        <button type="submit">Adicionar</button>


    </form>
</main>
    
</body>
</html>