<?php
    include "../conn.php";
    $key = "9e13a422c0564c5db702ad4de7330866";
    $endpoint = 'https://api.cognitive.microsoft.com/bing/v7.0/images/search';

    function BingImageSearch ($url, $key, $query) { //Funcion de la API BING IMAGE SEARCH para buscar imagenes de los productos
        // Prepare HTTP request
        // NOTE: Use the key 'http' even if you are making an HTTPS request. See:
        // http://php.net/manual/en/function.stream-context-create.php
        $headers = "Ocp-Apim-Subscription-Key: $key\r\n";
        $options = array ( 'http' => array (
                                'header' => $headers,
                                'method' => 'GET' ));
    
        // Perform the Web request and get the JSON response
        $context = stream_context_create($options);
        $result = file_get_contents($url . "?q=" . urlencode($query), false, $context);
    
        // Extract Bing HTTP headers
        $headers = array();
        foreach ($http_response_header as $k => $v) {
            $h = explode(":", $v, 2);
            if (isset($h[1]))
                if (preg_match("/^BingAPIs-/", $h[0]) || preg_match("/^X-MSEdge-/", $h[0]))
                    $headers[trim($h[0])] = trim($h[1]);
        }
    
        return array($headers, $result);
    }

    $index = 0;
    $tipo = $con -> query("SELECT * FROM `tipo` WHERE `nombre` = '".$_POST["tipo"]."'");
    if(($tipo -> num_rows) > 0){
        $index = ($tipo -> fetch_row())[0];
    }else{
        $con -> query("INSERT INTO `tipo`(`nombre`) VALUES ('{$_POST["tipo"]}')");
        $index = $con -> insert_id;
    }

    $insert = $con -> query("INSERT INTO `productos`(`nombre`, `cantidad`, `marca`, `precio`, `id_tipo`) 
                    VALUES ('{$_POST["name"]}',{$_POST["cant"]},'{$_POST["marca"]}',{$_POST["precio"]},{$index})");

    if(!$insert){
        echo "Ha ocurrido un error.";
    }else{
        list($headers, $json) = BingImageSearch($endpoint, $key, $_POST["name"]);
        $json = json_decode($json);
        $url_to_image = $json->value[0]->contentUrl;
        $my_save_dir = '../assets/';
        $filename = $con -> insert_id;;
        $complete_save_loc = $my_save_dir . $filename . ".jpeg";
        file_put_contents($complete_save_loc, file_get_contents($url_to_image));
        echo "Se a insertado existosamente.";
    }
?>