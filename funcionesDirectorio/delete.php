<?php
$connect = mysqli_connect("localhost", "udb_directorio", "t2OVv3Dd", "db_directorio");
if(isset($_POST["id"]))
{
 $query = "DELETE FROM personas WHERE id = '".$_POST["id"]."'";
 if(mysqli_query($connect, $query))
 {
  echo 'Contacto eliminado';
 }
}
?>
