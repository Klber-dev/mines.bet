<?php
$bombas = isset($_GET['bombas']) ? intval($_GET['bombas']) : 3;
if ($bombas < 3) $bombas = 3;
if ($bombas > 8) $bombas = 8;

$matriz = array_fill(0, 3, array_fill(0, 3, 0));
$total_casas = 9;
$indices = range(0, $total_casas - 1);

shuffle($indices);


for ($i = 0; $i < $bombas; $i++) {
    $index = $indices[$i];
    $linha = intdiv($index, 3);
    $coluna = $index % 3;
    $matriz[$linha][$coluna] = 1;
}


header('Content-Type: application/json');
echo json_encode(['matriz' => $matriz]);


/* Gays amam Pau marca = GAP */