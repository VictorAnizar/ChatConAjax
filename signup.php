<?php
  //la siguiente sentencia es la conexion a la base de datos
  require 'database.php';

  $message='';
  //corroboramos que tengamos esos datos o que no estén vacíos esos campos
  if( !empty($_POST['email']) && !empty($_POST['password']) && !empty($_POST['nombre'])  )
  {
      $sql="INSERT INTO usuario (nombreU,email,password) VALUES (:nombre,:email,:password)";
      $stmt=$conn->prepare($sql);//le pasamos la sentencia sql a la conexion
      //relacionamos las variables que se le pasan a la sentencia sql con las variables de tipo POST que se reciben por el formulario
      $stmt->bindParam(':email',$_POST['email']);
      $stmt->bindParam(':nombre',$_POST['nombre']);
      //Utilizamos la siguiente funcion para que el usuario de la base de datos no pueda ver las constraseñas directamente, las ve cifradas
      //$password=password_hash($_POST['password'], PASSWORD_BCRYPT);
      $stmt->bindParam(':password',$_POST['password']);

      //si todo lo anterior fue realizado con éxito, se mostrará los siguiente
      if($stmt->execute())
      {
          $message='Usuario creado con éxito';
      }
      else{
          $message='Error en la creación de usuario';
    }
  }

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@500&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="css/styles.css">

  <title>Iniciar sesion</title>
   
  <style>
        
    #FuenteRoboto
    {
      margin: 0;
      padding: 0;
      font-family: 'Roboto', sans-serif;
      text-align: center;
    }
  </style>
  
</head>

<body  id="FuenteRoboto">
   
   <?php if (!empty($message)):?>
    <p><?= $message ?></p>
  <?php endif; ?>
       
   
  <h1>Registrarse</h1>
  <span><a href="login.php">o iniciar sesión</a></span>

  <main>
    <form action="signup.php" method="post">
      <input type="text" name="nombre" placeholder="Ingresa tu nombre/alias">
      <input type="text" name="email" placeholder="Ingresa un email">
      <input type="password" name="password" placeholder="Ingresa una contraseña">
      <input type="submit" value="Enviar">
    </form>  
  </main>
  <footer>
    
  </footer>
</body>
    <script src="js/query.js">  </script>
    <script src="js/bootstrap.min.js">  </script>

</html>