<?php 
   require 'database.php';

      try {
      $resultado = $conn->query("SELECT u.nombreU,m.texto,m.fechaHora FROM mensaje m JOIN usuario u ON m.id_usr=u.id_usr ORDER BY m.fechaHora");
      
         foreach ($resultado as $cht) { ?>
<div id="datos-chat">
   <span style="color: #1c62c4;"><?php echo $cht['nombreU']; ?>: </span>
   <span style="color: #848484;"><?php echo $cht['texto']; ?></span>
   <span style="float: right;"><?php echo $cht['fechaHora']; ?></span>
   <br>
</div>
<?php }
   } catch (Exception $ex) {
       echo 'Ocurrió un error en la conexión: ' . $ex->getMessage();
   }
   
   ?>