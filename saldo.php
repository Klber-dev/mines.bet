<?php
session_start();

$arquivo = 'usuarios.json';
$usuarios = file_exists($arquivo) ? json_decode(file_get_contents($arquivo), true) : [];

$valor = floatval($_POST['valor'] ?? 0);
$action = $_POST['action'] ?? "";
$usuario_id = $_SESSION['usuario_id'] ?? null;

if (!$usuario_id) {
    header('Location: index.php?erro=session');
    exit;
}

$sucesso = false;
$erro = "";

foreach ($usuarios as &$usuario) {
    if ($usuario['id'] === $usuario_id) {

        if ($action === 'depositar') {
            if ($valor <= 0) {
                $erro = 3;
                break;
            }
            $usuario['saldo'] += $valor;
            $usuario['historico'][] = "Depositou RS$" . number_format($valor, 2, ',', '.');
            $sucesso = true;
        }

        if ($action === 'sacar') {
            if ($usuario['saldo'] < $valor || $usuario['saldo'] < 0) {
                $erro = 1;
            } else if($valor <= 0){
                $erro = 2;
            }else {
                $usuario['saldo'] -= $valor;
                $usuario['historico'][] = "Sacou RS$" . number_format($valor, 2, ',', '.');
                $sucesso = true;
            }
        }

        break;
    }
}

if ($sucesso) {
    file_put_contents($arquivo, json_encode($usuarios, JSON_PRETTY_PRINT));
    header('Location: perfil.php');
    exit;
} else {
    header('Location: perfil.php?erro=' . $erro);
    exit;
}




