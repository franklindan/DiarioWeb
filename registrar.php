<!DOCTYPE html>
<html lang="es">
    
<head>
    
    <meta charset="UTF-8">
    <title>Registro | YourDiary</title>
    <meta name="viewport" content="width=device-width, user-scalable=yes, initial-scale=1.0,
    maximum-scale=1.0, minimum-scale=1.0, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    
    <link rel="stylesheet" href="css/estilos.css">
    <link rel="stylesheet" href="css/font.css">
</head>
 
<body>
    
   <nav class=""> 
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
         
        <section class="bg-light py-5">
        
            <div class="row justify-content-center">
                <div class="col-12">
                    <h2 class="text-muted text-center">Registrate gratis</h2>
                    <div class="row justify-content-center">
                        <div class="col-8 col-sm-6 col-md-5 col-lg-4 col-xl-4">
                            <h4 class="text-info">Crear nuevo diario</h4>
                            <form action="registrar.php" method="post" class="text-center">
                                <input type="text" class="form-group form-control" placeholder="Nombres" name="nombres">
                                <input type="text" class="form-group form-control" placeholder="Apellidos" name="apellidos">
                                <input type="text" class="form-group form-control" placeholder="Correo electrónico" name="correo">
                                <input type="password" class="form-group form-control" placeholder="Password" name="password">
                                <input type="checkbox" name="agree" class="form-check form-check-inline form-group">
                                <label for="agree" class="form-check-label form-group">Acepto los terminos y condiciones</label><br>
                                <input type="submit" value="Registrarse" class="btn btn-primary"><br>
                                <a href="login.php">Iniciar sesion</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        
    </section>
          
             
   </main>
   
   <footer class="">
        <p class="text-center m-5">&copy; 2020 YourDiary | Todos los derechos reservados</p>  
   </footer>
   
   <?php
    require_once 'loginDatos.php';
    $conexion=new mysqli($host,$user,$password,$database,$port);
    if($conexion->connect_error) die("No se ha podido conectar a la base de datos");
    
    if (isset($_POST['nombres']) &&
        isset($_POST['apellidos']) &&
        isset($_POST['correo']) &&
        isset($_POST['password']))
    {
        $nomb = get_post($conexion, 'nombres');
        $apel = get_post($conexion, 'apellidos');
        $core = get_post($conexion, 'correo');
        $pass = password_hash(get_post($conexion,'password'), PASSWORD_DEFAULT);
        $query = "INSERT INTO usuario (nombUsuario,apelUsuario, coreUsuario,passUsuario) VALUES ('$nomb', '$apel', '$core', '$pass')";
        $result = $conexion->query($query);
        if (!$result) echo "INSERT falló <br><br>";
    }
    
//    $result->close();
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