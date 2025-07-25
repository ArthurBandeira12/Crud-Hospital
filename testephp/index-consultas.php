<?php
require_once 'dbteste.php';
require_once 'authenticate.php';

$stmt = $pdo->query("
    SELECT c.*, 
           m.nome AS nome_medico, 
           m.especialidade,
           p.nome AS nome_paciente
    FROM consultas c
    LEFT JOIN medicos m ON c.medicos_id = m.id
    LEFT JOIN pacientes p ON c.pacientes_id = p.id
    ORDER BY c.data_hora DESC
");
$consultas = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Consultas</title>
</head>
<body>
    <h1>Lista de Consultas</h1>
    <a href="criarconsultas.php">Nova Consulta</a>

    <table border="1" cellpadding="5">
        <thead>
            <tr>
                <th>Médico</th>
                <th>Especialidade</th>
                <th>Paciente</th>
                <th>Data e Hora</th>
                <th>Observações</th>
                
            </tr>
        </thead>
        <tbody>
            <?php foreach ($consultas as $consulta): ?>
                <tr>
                    <td><?= htmlspecialchars($consulta['nome_medico']) ?></td>
                    <td><?= htmlspecialchars($consulta['especialidade']) ?></td>
                    <td><?= htmlspecialchars($consulta['nome_paciente']) ?></td>
                    <td><?= date('d/m/Y H:i', strtotime($consulta['data_hora'])) ?></td>
                    <td><?= nl2br(htmlspecialchars($consulta['obs'])) ?></td>
                    <td>
                        <a href="visu-consultas.php?id=<?= $consulta['id'] ?>">Visualizar</a> | 
                        <a href="edit-consultas.php?id=<?= $consulta['id'] ?>">Editar</a> | 
                        <a href="delete-consultas.php?id=<?= $consulta['id'] ?>" onclick="return confirm('Tem certeza que deseja excluir esta consulta?');">Excluir</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
