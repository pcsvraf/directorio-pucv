<?php
$connect = mysqli_connect("localhost", "pcspucv_dir", "Z?Z25Kjy7sevc#13", "pcspucv_dir");

if(isset($_POST["id"])){
 $value = utf8_decode(mysqli_real_escape_string($connect, $_POST["value"]));
 $query = "UPDATE personas SET ".$_POST["column_name"]."='$value' WHERE id = '".$_POST["id"]."'";

 if (strcmp($_POST["column_name"], "cargo") === 0){
   $delimitador=explode(" ", $value);
   $d= $delimitador[0];
   $s= $delimitador[1];
   if (substr($d,-1)=="a" && $d!=="Jefa" && $d!=="Decana" && $d!=="Secretaria" && $d==="Contralora"){
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
     $nivel=3;
   }
   else{
     $nivel = $id_j[0];//id de la jerarquia ingresada
   }

   $query3=  "UPDATE personas SET id_jerarq='$nivel' WHERE id = '".$_POST["id"]."'";
   if(mysqli_query($connect, $query3))
   {
     echo '';
   }
 }else if (strcmp($_POST["column_name"], "nom_area") === 0){
    $dato= "SELECT id FROM area WHERE nom = '".$value."'";
    $id_existente = mysqli_query($connect,$dato);
    $id_e = mysqli_fetch_row($id_existente);
    $prueba = $id_e[0];

    $contar= mysqli_num_rows($id_existente);
    if($contar == 0){//si el id no existe
      $query3= "INSERT INTO area (nom) VALUES ('$value')";
      $query5 = "SELECT id FROM area order by id DESC LIMIT 1";
      $re = mysqli_query($connect,$query5);
      $nuevo = mysqli_fetch_row($re);
      $id_nuevo = $nuevo[0] + 1;//nuevo id para nueva area
      if(mysqli_query($connect, $query3))
      {
        echo '';
      }
      $query3=  "UPDATE personas SET id_area='$id_nuevo' WHERE id = '".$_POST["id"]."'";
      if(mysqli_query($connect, $query3))
      {
        echo 'Directorio Actualizado';
      }
    }
    else{
      $query3=  "UPDATE personas SET id_area='$prueba' WHERE id = '".$_POST["id"]."'";
      if(mysqli_query($connect, $query3))
      {
        echo 'Directorio Actualizado';
      }
    }
  }else if (strcmp($_POST["column_name"], "nom_dir") === 0){
    $dato2= "SELECT id FROM direccion WHERE nomb = '".$value."'";
    $idExistente = mysqli_query($connect,$dato2);
    $idE = mysqli_fetch_row($idExistente);
    $prueba2 = $idE[0];

    $contar2= mysqli_num_rows($idExistente);
    if($contar2 == 0){//si el id no existe

      $datoArea= "SELECT id_area FROM personas WHERE id = '".$_POST["id"]."'";

      $idAr = mysqli_query($connect,$datoArea);
      $area_id = mysqli_fetch_row($idAr);
      $ide = $area_id[0];
      $query4= "INSERT INTO direccion (nomb, idArea) VALUES ('$value','$ide' )";
      $query6 = "SELECT id FROM direccion order by id DESC LIMIT 1";
      $rE = mysqli_query($connect,$query6);
      $nuevito = mysqli_fetch_row($rE);
      $idNuevo = $nuevito[0] + 1;//nuevo id para nueva area
      if(mysqli_query($connect, $query4))
      {
        echo '';
      }
      $query4=  "UPDATE personas SET idDir='$idNuevo' WHERE id = '".$_POST["id"]."'";
      if(mysqli_query($connect, $query4))
      {
        echo 'Directorio Actualizado';
      }
    }
    else{
      $query4=  "UPDATE personas SET idDir='$prueba2' WHERE id = '".$_POST["id"]."'";
      if(mysqli_query($connect, $query4))
      {
        echo 'Directorio Actualizado';
      }
    }
  }

 if(mysqli_query($connect, $query . $query2))
 {
  echo 'Directorio Actualizado';
 }
 else {
  echo '';
 }
}
?>
