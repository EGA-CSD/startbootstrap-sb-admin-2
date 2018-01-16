<?php
  
  function api_get( $url, $headers ){
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5); 
    curl_setopt($ch, CURLOPT_TIMEOUT, 30); //timeout in seconds
    $result = curl_exec($ch);
    curl_close($ch);
    
    if( $result == NULL ){
      echo "service unavialable";
    }else{
      echo $result; 
    }
    
  }
  
  function api_post($url, $data, $headers){
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5); 
    curl_setopt($ch, CURLOPT_TIMEOUT, 30); //timeout in seconds
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    $result = curl_exec($ch);
    curl_close($ch);
    if( $result == NULL ){
      echo "service unavialable";
    }else{
      echo $result; 
    }
  }
  
  function api_put($url, $data, $headers){
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5); 
    curl_setopt($ch, CURLOPT_TIMEOUT, 30); //timeout in seconds
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    $result = curl_exec($ch);
    curl_close($ch);
    if( $result == NULL ){
      echo "service unavialable";
    }else{
      echo $result; 
    }
  }
  
  $headers = array('Content-Type: application/json','Connection: keep-alive','Connection: close');
  $method = $_POST['method'];
	$udata = $_POST['data'];
  $url = $_POST['url'];
 
  if( $method == "GET" ){
    api_get($url, $headers);
  }else if( $method == "POST" ){
    api_post($url, $udata, $headers);
  }else if( $method == "PUT"){
    api_put($url, $udata, $headers);
  }else{
    echo "Not support this method : ".$method;
  }
?>
