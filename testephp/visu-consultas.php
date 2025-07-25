<?php
require_once 'dbteste.php';
require_once 'authenticate.php';

$id = $_GET['id'] ?? null;

if (!$id) {
    echo "ID da consulta não fornecido.";
    exit();
}

$stmt = $pdo->prepare("
    SELECT c.*, 
           m.nome AS nome_medico, 
           m.especialidade,
           p.nome AS nome_paciente,
           p.data_nascimento,
           p.tipo_sangue
    FROM consultas c
    LEFT JOIN medicos m ON c.medicos_id = m.id
    LEFT JOIN pacientes p ON c.pacientes_id = p.id
    WHERE c.id = ?
");

$stmt->execute([$id]);
$consulta = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$consulta) {
    echo "Consulta não encontrada.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Detalhes da Consulta</title>
</head>
<body>
    <h1>Detalhes da Consulta</h1>

    <p><strong>Médico:</strong> <?= htmlspecialchars($consulta['nome_medico']) ?> (<?= htmlspecialchars($consulta['especialidade']) ?>)</p>
    <p><strong>Paciente:</strong> <?= htmlspecialchars($consulta['nome_paciente']) ?></p>
    <p><strong>Data de Nascimento do Paciente:</strong> <?= htmlspecialchars($consulta['data_nascimento']) ?></p>
    <p><strong>Tipo Sanguíneo do Paciente:</strong> <?= htmlspecialchars($consulta['tipo_sangue']) ?></p>
    <p><strong>Data e Hora da Consulta:</strong> <?= date('d/m/Y H:i', strtotime($consulta['data_hora'])) ?></p>
    <p><strong>Observações:</strong><br> <?= nl2br(htmlspecialchars($consulta['obs'])) ?></p>

    <p>
        <a href="edit-consultas.php?id=<?= $consulta['id'] ?>">Editar Consulta</a> |
        <a href="delete-consultas.php?id=<?= $consulta['id'] ?>" onclick="return confirm('Tem certeza que deseja excluir esta consulta?');">Excluir Consulta</a> |
        <a href="index-consultas.php">Voltar para Lista</a>
    </p>
</body>
</html>
