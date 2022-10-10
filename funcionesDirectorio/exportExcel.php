<?php

//export.php
header("Content-Type: application/xls; charset=utf-8");
header("Content-Disposition: attachment; filename= directorio.xls");
header("Pragma: no-cache");
header("Expires: 0");

$connect = mysqli_connect("localhost", "pcspucv_dir", "Z?Z25Kjy7sevc#13", "pcspucv_dir");
mysqli_set_charset($connect, "utf8");
$output = '';

$query = "SELECT * from personas";
$result = mysqli_query($connect, $query);
if (mysqli_num_rows($result) > 0) {
    $output .= utf8_decode('
   <table class="table" border="1" cellspacing=0 cellpadding=2>
                    <tr>
                         <th>Nombre</th>
                         <th>Cargo</th>
                         <th>Área</th>
                         <th>Dirección</th>
                         <th>Teléfono</th>
                         <th>Email</th>
                    </tr>
  ');
    while ($datos = mysqli_fetch_row($result)) {
      $query2 = "SELECT nom from area WHERE id=$datos[5]";
      $result2 = mysqli_query($connect, $query2);
      $nom= mysqli_fetch_row($result2);

      $query4 = "SELECT nomb from direccion WHERE id=$datos[7]";
      $result4 = mysqli_query($connect, $query4);
      $nomb= mysqli_fetch_row($result4);
        $output .= '
    <tr>
                         <td>' . utf8_decode($datos[1]) . '</td>
                         <td>' . utf8_decode($datos[4]) . '</td>
                         <td>' . utf8_decode($nom[0]) . '</td>
                         <td>' . utf8_decode($nomb[0]) . '</td>
                         <td>' . $datos[3] . '</td>
                         <td>' . $datos[2] . '</td>
                    </tr>
   ';
    }
    $output .= '</table>';
    echo $output;
}
exit();
?>
