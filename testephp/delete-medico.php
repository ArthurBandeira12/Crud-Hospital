<?php

require_once 'dbteste.php';

$id = $_GET['id'];

$stmt = $pdo->prepare("DELETE FROM medicos WHERE id = ?");

$stmt->execute([$id]);



exit();
?>