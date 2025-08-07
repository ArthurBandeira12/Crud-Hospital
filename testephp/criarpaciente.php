<?php 

require_once 'dbteste.php';
require_once 'authenticate.php';



    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $nome = $_POST['nome'];
        $idade = $_POST['idade'];
        $data_nascimento = $_POST['data_nascimento'];
        $tipo_sangue = $_POST['tipo_sangue'];
        $usuario_id = $_SESSION['user_id'];
        
        
        
        if (!empty($_FILES['imagem']['name'])) {
            $extensao = pathinfo($_FILES['imagem']['name'], PATHINFO_EXTENSION);
            $novoNome = uniqid() . '.' . $extensao;
            $caminho = __DIR__ . '/../storage/' . $novoNome;
    
            // Mover o arquivo para a pasta storage
            if (move_uploaded_file($_FILES['imagem']['tmp_name'], $caminho)) {
                // Inserir o caminho da imagem na tabela imagens
                $stmt = $pdo->prepare("INSERT INTO imagens (path) VALUES (?)");
                $stmt->execute([$novoNome]);
                $imagem_id = $pdo->lastInsertId();
            }
        } else {
            $imagem_id = null;
        }

        $stmt = $pdo->prepare("INSERT INTO pacientes(nome, idade, data_nascimento, tipo_sangue, usuario_id, imagem_id) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$nome, $idade, $data_nascimento, $tipo_sangue, $usuario_id, $imagem_id]);

        
     header('Location: index-paciente.php');
      exit();
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
        <form method="POST" enctype="multipart/form-data">
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

            <label for="imagem">Imagem paciente:</label>
            <input type="file" name="imagem" id="imagem" accept="image/*">

            <button type="submit">Adicionar</button>
            
        </form>

    </main>
    </body>

    </html