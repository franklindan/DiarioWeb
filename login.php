<!DOCTYPE html>
<html lang="es">
    
<head>
    
    <meta charset="UTF-8">
    <title>Login in | YourDiary</title>
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
       <div class="row justify-content-center">
        <div class="col-10 col-sm-8 col-md-6 col-lg-5 col-xl-4 p-5">
            <div class="card text-center bg-info">
                <div class="card-body">
                    <h3>Login to YourDiary</h3>
                    <p>La mejor plataforma para llevar tu diario online</p>
                    <form action="login.php" method="post">
                        <div class="form-group">
                            <input type="text" class="form-control form-control-lg" placeholder="Email" name="email">
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control form-control-lg" placeholder="Contraseña" name="pass">
                        </div>
                        <div class="row">
                        <div class="col-8">
                            <p>¿Aún no tienes una cuenta? <a href="registrar.php" class="text-light">Registrate ahora!</a></p>   
                        </div>
                        <div class="col-4">
                        <input type="submit" class="btn btn-outline-light" value="Ingresar">
                        </div>
                        </div>
                    </form>
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
    $idUsuario;
    if($conexion->connect_error) die("No se ha podido conectar a la base de datos");
    
    if (isset($_POST['email'])&&
        isset($_POST['pass']))
    { 
        $user=mysql_entities_fix_string($conexion,get_post($conexion, 'email'));
        $password=mysql_entities_fix_string($conexion,get_post($conexion, 'pass'));
        $query = "SELECT * FROM usuario WHERE coreUsuario='$user'";
        $result = $conexion->query($query);
        if (!$result) die ("Usurio no encontrado");
        elseif ($result->num_rows)
        {
            $row = $result->fetch_array(MYSQLI_NUM);
            $result->close();
            if (password_verify($password, $row[3])){
                session_start();
                $_SESSION['id']=$_POST['email'];
                $_SESSION['pass']=$_POST['pass'];
                header('location:diario.php');
            }
            else die("Usuario/password incorrecto");
        }
        else die("Usuario/password incorrecto");
    }
    
    $conexion->close();
    function mysql_entities_fix_string($conexion, $string)
    {
        return htmlentities(mysql_fix_string($conexion, $string));
    }
    function mysql_fix_string($conexion, $string)
    {
        if (get_magic_quotes_gpc()) $string = stripslashes($string);
        return $conexion->real_escape_string($string);
    }
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