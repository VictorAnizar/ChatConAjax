<?php 
  //la siguiente sentencia es necesaria para usar variables de sesion
  session_start();
  require 'database.php';
  //corroboramos que se tengan esos dos datos o que no estén vacíos
  if (!empty($_POST['email']) && !empty($_POST['password']) ) {
    //preparamos la sentencia sql para hacer una consulta
    //selecciona el id, email y contraseña de la tabla usuarios donde el email (de la tabla) sea igual al email (del metodo POST)
    $sql="SELECT id_usr, email, password FROM usuario WHERE email=:email";
    $records=$conn->prepare($sql);
    //vinculamos los parametros (el de la base de datos y el del metodo POST)
    $records->bindParam(':email', $_POST['email']);
    //ejecutamos lo anterior
    $records->execute();
    //obtenemoos los datos del usuario con el metodo fetch
    //Fetch:Obtiene **una fila** de un conjunto de resultados asociado al objeto PDOStatement
     $results=$records->fetch(PDO::FETCH_ASSOC);
     $message='';
    // si la contraseña y el email que le pasamos (POST) es igual a la de la BD
    if (($_POST['password']==$results['password'] ) && ($_POST['email']==$results['email']))   {
      //$_SESSION es una variable que no requiere tal cual de un servidor
      $_SESSION['id'] = $results['id_usr'];
      header("Location: /chat_ajax/menu.php");
    }
    else
    {
      $message="Datos erróneos...";   
    }
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <link href="https://fonts.googleapis.com/css2?family=Varta:wght@300&display=swap" rel="stylesheet">
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

<body id="FuenteRoboto">
   
   
  
  <h1>Iniciar sesión</h1>
  <span><a href="signup.php">o registrarse</a></span>

  <?php if(!empty($message)): ?>
  <p><?= $message ?></p>    
  <?php endif; ?>

 

  <main>
      

    <form action="login.php" method="post">
      <div class="form-group">
        <label for="exampleInputEmail1">Ingresa tu correo electrónico</label>
        <input type="email" name="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
        <small id="emailHelp" class="form-text text-muted">Tu correo estará seguro con nosotros.</small>
      </div>
      <div class="form-group">
        <label for="exampleInputPassword1">Ingresa tu contraseña</label>
        <input type="password" name="password" class="form-control" id="exampleInputPassword1">
      </div>
      <button type="submit" value="Enviar" class="btn btn-primary">Ingresar</button>
    </form>
  </main>
  <footer>
  	
  </footer>
</body>
    <script src="js/query.js">  </script>
    <script src="js/bootstrap.min.js">  </script>

</html>