<?php 
   require 'database.php';
   session_start();
      try {
      $resultado = $conn->prepare("SELECT u.nombreU,mp.texto,mp.fechaHora FROM mensaje_pri mp JOIN usuario u ON mp.id_usr_envia=u.id_usr WHERE (id_usr_envia=:id_usr_envia AND id_usr_recibe=:id_usr_recibe) OR (id_usr_envia=:id_usr_recibe AND id_usr_recibe=:id_usr_envia) ORDER BY mp.fechaHora");
         $resultado->bindParam(':id_usr_envia',$_SESSION['id']);//usuario con sesion iniciada
    $resultado->bindParam(':id_usr_recibe',$_SESSION['idUsr']);//usuario seleccionado para hablar
    $resultado->execute();

      
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