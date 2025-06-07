<?php
$data = json_decode(file_get_contents('php://input'), true);
$puntos = $data['puntos'] ?? [];
$cap = floatval($data['capacidad'] ?? 0);
if ($cap <= 0) $cap = INF;
$meta = floatval($data['meta'] ?? 0);
$depot = ['lat' => 18.463351, 'lng' => -69.933409, 'nombre' => 'Deposito'];
function distancia($a, $b) {
    $R = 6371;
    $dLat = deg2rad($b['lat'] - $a['lat']);
    $dLon = deg2rad($b['lng'] - $a['lng']);
    $lat1 = deg2rad($a['lat']);
    $lat2 = deg2rad($b['lat']);
    $a1 = sin($dLat/2)**2 + sin($dLon/2)**2 * cos($lat1) * cos($lat2);
    return 2 * $R * atan2(sqrt($a1), sqrt(1 - $a1));
}
if (!$puntos) { echo json_encode(['alerta' => 'No hay puntos registrados']); exit; }
foreach ($puntos as &$p) { $p['angulo'] = atan2($p['lat'] - $depot['lat'], $p['lng'] - $depot['lng']); }
usort($puntos, function($a, $b) { return $a['angulo'] <=> $b['angulo']; });
$rutas = []; $lineas = []; $total = 0;
while ($puntos) {
    $ruta = []; $carga = 0; $dist = 0; $pos = $depot; $indices = [];
    foreach ($puntos as $i => $p) {
        if ($carga + $p['demanda'] > $cap) continue;
        $dist += distancia($pos, $p); $pos = $p; $carga += $p['demanda'];
        $ruta[] = $p; $indices[] = $i;
    }
    $dist += distancia($pos, $depot); $total += $carga;
    $rutas[] = ['paradas' => $ruta, 'distancia' => $dist];
    $linea = [[$depot['lat'], $depot['lng']]];
    foreach ($ruta as $p) { $linea[] = [floatval($p['lat']), floatval($p['lng'])]; }
    $linea[] = [$depot['lat'], $depot['lng']];
    $lineas[] = $linea;
    foreach (array_reverse($indices) as $idx) { array_splice($puntos, $idx, 1); }
}
$alerta = ($total > $meta && $meta > 0) ? 'Se supera la meta total.' : '';
header('Content-Type: application/json');
echo json_encode(['rutas' => $rutas, 'lineas' => $lineas, 'alerta' => $alerta, 'total' => $total]);
