<?php
  require_once "/usr/local/lib/php/vendor/autoload.php";
  
  include("bd.php");

  $loader = new \Twig\Loader\FilesystemLoader('templates');
  $twig = new \Twig\Environment($loader);

  //Asegurarnos del parametro ev que llega para evitar consultas icorrectas a la BD
  if(isset ($_GET['ev'])){ //Si está definida la variable ev
    $idEv = $_GET['ev']; //Se toma el id
  }
  else{ //Si no lo está
    $idEv = -1; //Se toma id -1 que no existe en la BD
  }

  //Consultamos al modelo por el evento requerido
  $evento = getEvento($idEv);

  //Consultamos al modelo por las imagenes del evento requerido
  $imagenes = getImagenesGaleria($idEv);

  //Renderizar la pagina
  echo $twig->render('evento_imprimir.html', ['evento' => $evento, 'imagenes' => $imagenes]);

?>
