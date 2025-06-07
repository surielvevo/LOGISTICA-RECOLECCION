<?php
// Datos recibidos desde el frontend
$input=json_decode(file_get_contents('php://input'),true);
$points=$input['puntos']??[];
$capacity=floatval($input['capacidad']??0);
$capacity=$capacity>0?$capacity:INF;
$goal=floatval($input['meta']??0);

$depot=['lat'=>18.463351,'lng'=>-69.933409,'nombre'=>'Depósito'];

function haversine($a,$b){
    $R=6371; // km
    $dLat=deg2rad($b['lat']-$a['lat']);
    $dLon=deg2rad($b['lng']-$a['lng']);
    $lat1=deg2rad($a['lat']);
    $lat2=deg2rad($b['lat']);
    $a1=sin($dLat/2)**2 + sin($dLon/2)**2*cos($lat1)*cos($lat2);
    return 2*$R*atan2(sqrt($a1),sqrt(1-$a1));
}

function sweep($points,$cap,$depot){
    foreach($points as &$p){
        $p['ang']=atan2($p['lat']-$depot['lat'],$p['lng']-$depot['lng']);
    }
    usort($points,fn($a,$b)=>$a['ang']<=>$b['ang']);
    $routes=[];
    while($points){
        $route=[];$load=0;$dist=0;$pos=$depot;$indexes=[];
        foreach($points as $i=>$p){
            if($load+$p['demanda']>$cap)continue;
            $dist+=haversine($pos,$p);$pos=$p;$load+=$p['demanda'];
            $route[]=$p;$indexes[]=$i;
        }
        $dist+=haversine($pos,$depot);
        $line=[[$depot['lat'],$depot['lng']]];
        foreach($route as $rp){$line[]=[floatval($rp['lat']),floatval($rp['lng'])];}
        $line[]=[$depot['lat'],$depot['lng']];
        $routes[]=['paradas'=>$route,'distancia'=>$dist,'carga'=>$load,'linea'=>$line];
        rsort($indexes);
        foreach($indexes as $ix){array_splice($points,$ix,1);}
    }
    return $routes;
}

$empty=['rutas'=>[],'total'=>0,'alerta'=>'No hay puntos registrados'];
if(!$points){
    echo json_encode($empty);
    exit;
}
$routes=sweep($points,$capacity,$depot);
$total=0;foreach($routes as $r)$total+=$r['carga'];
$alert='';
if($goal>0 && $total>$goal)$alert='Se supera la meta total.';
header('Content-Type: application/json');
echo json_encode(['rutas'=>$routes,'total'=>$total,'alerta'=>$alert]);
