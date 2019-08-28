 <?php
$connect = mysqli_connect("localhost", "udb_directorio", "t2OVv3Dd", "db_directorio");
 mysqli_set_charset($connect, "utf8");

 $column = array("personas.id", "personas.nombre", "personas.cargo", "personas.email", "personas.id_area", "personas.telefono");
 $query =  "SELECT personas.id, personas.nombre, personas.cargo, personas.email, personas.id_area, personas.telefono,area.nom, direccion.nomb, personas.idDir FROM ((personas
  INNER JOIN area ON area.id = personas.id_area)
  INNER JOIN direccion ON direccion.id = personas.idDir)";
 $query .= " WHERE ";
 if (isset($_POST["is_category"])) {
     $query .= "personas.id_area = '" . $_POST["is_category"] . "' AND ";
 }
 if (isset($_POST["search"]["value"])) {
 $query .= '(personas.id LIKE "%' . $_POST["search"]["value"] . '%" ';
 $query .= 'OR personas.nombre LIKE "%' . $_POST["search"]["value"] . '%" ';
 $query .= 'OR personas.email LIKE "%' . $_POST["search"]["value"] . '%" ';
 $query .= 'OR personas.telefono LIKE "%' . $_POST["search"]["value"] . '%" ';
 $query .= 'OR direccion.nomb LIKE "%' . $_POST["search"]["value"] . '%" ';
 $query .= 'OR personas.cargo LIKE "%' . $_POST["search"]["value"] . '%") ';
 $query .= 'OR area.nom LIKE "%' . $_POST["search"]["value"] . '%" ';
 }

 if (isset($_POST["order"])) {
     $query .= 'ORDER BY ' . $column[$_POST['order']['0']['column']] . ' ' . $_POST['order']['0']['dir'] . ' ';
 } else {
     $query .= 'ORDER BY personas.id_jerarq ';
 }

 $query1 = '';

 if ($_POST["length"] != 1) {
     $query1 .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
 }

 $number_filter_row = mysqli_num_rows(mysqli_query($connect, $query));

 $result = mysqli_query($connect, $query . $query1);

 $data = array();

 while ($row = mysqli_fetch_array($result)) {
 $sub_array = array();
  $sub_array[] = '<div contenteditable class="update" data-id="' . $row["id"] . '" data-column="nombre">' . $row["nombre"] . '</div>';
 $sub_array[] = '<div contenteditable class="update" data-id="' . $row["id"] . '" data-column="cargo">' . $row["cargo"] . '</div>';
 $sub_array[] = '<div contenteditable class="update" data-id="' . $row["id"] . '" data-column="nom_area">' . $row["nom"] . '</div>';
  $sub_array[] = '<div contenteditable class="update" data-id="' . $row["id"] . '" data-column="nom_dir">' . $row["nomb"] . '</div>';
 $sub_array[] = '<div contenteditable class="update" data-id="' . $row["id"] . '" data-column="telefono">' . $row["telefono"] . '</div>';
 $sub_array[] = '<div contenteditable class="update" data-id="' . $row["id"] . '" data-column="email">' . $row["email"] . '</div>';
 $sub_array[] = '<button type="button" name="delete" class="btn btn-link btn-xs delete" id="' . $row["id"] . '"><font color="#dc3545"><i class="material-icons">delete_forever</i></font></button>';
 $data[] = $sub_array;
 }

 function get_all_data($connect) {
     $query = "SELECT * FROM personas";
     $result = mysqli_query($connect, $query);
     return mysqli_num_rows($result);
 }

 $output = array(
     "draw" => intval($_POST["draw"]),
     "recordsTotal" => get_all_data($connect),
     "recordsFiltered" => $number_filter_row,
     "data" => $data
 );

 echo json_encode($output);
 ?>
