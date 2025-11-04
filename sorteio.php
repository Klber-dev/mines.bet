<?php
$premios = ["imagens/diamante.png", "🥮", "🍒", "🍇", "🔔", "🍀", "💰", "⭐", "🎁"];
shuffle($premios);
$resultado = array_slice($premios, 0, 3);
echo json_encode($resultado);
?>
