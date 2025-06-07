let puntos=[];
const map=L.map('map').setView([18.463351,-69.933409],15);
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',{maxZoom:19}).addTo(map);
L.marker([18.463351,-69.933409]).addTo(map).bindPopup('UASD - Depósito').openPopup();
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
 fetch('logic.php',{method:'POST',headers:{'Content-Type':'application/json'},
 body:JSON.stringify({puntos,capacidad,meta,frecuencia})})
 .then(r=>r.json()).then(mostrarResultados);
});
function mostrarResultados(data){
 const tabla=document.getElementById('resultados');
 tabla.innerHTML='';
 if(data.alerta)alert(data.alerta);
 if(data.rutas){data.rutas.forEach((r,i)=>{
  const tr=document.createElement('tr');
  const th=document.createElement('th');th.colSpan=2;th.textContent=`Ruta ${i+1} - ${r.distancia.toFixed(2)} km`;
  tr.appendChild(th);
  tabla.appendChild(tr);
  r.paradas.forEach(p=>{
   const trp=document.createElement('tr');
   const td1=document.createElement('td');td1.textContent=p.nombre;
   const td2=document.createElement('td');td2.textContent=p.demanda+' kg';
   trp.appendChild(td1);trp.appendChild(td2);
   tabla.appendChild(trp);
  });
 });}
 if(data.lineas){data.lineas.forEach(l=>L.polyline(l,{color:'red'}).addTo(map));}
}
