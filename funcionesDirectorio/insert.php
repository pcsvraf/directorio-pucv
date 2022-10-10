<?php
$connect = mysqli_connect("localhost", "pcspucv_dir", "Z?Z25Kjy7sevc#13", "pcspucv_dir");
//obteniendo datos desde el formulario en la tabla
if(isset($_POST["nombre"],  $_POST["email"], $_POST["telefono"], $_POST["cargo"], $_POST["nom_area"]))
{
 $nombre = mysqli_real_escape_string($connect, $_POST["nombre"]);
 $email = mysqli_real_escape_string($connect, $_POST["email"]);
 $telefono = mysqli_real_escape_string($connect, $_POST["telefono"]);
 $cargo = mysqli_real_escape_string($connect, $_POST["cargo"]);
$nom_area = mysqli_real_escape_string($connect, $_POST["nom_area"]);
$nom_dir = mysqli_real_escape_string($connect, $_POST["nom_dir"]);
//se selecciona el id de la persona para ver en que id debo agregar el nuevo
$query1 = "SELECT id, id_area, idDir FROM personas order by id DESC LIMIT 1";
$resultado = mysqli_query($connect,$query1);
$id = mysqli_fetch_row($resultado);
$ide = $id[0] + 1; //id nuevo
//se selecciona el id de la persona para ver en que id debo agregar el nuevo
$query2 = "SELECT id, idDir FROM personas order by id DESC LIMIT 1";
$resultadoDir = mysqli_query($connect,$query2);
$iid = mysqli_fetch_row($resultadoDir);
$ideD = $iid[0] + 1; //id nuevo
//se decodifican los textos para que acepte utf8
$nombresito = utf8_decode($nombre);
$carg = utf8_decode($cargo);
$area = utf8_decode($nom_area);
$direccion = utf8_decode($nom_dir);
//para ver a que tipo de jerarquia pertenece el nuevo usuario ingresado
$delimitador=explode(" ", $carg);
$d= $delimitador[0];//primera palabra de cargo
$s= $delimitador[1];

if (substr($d,-1)=="a" && $d!=="Jefa" && $d!=="Decana" && $d!=="Secretaria" && $d!=="Contralora"){
  $d= substr($d,0,-1);
}else if ($d==="Decana"){
  $d="Decano y Consejeros Superiores";
}else if ($d==="Jefa"){
  $d="Jefe";
}else if ($d==="Secretaria"){
  $d="Secretario";
}else if ($d==="Contralora"){
  $d="Contralor";
}
$nuevita="SELECT id FROM jerarquia WHERE jerarq='".$d."'";
$id_jerarq = mysqli_query($connect,$nuevita);
$id_j = mysqli_fetch_row($id_jerarq);
if ($s=="general" or $s=="General"){
  $nivel=5;
}
else{
  $nivel = $id_j[0];//id de la jerarquia ingresada
}
//para obtener el id del area ingresada cuando este ya existe
$dato= "SELECT id FROM area WHERE nom = '".$area."'";
$id_existente = mysqli_query($connect,$dato);
$id_e = mysqli_fetch_row($id_existente);
$prueba = $id_e[0];

//para obtener el id de la direccion ingresada cuando este ya existe
$dato2= "SELECT id FROM direccion WHERE nomb = '".$direccion."'";
$idExistente = mysqli_query($connect,$dato2);
$id_ex = mysqli_fetch_row($idExistente);
$prueba2 = $id_ex[0];

/*para obtener el id de la jerarquia ingresada cuando este ya existe
$dato= "SELECT id FROM jerarquia WHERE jerarq = '".$carg."'";
$id_exis = mysqli_query($connect,$dato);
$id_ex = mysqli_fetch_row($id_exis);
$jera = $id_ex[0];*/

$contar= mysqli_num_rows($id_existente);
$contar2= mysqli_num_rows($idExistente);
if($contar == 0 ){//si el id no existe
  $query3= "INSERT INTO area (nom) VALUES ('$area')";
  $query5 = "SELECT id FROM area order by id DESC LIMIT 1";
  $re = mysqli_query($connect,$query5);
  $nuevo = mysqli_fetch_row($re);
  $id_nuevo = $nuevo[0] + 1;//nuevo id para nueva area
  if(mysqli_query($connect, $query3))
  {
    echo '';
  }
  $rs=mysqli_query("SELECT @@identity AS id");
  if($row=mysqli_fetch_row($rs)){
    $id_n=trim($row[0]);
  }
  if($contar2 == 0 ){//si el id no existe
    $query6= "INSERT INTO direccion (nomb, idArea) VALUES ('$direccion', '$id_nuevo')";
    $query7 = "SELECT id FROM direccion order by id DESC LIMIT 1";
    $rep = mysqli_query($connect,$query7);
    $nuevito = mysqli_fetch_row($rep);
    $idNuevo = $nuevito[0] + 1;//nuevo id para nueva area
    if(mysqli_query($connect, $query6))
    {
      echo '';
    }

    //agrega el usuario con la nueva area a la tabla
    $query = "INSERT INTO personas(id, nombre, email, telefono, cargo, id_area, id_jerarq, idDir)"
           . " VALUES('$ide', '$nombresito', '$email', '$telefono', '$carg', '$id_nuevo', '$nivel', '$idNuevo')";
    if(mysqli_query($connect, $query))
    {
      echo 'Funcionario agregado';
    }
    else{
      echo 'Error al insertar contacto';
    }

  }else{
    $query = "INSERT INTO personas(id, nombre, email, telefono, cargo, id_area, id_jerarq, idDir)"
           . " VALUES('$ide', '$nombresito', '$email', '$telefono', '$carg', '$id_nuevo', '$nivel', '$prueba2')";
    if(mysqli_query($connect, $query))
    {
      echo 'Funcionario agregado';
    }
    else{
      echo 'Error al insertar contacto';
    }
  }
}
else{//id de area existe
  if($contar2 == 0 ){//si el id no existe
    $query6= "INSERT INTO direccion (nomb, idArea) VALUES ('$direccion', '$prueba')";
    $query7 = "SELECT id FROM direccion order by id DESC LIMIT 1";
    $rep = mysqli_query($connect,$query7);
    $nuevito = mysqli_fetch_row($rep);
    $idNuevo = $nuevito[0] + 1;//nuevo id para nueva area
    if(mysqli_query($connect, $query6))
    {
      echo '';
    }

    //agrega el usuario con la nueva area a la tabla
    echo"";
    $query = "INSERT INTO personas(id, nombre, email, telefono, cargo, id_area, id_jerarq, idDir)"
           . " VALUES('$ide', '$nombresito', '$email', '$telefono', '$carg', '$prueba', '$nivel', '$idNuevo')";
    if(mysqli_query($connect, $query))
    {
      echo 'Funcionario agregado';
    }
    else{
      echo 'Error al insertar Contacto';
    }

  }else{
    $query = "INSERT INTO personas(id, nombre, email, telefono, cargo, id_area, id_jerarq, idDir)"
           . " VALUES('$ide', '$nombresito', '$email', '$telefono', '$carg', '$prueba', '$nivel', '$prueba2')";
    if(mysqli_query($connect, $query))
    {
      echo 'Funcionario agregado';
    }
    else{
      echo 'Error al insertar contacto';
    }
  }

}
}
?>
