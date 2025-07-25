<?php
require_once 'dbteste.php';
require_once 'authenticate.php';

$id = $_GET['id'] ?? null;

if (!$id) {
    echo "ID do médico não fornecido.";
    exit();
}

$stmt = $pdo->prepare("SELECT * FROM medicos WHERE id = ?");
$stmt->execute([$id]);
$medico = $stmt->fetch();

if (!$medico) {
    echo "Médico não encontrado.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Detalhes do Médico</title>
    <link rel="stylesheet" href="./css/style.css">
</head>
<body>
    <header>
        <h1>Detalhes do Médico</h1>
        <a href="index-medico.php">← Voltar</a>
    </header>
    <main>
        <p><strong>ID:</strong> <?= htmlspecialchars($medico['id']) ?></p>
        <p><strong>Nome:</strong> <?= htmlspecialchars($medico['nome']) ?></p>
        <p><strong>Especialidade:</strong> <?= htmlspecialchars($medico['especialidade']) ?></p>
        
    </main>
</body>
</html>