<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Optimización de Rutas de Recolección</title>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-o4MVEho0Lu6LZEoO0IsFWad0cHpTBPCjgxWOxFQDaHE=" crossorigin=""/>
<link rel="stylesheet" href="style.css">
</head>
<body>
<div id="container">
 <div id="map"></div>
 <div id="controls">
  <h1>Recolección Sostenible</h1>
  <form id="params">
   <label>Capacidad del Camión (kg):<br><input type="number" id="capacidad" required></label><br>
   <label>Meta Total a Recoger (kg):<br><input type="number" id="meta" required></label><br>
   <label>Frecuencia de Visita (opcional):<br><input type="text" id="frecuencia"></label><br>
   <button type="button" id="calc">Calcular Ruta Óptima</button>
  </form>
  <table id="resultados"></table>
 </div>
</div>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-Vt8yoYxPHTR31LIXdRWyhGoGuO6WrAKhT2W2J5xighM=" crossorigin=""></script>
<script src="map.js"></script>
</body>
</html>
