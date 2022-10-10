<?php

//export.php

$connect = mysqli_connect("localhost", "pcspucv_dir", "Z?Z25Kjy7sevc#13", "pcspucv_dir");
mysqli_set_charset($connect, "utf8");

header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=directorio.csv');
echo "\xEF\xBB\xBF";
$output = fopen("php://output", "w");
fputcsv($output, array('ID', 'NOMBRE', 'EMAIL', 'TELEFONO', 'CARGO', 'ID AREA', 'ID JERARQUIA', 'ID DIRECCION'), ';');
$query = "SELECT * from personas ORDER BY id ASC";
$result = mysqli_query($connect, $query);
while($row = mysqli_fetch_row($result))
{
     fputcsv($output, $row, ';');
}
fclose($output);
?>
