<?php
    require_once "/usr/local/lib/php/vendor/autoload.php";

    include("bd.php");

    $loader = new \Twig\Loader\FilesystemLoader('templates');
    $twig = new \Twig\Environment($loader);

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
        header("Location: login.php");
    }

    //2. Gestion de la edicion de la cuenta
    if(isset ($_GET['edicion'])){ //Si está definida la variable edicion
        $edicion = 1;
    }
    else{ //Si no lo está
        $edicon = 0;
    }
    
    if($_SERVER['REQUEST_METHOD'] === 'POST'){

        $nuevonick= $_POST['nuevonick'];
        $nuevonombre = $_POST['nuevonombre'];
        $nuevosapellidos = $_POST['nuevoapellidos'];
        $nuevoemail = $_POST['nuevoemail'];
        $nuevacontraseña1 = $_POST['contraseña1'];
        $nuevacontraseña2 = $_POST['contraseña2'];

        if($nuevacontraseña1 === $nuevacontraseña2){

            if( editUser($nuevonick,$nuevacontraseña1,$nuevonombre,$nuevosapellidos,$nuevoemail)){
                header("Location: /cuenta.php");
            }
            else{
                header("Location: /cuenta.php/?edicion");
            }
        }
        else{
            header("Location: /cuenta.php/?edicion");
        }
       
        /*

        //Cambio de contraseña
        if($nuevacontraseña != ""){
            if(changePassword($nuevacontraseña,$user['nick']) ){
                header("Location: cuenta.php");
            }
            else{
                recuperarUsuario($user['nick'],$user['passw'],$user['nombre'],$user['apellidos'],$user['email']);
                header("Location: cuenta.php/?edicion=1");
            }
        }

        //Cambio de Nombre
        if($nuevonombre!= ""){
            if( editUserNombre($nuevonombre,$user['nick']) ){
                header("Location: cuenta.php");
            }
            else{
                recuperarUsuario($user['nick'],$user['passw'],$user['nombre'],$user['apellidos'],$user['email']);
                header("Location: cuenta.php/?edicion=2");
            }
        }

        //Cambio de apellidos
        if($nuevosapellidos!= ""){
            if( editUserApellidos($nuevosapellidos,$user['nick']) ){
                header("Location: cuenta.php");
            }
            else{
                recuperarUsuario($user['nick'],$user['passw'],$user['nombre'],$user['apellidos'],$user['email']);
                header("Location: cuenta.php/?edicion=3");
            }
        }

        //Cambio de email
        if($nuevoemail!= ""){
            if( editUserEmail($nuevoemail,$user['nick']) ){
                header("Location: cuenta.php");
            }
            else{
                recuperarUsuario($user['nick'],$user['passw'],$user['nombre'],$user['apellidos'],$user['email']);
                header("Location: cuenta.php/?edicion=4");
            }
        }

        //Cambio de nick lo ultimo
        if($nuevonick!= ""){
            if( editUserNick($nuevonick) ){
                header("Location: cuenta.php");
            }
            else{
                recuperarUsuario($user['nick'],$user['passw'],$user['nombre'],$user['apellidos'],$user['email']);
                header("Location: cuenta.php/?edicion=5");
            }
        }*/

        exit();
    }

    echo $twig->render('cuenta.html', ['eventos' => $eventos, 'usuario' => $usuario, 'edicion' => $edicion]);
?>
