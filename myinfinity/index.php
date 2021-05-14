<?php
  require_once "/usr/local/lib/php/vendor/autoload.php";
   
  include("bd.php");

  $loader = new \Twig\Loader\FilesystemLoader('templates');
  $twig = new \Twig\Environment($loader);

  //Consultamos al modelo por la imformacion de los eventos
  $eventos = getEventos();

  session_start();

  $usuario = array('nick' => 'defecto', 'tipo' => 'anonimo');

  if( isset($_SESSION['nick']) ){

    $user = getUser($_SESSION['nick']); 

    $usuario['nick']= $user['nick'];
    $usuario['tipo']= $user['tipo'];
  }
  else{

  }
  
  echo $twig->render('portada.html', ['eventos' => $eventos, 'usuario' => $usuario]);
?>
