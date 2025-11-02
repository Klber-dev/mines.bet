<?php
session_start();

$arquivo = 'usuarios.json';
$usuarios = file_exists($arquivo) ? json_decode(file_get_contents($arquivo), true) : [];
if (!is_array($usuarios)) $usuarios = [];

$valor = $_POST['valor'] ?? "";
$action = $_POST['action'] ?? "";

if ($action === 'depositar'){
    
}


?>