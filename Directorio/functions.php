<?php
$connect = mysqli_connect("localhost", "udb_directorio", "t2OVv3Dd", "db_directorio");
 if(isset($_POST["Import"])){

    $filename=$_FILES["file"]["tmp_name"];
     if($_FILES["file"]["size"] > 0)
     {
        $file = fopen($filename, "r");
          while (($getData = fgetcsv($file, 1000, ";")) !== FALSE)
           {
             $sql = "INSERT INTO personas (id, nombre, email, telefono, cargo, id_area, id_jerarq, idDir)
                   values ('".$getData[0]."','".$getData[1]."','".$getData[2]."','".$getData[3]."','".$getData[4]."', '".$getData[5]."', '".$getData[6]."', '".$getData[7]."')";

                   $result = mysqli_query($connect, $sql);

        if(!isset($result))
        {
          echo "<script type=\"text/javascript\">
              alert(\"Archivo Inválido: Por favor cargar nuevamente CSV.\");
              window.location = \"carga.php\"
              </script>";
        }
        else {
            echo "<script type=\"text/javascript\">
            alert(\"El archivo CSV ha sido importado satisfactoriamente.\");
            window.location = \"carga.php\"
          </script>";
        }
           }

           fclose($file);
     }
  }
 ?>
