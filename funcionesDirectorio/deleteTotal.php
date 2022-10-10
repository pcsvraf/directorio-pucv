<?php
$connect = mysqli_connect("localhost", "pcspucv_dir", "Z?Z25Kjy7sevc#13", "pcspucv_dir");

$query = "TRUNCATE TABLE personas";
$resultado = mysqli_query($connect,$query);
$reset_increment_column = "ALTER TABLE personas AUTO_INCREMENT = 1";
mysqli_query($connect, $reset_increment_column);
if($resultado)
{
  echo '<script> alert("Datos borrados exitosamente"); window.location = "../Directorio/table.php" </script>';

}
else{
  echo 'Error al borrar datos';
}
?>
