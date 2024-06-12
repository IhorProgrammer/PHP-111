<?php
$uri = $_SERVER['REQUEST_URI'] ;
$pos = strpos( $uri, '?' ) ;
if( $pos > 0 ) {
    $uri = substr( $uri, 0, $pos );
}
else{
    $uri = substr($uri, 1);
}



if($uri != ""){
    $filename = "./wwwroot/{$uri}";
    if( is_readable( $filename ) ) { // запит uri це існуючий файл
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        // echo $ext ; exit ; перевірка як відправляє розширення .png or png
        unset( $content_type );
        switch ($ext) {
            case 'png':
            case 'gif':
            case 'bmp': 
                $content_type = "image/{$ext}"; break;
            case 'jpg':
            case 'jpeg': 
                $content_type = "image/jpeg"; break;
            case 'html':
            case 'css':
                $content_type = "text/{$ext}"; break;
            case 'js':
                $content_type = "text/javascript"; break;
        }
        if ( isset( $content_type ) ) {
            header( "Content-Type: {$content_type}");
            if( is_readable( $filename ) ) { // запит uri це існуючий файл
                readfile( $filename ); //передає тіло файлу до HTTP-відповіді
            }
            exit; //кінець файлу
        }
    }
}

$routes = [
    '' => 'index.php',
    'basics' => 'basics.php',
    'regexp' => 'regexp.php',
    'layout' => 'layout.php',
    'api' => 'api.php',
    'reg' => 'signup.php',
];
if ( isset( $routes[ $uri ]) ){
    $page_body = $routes[ $uri ];
    include '_layout.php';
    exit;
}
else
{
    $uri_name = ucfirst($uri); //перша літера в Upercase
    $controler_name = "{$uri_name}Controller";
    $controler_path = "./controllers/{$controler_name}.php";
    if( is_readable( $controler_path ) ) {
        include $controler_path;
        $controler_object = new $controler_name();
        $controler_object->serve();
        exit;
    }
}

http_response_code( 404 ) ;
echo "Not found";
exit; //кінець файлу
