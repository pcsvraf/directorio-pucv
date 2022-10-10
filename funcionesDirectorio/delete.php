<?php
$connect = mysqli_connect("localhost", "pcspucv_dir", "Z?Z25Kjy7sevc#13", "pcspucv_dir");
if(isset($_POST["id"]))
{
 $query = "DELETE FROM personas WHERE id = '".$_POST["id"]."'";
 if(mysqli_query($connect, $query))
 {
  echo 'Contacto eliminado';
 }
}
?>
