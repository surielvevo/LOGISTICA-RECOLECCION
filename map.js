const puntos=[];
const lineas=[];
const map=L.map('map').setView([18.463351,-69.933409],15);
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',{maxZoom:19}).addTo(map);
L.marker([18.463351,-69.933409]).addTo(map).bindPopup('UASD - Depósito');

map.on('click',e=>{
    const nombre=prompt('Nombre del negocio:');
    if(!nombre)return;
    const demanda=parseFloat(prompt('Demanda (kg):','10'));
    if(isNaN(demanda))return;
    L.marker(e.latlng).addTo(map).bindPopup(`${nombre} - ${demanda} kg`);
    puntos.push({lat:e.latlng.lat,lng:e.latlng.lng,nombre,demanda});
});

document.getElementById('calc').addEventListener('click',()=>{
    const capacidad=parseFloat(document.getElementById('capacidad').value)||0;
    const meta=parseFloat(document.getElementById('meta').value)||0;
    const frecuencia=document.getElementById('frecuencia').value||'';
    fetch('logic.php',{
        method:'POST',
        headers:{'Content-Type':'application/json'},
        body:JSON.stringify({puntos,capacidad,meta,frecuencia})
    })
    .then(r=>r.json())
    .then(mostrarResultados);
});

function mostrarResultados(data){
    lineas.forEach(l=>map.removeLayer(l));
    lineas.length=0;
    const resumen=document.getElementById('resumen');
    resumen.textContent=data.total?`Total recogido: ${data.total} kg`:'';
    const tabla=document.getElementById('tabla');
    tabla.innerHTML='';
    if(data.alerta)alert(data.alerta);
    data.rutas.forEach((r,i)=>{
        const header=document.createElement('tr');
        const th=document.createElement('th');
        th.colSpan=2;
        th.textContent=`Ruta ${i+1} - ${r.distancia.toFixed(2)} km`;
        header.appendChild(th);
        tabla.appendChild(header);
        r.paradas.forEach(p=>{
            const row=document.createElement('tr');
            row.innerHTML=`<td>${p.nombre}</td><td>${p.demanda} kg</td>`;
            tabla.appendChild(row);
        });
        const polyline=L.polyline(r.linea,{color:'red'}).addTo(map);
        lineas.push(polyline);
    });
}
