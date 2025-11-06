<?php
$simbolos = ["💎", "🥮", "🍒", "🍇", "🔔"];
$resultado = [
    $simbolos[array_rand($simbolos)],
    $simbolos[array_rand($simbolos)],
    $simbolos[array_rand($simbolos)]
];
echo json_encode($resultado);
?>
