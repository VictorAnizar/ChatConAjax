<?php 
   session_start();
   require 'database.php';
   //verificamos que se llenen esos datos
   $message='';
   if (isset($_SESSION['id'])) {
      $sql="SELECT id_usr, email, password,nombreU FROM usuario WHERE id_usr=:id";
      $records=$conn->prepare($sql);
      $records->bindParam(':id',$_SESSION['id']);
      $records->execute();
      $results=$records->fetch(PDO::FETCH_ASSOC);
      $message=$results['nombreU'];
   }
   else{//si no hay ningun usuario registrado no se accede al sistema, sino que se redirecciona a la parte de iniciar sesión o registrarse
      header("Location: /");
   }
   if ( !empty($_POST['texto'])) {
      $sql="INSERT INTO mensaje (texto,id_usr) VALUES (:texto,:id_usr)";
      $stmt=$conn->prepare($sql);//le pasamos la sentencia sql a la conexion
      //relacionamos las variables que se le pasan a la sentencia sql con las variables de tipo POST que se reciben por el formulario
    $stmt->bindParam(':texto',$_POST['texto']);
    $stmt->bindParam(':id_usr',$_SESSION['id']);
    $stmt->execute(); 
    $_POST['texto']='';
   }
   //si ya se selecciono un usuario con el cual se va a chatear, vamos a mandar su nombre, email y id
   if ( !empty($_POST['nombreUsrPOST'])) {
    //PRIMERO SEPARAMOS NOM_USR/EMAIL_USR CON 

        $cadena = $_POST['nombreUsrPOST'];

        list($dato1Nombre, $dato2Email) = explode('/', $cadena);
        $_SESSION['cadena']=$cadena;
        $sql="SELECT id_usr FROM usuario WHERE nombreU=:nombreU AND email=:email";
        $stmt=$conn->prepare($sql);
        $stmt->bindParam(':nombreU',$dato1Nombre);
        $stmt->bindParam(':email',$dato2Email);
        $stmt->execute(); 
        $result=$stmt->fetch(PDO::FETCH_ASSOC);
        $_SESSION['nombreUsr']=$dato1Nombre;
        $_SESSION['emailUsr']=$dato2Email;
        $_SESSION['idUsr']=$result['id_usr'];
        header("Location: /inicio_privado.php");
   }
   



   
   
   ?>
<!DOCTYPE html>
<html>
   <head>
      <link rel="stylesheet" href="css/bootstrap.min.css">
      <link rel="stylesheet" type="text/css" href="css/styles.css">
      <link href="https://fonts.googleapis.com/css2?family=Varta:wght@300&display=swap" rel="stylesheet">
      <script type="text/javascript">
         //se ejecuta asíncronamente
         
           function ajax()
           {
         
            /*
            XMLHttpRequest:
            Proporciona una forma fácil de obtener información de una URL sin tener que recargar la página completa. Una página web puede actualizar sólo una parte de la página sin interrumpir lo que el usuario está haciendo. XMLHttpRequest es ampliamente usado en la programación AJAX.*/
            var req = new XMLHttpRequest();
           
            /*
            onreadystatechange:
            Una función del objeto JavaScript que se llama cuando el atributo readyState cambia.
            */
            req.onreadystatechange = function(){
               /*
             readyState:
             0 UNINITIALIZED  todavía no se llamó a open().
            1  LOADING  todavía no se llamó a send().
            2  LOADED   send() ya fue invocado, y los encabezados y el estado están disponibles.
            3  INTERACTIVE Descargando; responseText contiene información parcial.
            4  COMPLETED   La operación está terminada.
         
            status:  
            El estado de la respuesta al pedido. Éste es el código HTTPresult (por ejemplo, status es 200 por un pedido exitoso). Sólo lectura.
               */
               if (req.readyState==4 && req.status==200) {
                  /*
                  responseText:
                  La respuesta al pedido como texto, o null si el pedido no fue exitoso o todavía no se envió. Sólo lectura.
                  */
                  document.getElementById('chat').innerHTML = req.responseText;
               }
            }
            req.open('GET','chat.php',true);//Inicializa el pedido
            req.send();//envia el pedido
           }
           //Repite la funcion cada segundo
           setInterval(function(){ajax();},1000);
           
           
      </script>
      <title>chat ajax</title>
   </head>
   <body onload="ajax();">
                 <?php
                 //muestra todos los usuarios excepto el usuario activo
                   $busqueda=$conn->prepare("SELECT nombreU, id_usr,email FROM usuario WHERE id_usr!=:id_usr ");
                   $busqueda->bindParam(':id_usr',$_SESSION['id']);
                   $busqueda->execute();                   
                   ?>
                   <nav aria-label="breadcrumb">
                      <ol class="breadcrumb p-3 mb-2 bg-dark">
                         <li class="breadcrumb-item active" aria-current="page">
                            <button type="button" class="btn btn-outline-warning" disabled>
                               <?php if(!empty($message)): ?><!--No es necesaria-->
                               <?= $message ?>    
                               <?php endif; ?><!--No es necesaria-->
                            </button>
                         </li>
                         <a href="inicio.php"><button type="button" class="btn btn-warning">Sala de chat</button></a>
                         <a href="logout.php"><button type="button" class="btn btn-warning">Cerrar sesión</button></a>
                      </ol>
                   </nav>
                  <table   class="table table-bordered table-hover">
                    <form action="seleccion_chat.php" method="post">
                      
                    
                    <!--Nombres de columnas-->
                    <tr>
                       <th class="registro" style="background-color: #F5DA81; text-align: Center">Usuarios:</th> 
                    </tr>
                    <?php
                       foreach($busqueda as $res)
                       {
                         echo "<tr>";?>
                         
                         <td style="text-align: center;">
                           
                            <button type="submit" class="btn btn-warning" name="nombreUsrPOST" value=<?php echo $res["nombreU"]."/".$res["email"] ?>>
                            <?php echo $res["nombreU"]."/".$res["email"] ?>
                           </button>
                         </td>
                            
                    <!-- <td style="text-align: center;">     
                        <a href="inicio_privado.php?datosUsr=<?php echo $res['id_usr']."/".$res['nombreU']; ?>"><button type="button" class="btn btn-warning"><?php echo $res["nombreU"] ?></button><a>
                    </td> -->
                    <?php 
                       echo "</tr>";   
                       }   
                    ?>
                    </form>
                  </table>
              
      <script src="js/jquery.js" type="text/javascript">  </script>
      <script src="js/bootstrap.min.js" type="text/javascript">  </script>
   </body>
</html>