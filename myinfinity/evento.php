<?php
  require_once "/usr/local/lib/php/vendor/autoload.php";
  
  include("bd.php");

  $loader = new \Twig\Loader\FilesystemLoader('templates');
  $twig = new \Twig\Environment($loader);
  
  $urlImprimir = "url por defecto";

  //1. Gestion de la sesion del usuario
  session_start();

  $usuario = array('nick' => 'defecto', 'tipo' => 'anonimo','nombre' => 'defecto','apellidos' => 'defecto','email' => 'defecto');

  if( isset($_SESSION['nick']) ){

      $user = getUser($_SESSION['nick']); 

      $usuario['nick']= $user['nick'];
      $usuario['tipo']= $user['tipo'];
      $usuario['nombre']= $user['nombre'];
      $usuario['apellidos']= $user['apellidos'];
      $usuario['email']= $user['email'];
  }
  else{
      //header("Location: login.php");
  }

  //2.Gestion de los eventos

  //Asegurarnos del parametro ev que llega para evitar consultas icorrectas a la BD
  if(isset ($_GET['ev'])){ //Si está definida la variable ev
    $idEv = $_GET['ev']; //Se toma el id
  }
  else{ //Si no lo está
    $idEv = -1; //Se toma id -1 que no existe en la BD
  }

  //Consultamos al modelo por el evento requerido
  $evento = getEvento($idEv);

  //Consultamos al modelo por las imagenes que forman parte de la galeria del evento requerido
  $imagenes = getImagenesGaleria($idEv);

  //Consultamos los comentarios del evento
  $comentarios = getComentarios($idEv);

  //Consultamos las palabras prohibidas
  $prohibidas = getPalabrasProhibidas();

  $urlImprimir = "/evento_imprimir.php/?ev=" . $idEv;

  //Renderizar la pagina
  echo $twig->render('evento.html', ['usuario' => $usuario,'evento' => $evento, 'imagenes' => $imagenes, 'comentarios' => $comentarios, 'urlImprimir' => $urlImprimir, 'prohibidas' => $prohibidas]);

?>
