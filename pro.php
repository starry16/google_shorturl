<?php
//1当提交的数据（$_REQUEST ['URL']）不存在，则它会响应一个错误消息（“请输入网址”）。
if(isset($_REQUEST['url'])&&!empty($_REQUEST['url'])){          
    //2   从$_REQUEST中得到URL。
    $longUrl = $_REQUEST['url'];  
    $apiKey  = 'AIzaSyB4LkURhXD4w6jl1KfstlFsDaGJ__GNBa8';     
    //3   创建一个JSON数据，包含URL和谷歌API密钥。这个JSON数据将被发送到Google作为请求参数。
    $postData = array('longUrl' => $longUrl, 'key' => $apiKey); 
    $jsonData = json_encode($postData);     
    //4    使用PHP的cURL连接谷歌API服务器。
    $curlObj = curl_init();   
    curl_setopt($curlObj, CURLOPT_URL, 'https://www.googleapis.com/urlshortener/v1/url'); 
    curl_setopt($curlObj, CURLOPT_RETURNTRANSFER, 1);  
    curl_setopt($curlObj, CURLOPT_SSL_VERIFYPEER, 0);  
    curl_setopt($curlObj, CURLOPT_HEADER, 0);   
    curl_setopt($curlObj, CURLOPT_HTTPHEADER, array('Content-type:application/json')); 
    curl_setopt($curlObj, CURLOPT_POST, 1); 
    curl_setopt($curlObj, CURLOPT_POSTFIELDS, $jsonData);    
    //5  从谷歌获取数据，并解码JSON对象。
    $response = curl_exec($curlObj);  
    $json = json_decode($response);    
    //6   关闭cURL连接
    curl_close($curlObj);  
    //7  如果返回数据有错误，就返回错误信息，否则显示短URL。
    if(isset($json->error)){    
        echo $json->error->message;    
    }else{      
        echo $json->id;   
    }    
}else{ 
    echo 'Please enter a URL';
}
?>
