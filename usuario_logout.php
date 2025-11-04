<?php
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header('Location: index.php');
    exit;
}

$arquivo = 'usuarios.json';
$action = $_POST['action'];
$usuarios = file_exists($arquivo) ? json_decode(file_get_contents($arquivo), true) : [];


$usuario_id = $_SESSION['usuario_id'];

if ($action === 'excluir') {
    $usuarios = array_filter($usuarios, function ($usuario) use ($usuario_id) {
        return $usuario['id'] != $usuario_id;
    });

    $usuarios = array_values($usuarios);
    file_put_contents($arquivo, json_encode($usuarios, JSON_PRETTY_PRINT));

    session_destroy();
    header('location: index.php');
    exit;
}

if($action === 'logout'){
    session_destroy();
    header('location:index.php');
    exit;
}

