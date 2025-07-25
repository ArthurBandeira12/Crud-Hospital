<?php
require_once 'dbteste.php';
require_once 'authenticate.php';

$id = $_GET['id'] ?? null;

if (!$id) {
    echo "ID do médico não fornecido.";
    exit();
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $especialidade = $_POST['especialidade'];

    $stmt = $pdo->prepare("UPDATE medicos SET nome = ?, especialidade = ? WHERE id = ?");
    $stmt->execute([$nome, $especialidade, $id]);

    header("Location: index-medico.php");
    exit();
}


$stmt = $pdo->prepare("SELECT * FROM medicos WHERE id = ?");
$stmt->execute([$id]);
$medico = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$medico) {
    echo "Médico não encontrado.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Editar Médico</title>
</head>
<body>
    <h1>Editar Médico</h1>
    <form method="POST">
        <label for="nome">Nome:</label>
        <input type="text" name="nome" id="nome" value="<?= $medico['nome'] ?>" required>

        <label for="especialidade">Especialidade:</label>
        <input type="text" name="especialidade" id="especialidade" value="<?= $medico['especialidade'] ?>" required>

        <button type="submit">Salvar</button>
    </form>
</body>
</html>
