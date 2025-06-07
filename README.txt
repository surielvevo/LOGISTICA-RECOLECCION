Plataforma para optimizar rutas de recolección (CVRP) usando PHP puro.

Pasos de uso
------------
1. Copie los archivos en la carpeta `public_html` de su servidor (PHP 7.4 o superior).
2. Abra `index.php` en un navegador.
3. Haga clic en el mapa para registrar negocios indicando nombre y demanda estimada.
4. Ingrese la capacidad de su camión y, si desea, la meta total que planea recolectar.
5. Presione **Calcular Ruta Óptima**. Se ejecutará una heurística tipo *Sweep* que genera las rutas y la distancia aproximada.
6. Las rutas se dibujarán en el mapa y se mostrarán en una tabla con la carga recogida.

Detalles
--------
- Las distancias se calculan con la fórmula de Haversine.
- No se emplean bases de datos: los puntos se envían por POST y se procesan en memoria.
- Diseñado para experimentos y tesis en logística sostenible. Compatible con hosting compartido como SiteGround.
