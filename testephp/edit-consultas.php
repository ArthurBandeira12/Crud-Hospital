<?php
require_once 'dbteste.php';
require_once 'authenticate.php';

$id = $_GET['id'] ?? null;

if (!$id) {
    echo "ID da consulta não fornecido.";
    exit();
}


$stmt = $pdo->prepare("SELECT * FROM consultas WHERE id = ?");
$stmt->execute([$id]);
$consulta = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$consulta) {
    echo "Consulta não encontrada.";
    exit();
}


$medicos = $pdo->query("SELECT * FROM medicos")->fetchAll(PDO::FETCH_ASSOC);
$pacientes = $pdo->query("SELECT * FROM pacientes")->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $medicos_id = $_POST['medicos_id'] ?? null;
    $pacientes_id = $_POST['pacientes_id'] ?? null;
    $data_hora = $_POST['data_hora'] ?? null;
    $obs = $_POST['obs'] ?? '';

    
    if (!$medicos_id || !$pacientes_id || !$data_hora) {
        echo "Por favor, preencha todos os campos obrigatórios.";
    } else {
        $stmt = $pdo->prepare("UPDATE consultas SET medicos_id = ?, pacientes_id = ?, data_hora = ?, obs = ? WHERE id = ?");
        $stmt->execute([$medicos_id, $pacientes_id, $data_hora, $obs, $id]);
        header("Location: index-consultas.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Editar Consulta</title>
</head>
<body>
    <h1>Editar Consulta</h1>
    <form method="POST">
        <label for="medicos_id">Médico:</label>
        <select name="medicos_id" id="medicos_id" required>
            <?php foreach ($medicos as $medico): ?>
                <option value="<?= $medico['id'] ?>" <?= ($consulta['medicos_id'] == $medico['id']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($medico['nome']) ?> (<?= htmlspecialchars($medico['especialidade']) ?>)
                </option>
            <?php endforeach; ?>
        </select><br><br>

        <label for="pacientes_id">Paciente:</label>
        <select name="pacientes_id" id="pacientes_id" required>
            <?php foreach ($pacientes as $paciente): ?>
                <option value="<?= $paciente['id'] ?>" <?= ($consulta['pacientes_id'] == $paciente['id']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($paciente['nome']) ?>
                </option>
            <?php endforeach; ?>
        </select><br><br>

        <label for="data_hora">Data e Hora:</label>
        <input type="datetime-local" name="data_hora" id="data_hora" value="<?= date('Y-m-d\TH:i', strtotime($consulta['data_hora'])) ?>" required><br><br>

        <label for="obs">Observações:</label><br>
        <textarea name="obs" id="obs" rows="4" cols="50"><?= htmlspecialchars($consulta['obs']) ?></textarea><br><br>

        <button type="submit">Salvar</button>
    </form>

    <p><a href="index-consultas.php">Voltar para lista de consultas</a></p>
</body>
</html>
