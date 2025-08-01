<?php
require_once 'dbteste.php';
require_once 'authenticate.php';

$id = $_GET['id'] ?? null;

if (!$id) {
    echo "ID do paciente não fornecido.";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $idade = $_POST['idade'];
    $data_nascimento = $_POST['data_nascimento'];
    $tipo_sangue = $_POST['tipo_sangue'];

    
    $stmt = $pdo->prepare("SELECT imagem_id FROM pacientes WHERE id = ?");
    $stmt->execute([$id]);
    $pacienteAtual = $stmt->fetch(PDO::FETCH_ASSOC);
    $imagem_id = $pacienteAtual['imagem_id'] ?? null;

    
    if (!empty($_FILES['imagem']['name'])) {
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

  
    $stmt = $pdo->prepare("UPDATE pacientes SET nome = ?, idade = ?, data_nascimento = ?, tipo_sangue = ?, imagem_id = ? WHERE id = ?");
    $stmt->execute([$nome, $idade, $data_nascimento, $tipo_sangue, $imagem_id, $id]);

    header("Location: index-paciente.php");
    exit();
}


$stmt = $pdo->prepare("SELECT * FROM pacientes WHERE id = ?");
$stmt->execute([$id]);
$paciente = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$paciente) {
    echo "Paciente não encontrado.";
    exit();
}


$imagemPath = '/storage/imagemusuario.webp';

if (!empty($paciente['imagem_id'])) {
    $stmt = $pdo->prepare("SELECT path FROM imagens WHERE id = ?");
    $stmt->execute([$paciente['imagem_id']]);
    $imagem = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($imagem) {
        
        $imagemPath = '/storage/' . $imagem['path'] . '?v=' . time();
    }
}

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Editar Paciente</title>
</head>
<body>
    <h1>Editar Paciente</h1>
    <form method="POST" enctype="multipart/form-data">
        <label for="nome">Nome:</label>
        <input type="text" name="nome" id="nome" value="<?= $paciente['nome'] ?>" required>

        <label for="idade">Idade:</label>
        <input type="number" name="idade" id="idade" value="<?= $paciente['idade'] ?>" required>

        <label for="data_nascimento">Data de Nascimento:</label>
        <input type="date" name="data_nascimento" id="data_nascimento" value="<?= $paciente['data_nascimento'] ?>" required>

        <label for="tipo_sanguineo">Tipo Sanguíneo:</label>
        <select name="tipo_sangue" id="tipo_sangue" required>
            <?php
            $tipos = ['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'];
            foreach ($tipos as $tipo) {
                $selected = $paciente['tipo_sangue'] == $tipo ? 'selected' : '';
                echo "<option value='$tipo' $selected>$tipo</option>";
            }
            ?>
        </select>

        <label for="imagem">Imagem paciente:</label>
        <input type="file" name="imagem" id="imagem" accept="image/*">

        <button type="submit">Salvar</button>
    </form>
</body>
</html>
