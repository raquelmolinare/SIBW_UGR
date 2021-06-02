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
        header("Location: /login.php");
    }

    //2. Gestion de la edicion de la cuenta
    if(isset ($_GET['edicion'])){ //Si está definida la variable edicion
        $edicion = 1;
    }
    else{ //Si no lo está
        $edicon = 0;
    }

    
    //Gestion de la edicion
    if(isset ($_GET['err'])){ //Si está definida la variable err
        $error = $_GET['err'];
    }
    else{ //Si no lo está
        $error = -1;
    }

    if($_SERVER['REQUEST_METHOD'] === 'POST'){

        if(isset($_POST["guardarNick"])){
            $nicknuevo = $_POST['nuevonick'];
            if( editUserNick($nicknuevo, $usuario['nick']) ){
                $_SESSION['nick'] = $nicknuevo;
                header("Location: /cuenta.php/?edicion&err=0");
            }
            else{
                header("Location: /cuenta.php/?edicion&err=1");
            }
            
        }
    
        if(isset($_POST["guardarNombre"])){
            $nombre = $_POST['nuevonombre'];
            if( editUserNombre($nombre,$usuario['nick']) ){
                header("Location: /cuenta.php/?edicion&err=0");
            }
            else{
                header("Location: /cuenta.php/?edicion&err=1");
            }
        }

        if(isset($_POST["guardarApellidos"])){
            $apellidos = $_POST['nuevosapellidos'];
            if( editUserApellidos($apellidos,$usuario['nick']) ){
                header("Location: /cuenta.php/?edicion&err=0");
            }
            else{
                header("Location: /cuenta.php/?edicion&err=1");
            }
        }

        if(isset($_POST["guardarEmail"])) {
            $email = $_POST['nuevoemail'];
            if( editUserEmail($email,$usuario['nick']) ){
                header("Location: /cuenta.php/?edicion&err=0");
            }
            else{
                header("Location: /cuenta.php/?edicion&err=1");
            }
        }

        if(isset($_POST["guardarContraseña"])) {
            $nuevacontraseña1 = $_POST['contraseña1'];
            $nuevacontraseña2 = $_POST['contraseña2'];
            if($nuevacontraseña1 === $nuevacontraseña2){
                if( changePassword($nuevacontraseña1,$usuario['nick']) ){
                    header("Location: /cuenta.php/?edicion&err=0");
                }
                else{
                    header("Location: /cuenta.php/?edicion&err=1");
                }
            }
            else{
                header("Location: /cuenta.php/?edicion&err=1");
            }
        }

        if(isset($_POST["volver"])) {
            header("Location: /cuenta.php");
        }

        if(isset($_POST["cancelar"])) {
            header("Location: /cuenta.php/?edicion");
        }

        exit();
    }

    echo $twig->render('cuenta.html', ['usuario' => $usuario, 'edicion' => $edicion, 'error' => $error]);
?>
