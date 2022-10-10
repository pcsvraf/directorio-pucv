<?php
//fetch.php
$connect = mysqli_connect("localhost", "pcspucv_dir", "Z?Z25Kjy7sevc#13", "pcspucv_dir");
mysqli_set_charset($connect, "utf8");
$columns = array("personas.id", "personas.nombre", "personas.email", "personas.telefono", "personas.cargo", "personas.id_area");

$query = "SELECT * FROM personas";

$query .= " WHERE ";
if (isset($_POST["is_category"])) {
    $query .= "personas.id_area = '" . $_POST["is_category"] . "' AND ";
}

if (isset($_POST["search"]["value"])) {
$query .= '(personas.id LIKE "%' . $_POST["search"]["value"] . '%" ';
$query .= 'OR personas.nombre LIKE "%' . $_POST["search"]["value"] . '%" ';
$query .= 'OR personas.email LIKE "%' . $_POST["search"]["value"] . '%" ';
$query .= 'OR personas.telefono LIKE "%' . $_POST["search"]["value"] . '%" ';
$query .= 'OR personas.cargo LIKE "%' . $_POST["search"]["value"] . '%") ';
$query .= 'OR personas.id_area LIKE "%' . $_POST["search"]["value"] . '%" ';
}

if (isset($_POST["order"])) {
$query .= 'ORDER BY ' . $columns[$_POST['order']['0']['column']] . ' ' . $_POST['order']['0']['dir'] . '
';
} else {
$query .= 'ORDER BY id DESC ';
}
$query1 = '';

if ($_POST["length"] != -1) {
$query1 = 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
}

$number_filter_row = mysqli_num_rows(mysqli_query($connect, $query));

$result = mysqli_query($connect, $query . $query1);

$data = array();

while ($row = mysqli_fetch_array($result)) {
$sub_array = array();
$sub_array[] = '<div contenteditable class="update" data-id="' . $row["id"] . '" data-column="cargo">' . $row["cargo"] . '</div>';
$sub_array[] = '<div contenteditable class="update" data-id="' . $row["id"] . '" data-column="nombre">' . $row["nombre"] . '</div>';
$sub_array[] = '<div contenteditable class="update" data-id="' . $row["id"] . '" data-column="id_area">' . $row["id_area"] . '</div>';
$sub_array[] = '<div contenteditable class="update" data-id="' . $row["id"] . '" data-column="telefono">' . $row["telefono"] . '</div>';
$sub_array[] = '<div contenteditable class="update" data-id="' . $row["id"] . '" data-column="email">' . $row["email"] . '</div>';
$sub_array[] = '<button type="button" name="delete" class="btn btn-danger btn-xs delete" id="' . $row["id"] . '">Eliminar</button>';
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
