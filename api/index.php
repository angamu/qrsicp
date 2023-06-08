<?php

/*error_reporting(E_ALL);
ini_set('display_errors', '1');*/

$opc=$_REQUEST['accion'];

switch ($opc){
	default : "Error en datos!"; break;
    case 0 : getDatosProducto(); break;
    case 1 : setProductosQR(); break;
}

function getDatosProducto(){
    $producto=$_REQUEST['criterio'];
    $url="http://190.0.50.6:85/sicp/siteco/qr/dataproduct.php";
    
    $ch = curl_init();  
    $dataArray = ['accion'=>0, 'criterio'=>$producto];  
    $data = http_build_query($dataArray);  
    $getUrl = $url."?".$data;
  
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_URL, $getUrl);
    curl_setopt($ch, CURLOPT_TIMEOUT, 80);       
    $response = curl_exec($ch);
        
    if(curl_error($ch)){
        echo 'Request Error:' . curl_error($ch);
    }else{
        $dataencode=json_decode($response);
        if($dataencode->error == 0){   
            $datajson = json_decode($dataencode->data);
            echo json_encode(array('codigo'=>$datajson->cod, 'nombre'=>$datajson->nom, 'unidad'=>$datajson->und));
        } else {
            echo "error";
        }
    }       
    curl_close($ch);
}

function setProductosQR(){
    $productos=$_REQUEST['productos'];
    $url="http://190.0.50.6:85/sicp/siteco/qr/dataproduct.php";
    $ch = curl_init();  
    $dataArray = ['accion'=>1, 'listproducts'=>$productos];  
    $data = http_build_query($dataArray);  
    $getUrl = $url."?".$data;
  
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_URL, $getUrl);
    curl_setopt($ch, CURLOPT_TIMEOUT, 80);       
    $response = curl_exec($ch);
        
    if(curl_error($ch)){
        echo 'Request Error:' . curl_error($ch);
    }else{
        $dataencode=json_decode($response);
        if($dataencode->error == 0){   
            echo "success";
        } else {
            echo "error";
        }
    }       
    curl_close($ch);
}