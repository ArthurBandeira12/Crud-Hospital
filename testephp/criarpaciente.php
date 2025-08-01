    <?php 
    session_start();
    require_once 'dbteste.php';



    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $nome = $_POST['nome'];
        $idade = $_POST['idade'];
        $data_nascimento = $_POST['data_nascimento'];
        $tipo_sangue = $_POST['tipo_sangue'];
        $usuario_id = $_SESSION['user_id'];
        $imagem_id = 1;
        
        
        if (!empty($_FILES["imagem"]["name"])) {
            $extensao = strtolower(pathinfo($_FILES['imagem']['name'], PATHINFO_EXTENSION));
            $permitidas = ['jpg', 'jpeg', 'png', 'webp'];

            if (in_array($extensao, $permitidas)) {
                $novoNome = uniqid() . '.' . $extensao;
                $destino = __DIR__ . '/storage/' . $novoNome;

                if (move_uploaded_file($_FILES['imagem']['tmp_name'], $destino)) {
                    $stmt = $pdo->prepare("INSERT INTO imagens (path) VALUES (?)");
                    $stmt->execute([$novoNome]);
                    $imagem_id = $pdo->lastInsertId();
                }
            }
        }

        $stmt = $pdo->prepare("INSERT INTO pacientes(nome, idade, data_nascimento, tipo_sangue, usuario_id, imagem_id) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$nome, $idade, $data_nascimento, $tipo_sangue, $usuario_id, $imagem_id]);
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

    </html>


        