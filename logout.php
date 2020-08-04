<?php 	
  session_start();//comando para poder utilizar variables de sesion
  session_unset();
  session_destroy();//destruir las sesiones
  header("Location: /");//redireccionar a la página principal (index.php), que es donde se elige entre iniciar sesion o registrarse
 ?>