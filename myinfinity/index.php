<?php
  require_once "/usr/local/lib/php/vendor/autoload.php";
   
  include("bd.php");

  $loader = new \Twig\Loader\FilesystemLoader('templates');
  $twig = new \Twig\Environment($loader);

  session_start();

  $usuario = array('nick' => 'defecto', 'tipo' => 'anonimo');

  if( isset($_SESSION['nick']) ){

    $user = getUser($_SESSION['nick']); 

    $usuario['nick']= $user['nick'];
    $usuario['tipo']= $user['tipo'];
  }
  else{

  }

  if(isset ($_GET['et'])){ //Si está definida la variable et
    $etiqueta = $_GET['et']; //Se toma la etiqueta

    //Consultamos al modelo por la imformacion de  los eventos con esa etiqueta
    $eventos = getEventosEtiqueta($etiqueta);
  }
  else{ //Si no lo está
    $etiqueta = -1; //Se toma id -1 que no existe en la BD

    //Consultamos al modelo por la imformacion de todos los eventos
    $eventos = getEventos();
  }

  //Gestion de los eventos
  if($_SERVER['REQUEST_METHOD'] === 'POST'){
   
    if(isset($_POST["eliminarevento"])) {
      $idEvento = $_POST['eliminarevento'];
      eliminarEvento($idEvento);
      header("Location: /");
    }


    if(isset($_POST["editarevento"])) {
      $idEvento = $_POST['editarevento'];
      header("Location: /editareventos.php/?ev=".$idEvento);
    }

    exit();
  }
  
  echo $twig->render('portada.html', ['eventos' => $eventos, 'usuario' => $usuario]);
?>
