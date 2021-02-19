<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">
    <title>Mis anotaciones | YourDiary</title>
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

    <main class="container">
        <!-- Contenido -->
        <div class="visible">
            <h2 class="text-info">Lista de notas</h2>
            <div class="row">
                <div class="col-3">
                    <h5 class="text-muted">Mis notas</h5>
                </div>
                <div class="col-5">
                    <form action="" method="" class="">
                        <input type="text" class="form-control form-group">
                        <input type="submit" value="Buscar" class="btn btn-primary">
                    </form>
                </div>
                <div class="col-4">
                    <button class="btn btn-secondary" data-toggle="modal" data-target="#nuevaNota">Nueva nota</button>

                    <!--modal-->

                    <div class="modal fade" id="nuevaNota">
                        <div class="modal-dialog">
                            <div class="modal-content">

                                <div class="modal-header">
                                    <h4 class="modal-title">Ingrese nueva nota en su diario:</h4>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>

                                <div class="modal-body">
                                    <form action="diario.php" method="post">
                                        <div class="row">
                                            <div class="col-7">
                                                <input type="text" class="form-control form-group" placeholder="Título" name="titulo">
                                            </div>
                                            <div class="col-5">
                                                <input type="date" class="form-control form-group" name="date">
                                            </div>
                                            <div class="col-12">
                                                <textarea cols="30" rows="10" class="form-control form-group" placeholder="¿Qué sucedio hoy?" name="contenido" ></textarea>
                                            </div>
                                        </div>
                                        <input type="submit" class="btn btn-primary" value="Guardar">
                                    </form>
                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-primary" data-dismiss="modal">Cancelar</button>
                                </div>

                            </div>
                        </div>
                    </div>

                    <?php
                    require_once 'loginDatos.php';
                    $conexion0=new mysqli($host,$user,$password,$database,$port);
                    if($conexion0->connect_error) die("No se ha podido conectar a la base de datos");

                    if (isset($_POST['titulo']) &&
                        isset($_POST['date']) &&
                        isset($_POST['contenido']) &&
                        isset($_SESSION['id']))
                    {
                        $titulo = get_post($conexion0, 'titulo');
                        $date = get_post($conexion0, 'date');
                        $contenido = get_post($conexion0, 'contenido');
                        $email= htmlspecialchars($_SESSION['id']);
                        $query0 = "INSERT INTO diario (tituloDiario,fechaDiario,contenidoDiario,usuario_coreUsuario) VALUES ('$titulo','$date','$contenido','$email')";
                        $result0 = $conexion0->query($query0);
                        if (!$result0) echo "INSERT falló <br><br>";
                    }

                    /*$result0->close();*/
                    $conexion0->close();
                    function get_post($con, $var)
                    {
                        return $con->real_escape_string($_POST[$var]);
                    }  

                    ?>    

                </div>
            </div>
        </div>
        <br>
        <br>

        <?php
       
        require_once 'loginDatos.php';
        $conexion=new mysqli($host,$user,$password,$database,$port);
        if($conexion->connect_error) die("No se ha podido conectar a la base de datos");


        if (isset($_POST['delete']) && isset($_POST['id']))
        {   
            $id = get_post($conexion, 'id');
            $query = "DELETE FROM diario WHERE idDiario='$id'";
            $result = $conexion->query($query);
            if (!$result) echo "BORRAR falló"; 
        }

        $email= htmlspecialchars($_SESSION['id']);

        $query = "SELECT * FROM diario where usuario_coreUsuario='$email'";
        $result = $conexion->query($query);
        if (!$result) die ("Falló el acceso a la base de datos");

        $rows = $result->num_rows;

        for ($j = 0; $j < $rows; $j++)
        {
            $row = $result->fetch_array(MYSQLI_NUM);

            $r0 = htmlspecialchars($row[0]);
            $r1 = htmlspecialchars($row[1]);
            $r2 = htmlspecialchars($row[2]);
            $r3 = htmlspecialchars($row[3]);
        ?>          
                   <div class="card bg-light">
                   <div class="card-body">
                       <div class="row">
                           <div class="col-3">
                               <h5 class="text-info text-center"><?php echo $r2;?></h5>
                           </div>
                           <div class="col-9">
                               <h3 class="text-info"><?php echo $r1;?></h3><br>
                               <pre><?php echo $r3;?></pre>
                           </div>
                       </div>
                       <br>
                        <div class="text-center">
                        <button class="btn btn-secondary" data-toggle="modal" data-target="#editarNota" onclick="ide(<?php echo $r0;?>,<?php echo $phpVar1;?>)">Editar nota</button>
                        
                        <script type="text/javascript">
                            function ide(id,php){
                                var a=id;
                                var b=php;
                                if(!b){
                                    window.location.href = window.location.href + "?w1=" + a;
                                } else {
                                    window.location.href = "http://localhost:8080/practica/php/Proyecto/diario.php"+;
                                }
                            }  
                        </script>
                        
            
                        <?php
                        
                        ?>
                        
                        
<!--
                        <form action="diario.php" method="post" id="MiFormulario">
                            <input type="hidden" name="llenar" value="yes"> 
                            <input type="hidden" name="idNota" value= ?php echo $r0;?>">   
                            <input type="submit" class="btn btn-secondary" data-toggle="modal" data-target="#editarNota" value="Editar nota">
                        </form>
-->

                        </div>
                        
                        <?php
            
                            /*if (isset($_POST['llenar']) && isset($_POST['idNota'])){*/
            
                                if (isset($_GET["w1"])) {
                                    $phpVar1 = $_GET["w1"];

                                } else {
                                    $phpVar1 = $r0;
                                }
            
                                $conexion1=new mysqli($host,$user,$password,$database,$port);
                                if($conexion1->connect_error) die("No se ha podido conectar a la base de datos");
                                
                                $id1 = $phpVar1;/*get_post($conexion1, 'idNota');*/
                                $query1 = "SELECT * FROM diario where usuario_coreUsuario='$email' and idDiario=$id1";
                                $result1 = $conexion1->query($query1);
                                if (!$result1) die ("Falló el acceso a la base de datos");

                                $row1 = $result1->fetch_array(MYSQLI_NUM);
                                
                                $s0 = htmlspecialchars($row1[0]);
                                $s1 = htmlspecialchars($row1[1]);
                                $s2 = htmlspecialchars($row1[2]);
                                $s3 = htmlspecialchars($row1[3]);
                                
                            
                                
                        ?> 
                        <!--modal-->
                        <div class="modal fade" id="editarNota">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title">Edite la nota en su diario:</h4>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>
                                    <div class="modal-body">
                                       <form action="diario.php" method="post">
                                          <div class="row">
                                          <div class="col-7">
                                           <input type="text" class="form-control form-group" placeholder="Título" name="titulo2" value="<?php echo $s1;?>">
                                           </div>
                                           <div class="col-5">
                                               <input type="date" class="form-control form-group" name="date2" value="<?php echo $s2;?>">
                                           </div>
                                           <div class="col-12">
                                               <textarea cols="30" rows="10" class="form-control form-group" placeholder="¿Qué sucedio hoy?" name="contenido2"><?php echo $s3;?></textarea>
                                           </div>
                                           </div>
                                           <input type="submit" class="btn btn-primary" value="Guardar">  
                                       </form>
                                       
                                       <?php
//                                        $conexion3=new mysqli($host,$user,$password,$database,$port);
//                                        if($conexion3->connect_error) die("No se ha podido conectar a la base de datos");
//
//                                        if (isset($_POST['titulo2']) &&
//                                            isset($_POST['date2']) &&
//                                            isset($_POST['contenido2']))
//                                        {
//                                            $titulo1 = get_post($conexion3, 'titulo2');
//                                            $date1 = get_post($conexion3, 'date2');
//                                            $contenido1 = get_post($conexion3, 'contenido2');
//
//                                            $query3 = "UPDATE diario SET tituloDiario='$titulo1',fechaDiario='$date1',contenidoDiario='$contenido1' where idDiario='$r0'";
//                                            $result3 = $conexion3->query($query3);
//                                            if (!$result3) echo "INSERT falló <br><br>";
//                                        }
//
//                                        $result3->close();
//                                        $conexion3->close();

                                        ?>
                                       
                                       
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-primary" data-dismiss="modal">Cancelar</button>
                                    </div>
                                </div>
                            </div>
                        </div> 
                        
<!--
                        <script>
                        document.getElementById("MiFormulario").addEventListener("submit", submit);
                        function submit(e) {
                            e.preventDefault();
                            document.getElementById("editarNota").style.display="initial";
                        }
                        </script>
                        
-->
                        <?php
                                
                                $result1->close();
                                $conexion1->close();
                            /*}*/
                        ?>
                        
                        
                   </div> 
                   <form action="diario.php" method="post" class="d-flex justify-content-end p-4">
                        <input type="hidden" name="delete" value="yes">
                        <input type="hidden" name="id" value="<?php echo $r0;?>">
                        <input type="submit" value="BORRAR NOTA" class="btn btn-danger">
                    </form>
                </div>
                <br>
                <br>
                <br>
        <?php       
        }

        $result->close();
        $conexion->close();

        ?>


    </main>

    <footer class="">
        <p class="text-center m-5">&copy; 2020 YourDiary | Todos los derechos reservados</p>
    </footer>
    

    <script src="js/menu.js"></script>
    <script src="js/jquery-3.5.1.slim.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
</body>

</html>
