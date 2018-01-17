<?php

  const SUCCESS = 0;
  const WARNING = 1;
  const ERROR = 2;
  
  ini_set('mysql.connect_timeout','5');   
  ini_set('max_execution_time', '5');   
  
  function gen_response_with_json($return_code, $result_data){
    return "{\"return_code\": ".$return_code.",\"result_data\": ".$result_data."}";
  }
  
  function gen_response($return_code, $result_data){
    $response = array('retrun_code' => $return_code, 'result_data'=> $result_data);
    $array = array_map('htmlentities',$response);
    $json = html_entity_decode(json_encode($array)); 
    
    return $json;
  }
  
  function api_mysql($host, $user, $pass, $db){
    $con = mysqli_connect($host, $user, $pass, $db, 3306);
    
    // Check connection
    if (mysqli_connect_errno())
    {
      echo gen_response(ERROR, "Failed to connect to MySQL: " . mysqli_connect_error());
      mysqli_close($con);
      return ;
    }
    
    $sql = "select * from uhosnet_news limit 1";
    $result = mysqli_query($con, $sql);
    
    if( !$result ){
      echo gen_response(WARNING, "no result" );
    }else{
      $dataRow = $result->fetch_array(MYSQLI_ASSOC);
      echo gen_response_with_json(SUCCESS, json_encode($dataRow));
    }
    
    mysqli_close($con);
  }
  
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
      echo gen_response(ERROR, "service unavialable");
    }else{
      echo gen_response_with_json(SUCCESS, json_encode($result)); 
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
      echo gen_response(ERROR, "service unavialable");
    }else{
      echo gen_response_with_json(SUCCESS, json_encode($result)); 
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
      echo gen_response(ERROR, "service unavialable");
    }else{
      echo gen_response_with_json(SUCCESS, json_encode($result)); 
    }
  }
  
  $headers = array('Content-Type: application/json','Connection: keep-alive','Connection: close');
  $method = $_POST['method'];
	$udata = $_POST['data'];
  $url = $_POST['url'];

  // Main Function
  if( $method == "GET" ){
    api_get($url, $headers);
  }else if( $method == "POST" ){
    api_post($url, $udata, $headers);
  }else if( $method == "PUT"){
    api_put($url, $udata, $headers);
  }else if( $method == "DB"){
    $host = "10.111.8.74";
    $user = "uhosnet";
    $pass = "uhosnet";
    $db = "uhosnet_db";
    api_mysql($host, $user, $pass, $db);
  }else{
    echo gen_response(SUCCESS, "Not support this method : ".$method );
  }

?>
