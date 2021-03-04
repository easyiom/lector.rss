<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="img/rss.jpg" type="image/x-icon">
    <title>Investing.com</title>
    <link rel="stylesheet" type="text/css" href="css/styles.css">
</head>
<body>
    <!--formulario para añadir la URL a leer-->
    <header>
    <div class="form-style-5">
        <form method="POST" action="">
            <input type="text" name="feedurl" placeholder="Introduce aquí tu feed">
        </form>
    </div>
    <?php
    //URL a leer por defecto
    $url = "http://feeds.weblogssl.com/xataka2";
    if(isset($_POST['submit'])){
        if($_POST['feedurl'] != ''){
            $url = $_POST['feedurl'];
        }
    }
    
    $invalidurl = false;
    //Comprobamos si la URL es correcta. 
    if(@simplexml_load_file($url)){
        $feeds = simplexml_load_file($url);
    }else{
        $invalidurl = true;
        echo '<h2>URL de feed RSS incorrecto.</h2>';
        echo '<h3>No te olvides de incluir el protocolo http(s)</h3>';
    }
    $i=0;
    //Comprobamos si la URL está vacía. Continúa si no está vacía. De lo contrario pasa al else.
    if(!empty($feeds)){
        //Descripción del canal
        $site = $feeds->channel->title;
        $sitelink = $feeds->channel->link;
        //TITULO WEB
        echo '<div class="">'.$site.'</div>';
        echo '</header>';
        //Por cada noticia:
        foreach ($feeds->channel->item as $item) {
            //Creamos variables con información de la noticia
            $title = $item->title;
            $link = $item->link;
            $description = $item->description;
            $postDate = $item->pubDate;
            $pubDate = date('D, d M Y',strtotime($postDate));
            if($i>=10) break; //5 es el número de noticias a mostrar
    
            //Mostramos información por pantalla de la noticia
            //Título de la noticia
        echo '<div class="centrado">';
        echo '<div class="row">';
        //FOTO
            echo '<div class="column" id="foto">';
                echo '<div class="image description">'.$description.'</div>';
            echo '</div>';

        //TEXTO
            echo '<div class="column" id="texto">';
                
                
                echo '<h2 ><a class="titular" href="'.$link.'" class="titular">'.$title.'</a></h2>';
                echo '<div class="detalles">';
                    echo '<div class="editor"><p>'.$site.' - '.$pubDate.'</p></div>';
                echo '</div>';
                $text= implode(' ', array_slice(explode(' ', $description), 0, 62)) . "...";
                echo '<div class="noneImg">'.$text. '</div>';
                echo '<div class="image oculimg b">'.$description.'</div>';

            echo '</div>';
            
        echo '</div>';
        echo '</div>';

            //Cuerpo de la noticia
            //echo implode(' ', array_slice(explode(' ', $description), 0, 20)) . "...";
            $i++;
        }
    }else{
        //Error que se muestra si no hay nada que mostrar
        if(!$invalidurl){
            echo '<h2>No se encontró nada que mostrar</h2>';
        }
    }
    ?>
</body>
</html>