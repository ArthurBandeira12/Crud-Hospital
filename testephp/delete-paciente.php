<?php
require_once 'dbteste.php';


if (isset($_GET['id'])) {
    $id = $_GET['id'];

   
    $stmt = $pdo->prepare("DELETE FROM pacientes WHERE id = ?");
    $stmt->execute([$id]);

    
    header("Location: index-paciente.php");
    exit;
} else {
    echo "ID do paciente não especificado.";
}
?>
