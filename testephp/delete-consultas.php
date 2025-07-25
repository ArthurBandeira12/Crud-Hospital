<?php
require_once 'dbteste.php';
require_once 'authenticate.php';

$id = $_GET['id'] ?? null;

if (!$id) {
    echo "ID da consulta não fornecido.";
    exit();
}

$stmt = $pdo->prepare("DELETE FROM consultas WHERE id = ?");
$stmt->execute([$id]);

header("Location: index-consultas.php");
exit();
?>