<!DOCTYPE html>
<html lang="es">
    
<head>
    
    <meta charset="UTF-8">
    <title>Cuenta | YourDiary</title>
    <meta name="viewport" content="width=device-width, user-scalable=yes, initial-scale=1.0,
    maximum-scale=1.0, minimum-scale=1.0, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    
    <link rel="stylesheet" href="css/estilos.css">
    <link rel="stylesheet" href="css/font.css">
</head>
 
<body>
   
   <?php
    
    session_start();
    if (!isset($_SESSION['id']))
    {
        header("location:login.php");   
    }

    ?>
    
   <nav class="navbar navbar-expand-sm bg-dark navbar-dark fixed-top">
        <div class="container">
            <a href="ingreso.html" class="navbar-brand">
                YourDiary
            </a>
            <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item"><a href="diario.php" class="nav-link">Mis anotaciones</a></li>
                    <li class="nav-item"><a href="cuenta.php" class="nav-link">Cuenta</a></li>
                    <li class="nav-item"><a href="cierre.php" class="nav-link">Salir</a></li>
                </ul>
            </div>
        </div>
    </nav>
   
   <header class="">
   </header>
   
   <section class="">
   </section>
   
   <article>   
   </article>
   
   <aside> 
   </aside>
   
   <main class="">
   <!-- Contenido --> 
   <div class="container">
       <div class="visible">
        <h2 class="text-muted text-center">Información de usuario</h2>
       </div>
       
       <div class="row justify-content-center">
                <div class="col-12">
                    <div class="row justify-content-center">
                        <div class="col-8 col-sm-6 col-md-5 col-lg-4 col-xl-4">
                            <?php
                            require_once 'loginDatos.php';
                            $conexion=new mysqli($host,$user,$password,$database,$port);
                            if($conexion->connect_error) die("No se ha podido conectar a la base de datos");
                                
                                $email= htmlspecialchars($_SESSION['id']);
                                $query = "SELECT * FROM usuario where coreUsuario='$email'";
                                $result = $conexion->query($query);
                                if (!$result) die ("Falló el acceso a la base de datos");
                            
                                $row = $result->fetch_array(MYSQLI_NUM);

                                $r0 = htmlspecialchars($row[0]);
                                $r1 = htmlspecialchars($row[1]);
                                $r2 = htmlspecialchars($row[2]);
                                $r3 = htmlspecialchars($row[3]);
                                
        
                                $conexion->close();
                            ?>
                            <form action="cuenta.php" method="post" class="">
                               <label for="nombres">Nombres:</label>
                                <input type="text" class="form-group form-control" id="nombres" name="nombre" value="<?php echo $r0;?>">
                                <label for="apellidos">Apellidos:</label>
                                <input type="text" class="form-group form-control" id="apellidos" name="apellido" value="<?php echo $r1;?>">
                                <label for="correo">Correo electrónico:</label>
                                <input type="text" class="form-group form-control" id="correo" name="correo" value="<?php echo $r2;?>">
                                <label for="pass">Contraseña:</label>
                                <input type="password" class="form-group form-control" id="pass" name="pass">
                                <label for="pass">Nueva contraseña:</label>
                                <input type="password" class="form-group form-control" id="newpass" name="newpass">
                                <div class="text-center">
                                   <input type="submit" class="btn btn-primary" value="Guardar">
                                </div>
                               
                            </form>
                        </div>
                    </div>
                </div>
            </div>

      
       
   </div>   
   </main>
   
   <footer class="">
        <p class="text-center m-5">&copy; 2020 YourDiary | Todos los derechos reservados</p>  
   </footer>
    
    <?php
    require_once 'loginDatos.php';
    $conexion=new mysqli($host,$user,$password,$database,$port);
    if($conexion->connect_error) die("No se ha podido conectar a la base de datos");
    
    if (isset($_POST['nombre']) &&
        isset($_POST['apellido']) &&
        isset($_POST['correo']) &&
        isset($_POST['pass']) &&
        isset($_POST['newpass']) &&
        isset($_SESSION['id']))
    {
        $nombre = get_post($conexion, 'nombre');
        $apellido = get_post($conexion, 'apellido');
        $correo = get_post($conexion, 'correo');
        $pass = password_hash(get_post($conexion,'pass'), PASSWORD_DEFAULT);
        $newpass = password_hash(get_post($conexion,'newpass'), PASSWORD_DEFAULT);
        $email= htmlspecialchars($_SESSION['id']);
        if(password_verify($_SESSION['pass'],$pass)){
        $query = "UPDATE usuario SET nombUsuario='$nombre',apelUsuario='$apellido',passUsuario='$newpass' where coreUsuario='$email'";
        $result = $conexion->query($query);
        if (!$result) echo "INSERT falló <br><br>";
        }else die("Ingrese la contraseña correctamente");
    }
    
    
    $conexion->close();
    function get_post($con, $var)
    {
        return $con->real_escape_string($_POST[$var]);
    }
    
    ?>
    
   <script src="js/menu.js"></script>
   <script src="js/jquery-3.5.1.slim.min.js"></script>
   <script src="js/popper.min.js"></script>
   <script src="js/bootstrap.min.js"></script>
</body>
</html>