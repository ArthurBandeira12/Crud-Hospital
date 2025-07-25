<?php
require_once 'dbteste.php';
require_once 'authenticate.php';


$medicos = $pdo->query("SELECT * FROM medicos")->fetchAll(PDO::FETCH_ASSOC);

$pacientes = $pdo->query("SELECT * FROM pacientes")->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $medicos_id = $_POST['medicos_id'];
    $pacientes_id = $_POST['pacientes_id'];
    $data_hora = $_POST['data_hora'];
    $obs = $_POST['obs'];

    $stmt = $pdo->prepare("INSERT INTO consultas (medicos_id, pacientes_id, data_hora, obs) VALUES (?, ?, ?, ?)");
    $stmt->execute([$medicos_id, $pacientes_id, $data_hora, $obs]);

    header("Location: index-consultas.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Registrar Consulta</title>
    <link rel="stylesheet" href="./css/style.css">
</head>
<body>
    <h1>Registrar Nova Consulta</h1>
    <form method="POST">
        <label for="medicos_id">Médico:</label>
        <select name="medicos_id" id="medicos_id" required>
            <?php foreach ($medicos as $medico): ?>
                <option value="<?= $medico['id'] ?>"><?= htmlspecialchars($medico['nome']) ?> (<?= htmlspecialchars($medico['especialidade']) ?>)</option>
            <?php endforeach; ?>
        </select>

        <label for="pacientes_id">Paciente:</label>
        <select name="pacientes_id" id="pacientes_id" required>
            <?php foreach ($pacientes as $paciente): ?>
                <option value="<?= $paciente['id'] ?>"><?= htmlspecialchars($paciente['nome']) ?></option>
            <?php endforeach; ?>
        </select>

        <label for="data_hora">Data e Hora:</label>
        <input type="datetime-local" name="data_hora" id="data_hora" required>

        <label for="obs">Observações:</label>
        <textarea name="obs" id="obs" rows="4" cols="50"></textarea>

        <button type="submit">Registrar Consulta</button>
    </form>
</body>
</html>
