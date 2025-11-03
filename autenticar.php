<?php
session_start();
ob_clean();
header('Content-Type: application/json');

$arquivo = 'usuarios.json';
$usuarios = file_exists($arquivo) ? json_decode(file_get_contents($arquivo), true) : [];

$cpf = $_POST['cpf'] ?? '';
$password = $_POST['password'] ?? '';
$action = $_POST['action'] ?? '';

if ($action === 'entrar') {
    $find = false;
    foreach ($usuarios as $u) {
        if ($u['cpf'] === $cpf && $u['password'] === md5($password)) {
            $find = true;
            $_SESSION['usuario_id'] = $u['id'];
            break;
        }
    }
    echo json_encode($find ? ['success' => true, 'msg' => 'Login efetuado com sucesso!'] : ['success' => false, 'msg' => 'Usuário ou senha incorretos!']);
    exit;
}

if ($action === 'cadastrar') {
    $exists = false;
    foreach ($usuarios as $user) {
        if ($user['cpf'] === $cpf) {
            $exists = true;
            break;
        }
    }

    if ($exists) {
        echo json_encode(['success' => false, 'msg' => 'Usuário já existe!']);
    } else {
        $novoUsuario = [
            'id' => count($usuarios) + 1,
            'cpf' => $cpf,
            'password' => md5($password),
            'saldo' => 0.0,
            'historico' => []
        ];
        $usuarios[] = $novoUsuario;
        file_put_contents($arquivo, json_encode($usuarios, JSON_PRETTY_PRINT));
        $_SESSION['usuario_id'] = $novoUsuario['id'];
        echo json_encode(['success' => true, 'msg' => 'Cadastro efetuado com sucesso!']);
    }
    exit;
}