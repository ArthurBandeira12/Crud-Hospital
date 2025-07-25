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

    $stmt = $pdo->prepare("UPDATE pacientes SET nome = ?, idade = ?, data_nascimento = ?, tipo_sangue = ? WHERE id = ?");
    $stmt->execute([$nome, $idade, $data_nascimento, $tipo_sangue, $id]);

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
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Editar Paciente</title>
</head>
<body>
    <h1>Editar Paciente</h1>
    <form method="POST">
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

        <button type="submit">Salvar</button>
    </form>
</body>
</html>
