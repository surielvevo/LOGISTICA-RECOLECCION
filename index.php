<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Optimización de Rutas de Recolección</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-o4MVEho0Lu6LZEoO0IsFWad0cHpTBPCjgxWOxFQDaHE=" crossorigin=""/>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div id="app">
    <div id="map"></div>
    <div id="panel">
        <h1>Recolección Sostenible</h1>
        <p>Seleccione negocios en el mapa y complete los parámetros para calcular las rutas.</p>
        <form id="params">
            <label>Capacidad del camión (kg)
                <input type="number" id="capacidad" min="1" required>
            </label>
            <label>Meta total a recoger (kg)
                <input type="number" id="meta" min="0">
            </label>
            <label>Frecuencia de visita
                <input type="text" id="frecuencia">
            </label>
            <button type="button" id="calc">Calcular Ruta Óptima</button>
        </form>
        <div id="resumen"></div>
        <table id="tabla"></table>
    </div>
</div>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-Vt8yoYxPHTR31LIXdRWyhGoGuO6WrAKhT2W2J5xighM=" crossorigin=""></script>
<script src="map.js"></script>
</body>
</html>
