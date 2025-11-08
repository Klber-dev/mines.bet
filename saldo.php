<?php
session_start();

$arquivo = 'usuarios.json';
$usuarios = file_exists($arquivo) ? json_decode(file_get_contents($arquivo), true) : [];

$valor = $_POST['valor'] ?? 0;
$valor = str_replace(',', '.', $valor);
$valor = floatval($valor);
$action = $_POST['action'] ?? "";
$usuario_id = $_SESSION['usuario_id'] ?? null;

if (!$usuario_id) {
    if ($action === 'jogo') {
        echo json_encode(['sucesso' => false, 'erro' => 'session']);
        exit;
    } else {
        header('Location: index.php?erro=session');
        exit;
    }
}

$sucesso = false;
$erro = "";

foreach ($usuarios as &$usuario) {
    if ($usuario['id'] === $usuario_id) {

        // DEPÓSITO
        if ($action === 'depositar') {
            if ($valor <= 0) {
                $erro = 3;
            } else {
                $usuario['saldo'] += $valor;
                $usuario['historico'][] = "Depositou R$" . number_format($valor, 2, ',', '.');
                $sucesso = true;
            }

            if ($sucesso) {
                file_put_contents($arquivo, json_encode($usuarios, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
                header('Location: perfil.php');
                exit;
            } else {
                header('Location: perfil.php?erro=' . $erro);
                exit;
            }
        }

        // SACAR
        if ($action === 'sacar') {
            if ($usuario['saldo'] < $valor || $usuario['saldo'] < 0) {
                $erro = 1; // saldo insuficiente
            } else if ($valor <= 0) {
                $erro = 2; // valor inválido
            } else {
                $usuario['saldo'] -= $valor;
                $usuario['historico'][] = "Sacou R$" . number_format($valor, 2, ',', '.');
                $sucesso = true;
            }

            if ($sucesso) {
                file_put_contents($arquivo, json_encode($usuarios, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
                header('Location: perfil.php');
                exit;
            } else {
                header('Location: perfil.php?erro=' . $erro);
                exit;
            }
        }

        // JOGO (via AJAX/fetch)
        if ($action === 'jogo') {
            $resultado = $_POST['resultado'] ?? '';
            $multiplicador = floatval($_POST['multiplicador'] ?? 1);

            if ($valor <= 0) {
                echo json_encode(['sucesso' => false, 'erro' => 'Valor inválido']);
                exit;
            }

            if ($resultado === 'lose') {
                if ($usuario['saldo'] < $valor) {
                    echo json_encode(['sucesso' => false, 'erro' => 'Saldo insuficiente']);
                    exit;
                }
                $usuario['saldo'] -= $valor;
                $usuario['historico'][] = "Perdeu R$" . number_format($valor, 2, ',', '.');
            } elseif ($resultado === 'win') {
                $ganho = $valor * $multiplicador;
                $usuario['saldo'] += $ganho;
                $usuario['historico'][] = "Ganhou R$" . number_format($ganho, 2, ',', '.') .
                    " (Aposta R$" . number_format($valor,2,',','.') . " x" . number_format($multiplicador,2,'.','') . ")";
            } else {
                echo json_encode(['sucesso' => false, 'erro' => 'Resultado inválido']);
                exit;
            }

            file_put_contents($arquivo, json_encode($usuarios, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
            echo json_encode(['sucesso' => true, 'novoSaldo' => $usuario['saldo']]);
            exit;
        }

        break;
    }
}

if ($action === 'jogo') {
    echo json_encode(['sucesso' => false, 'erro' => 'Usuário não encontrado']);
} else {
    header('Location: perfil.php?erro=4');
}

//Se vc n entender bulhufas pergunta pro oráculo