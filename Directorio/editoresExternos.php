<?php
$connect = mysqli_connect("localhost", "pcspucv_dir", "Z?Z25Kjy7sevc#13", "pcspucv_dir");
mysqli_set_charset($connect, "utf8");
$query = "SELECT * FROM area";
$result = mysqli_query($connect, $query);
$query2 = "SELECT * FROM jerarquia";
$result2 = mysqli_query($connect, $query2);
$query3 = "SELECT * FROM direccion";
$resultado = mysqli_query($connect, $query3);
?>
<html>
    <head>
	      <meta charset="UTF-8"/>
       <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
        <link rel="stylesheet" href="../librerias/bootstrap-3.3.6/dist/css/bootstrap.min.css" />
        <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>
        <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css" />
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
        <link href="https://fonts.googleapis.com/css?family=Quicksand|Raleway" rel="stylesheet">
        <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">

        <style type="text/css">
          .anotherhover tbody tr:hover td {
              background-color: #D3D3D3;
          }
          .table-bordered>tbody>tr>td, .table-bordered>tbody>tr>th, .table-bordered>tfoot>tr>td, .table-bordered>tfoot>tr>th, .table-bordered>thead>tr>td, .table-bordered>thead>tr>th {
    border: 1px solid #fff;
}
        </style>
    </head>
    <body>
        <div class="container-fluid">
          <h1 align="center"></h1>
            <div align="left">
                <button type="button" name="add" id="add" class="btn btn-success"><i class="material-icons">library_add</i></button>
            </div>
            <br>
            <div id="alert_message"></div>

            <div class="width200">
              <font size="2" face="Quicksand" >
                <table id="user_data" class="table table-bordered table-striped anotherhover">
                    <thead>
                        <tr>
                            <th style="color: #000; font-size: 14px;"><font color="#006eb6"><i class="fas fa-user-circle fa-lg"></i></font>  NOMBRE</th>
                            <th style="color: #000; font-size: 14px;"><font color="#006eb6"><i class="fas fa-briefcase fa-lg"></i></font>  CARGO</th>
                            <th style="color: #000; font-size: 14px;"><font color="#006eb6"><i class="fas fa-building fa-lg"></i></font>  ÁREA</th>
                            <th style="color: #000; font-size: 14px;"><font color="#006eb6"><i class="fas fa-users fa-lg"></i></font>  DIRECCIÓN</th>
                            <th style="color: #000; font-size: 14px;"><font color="#006eb6"><i class="fas fa-phone-volume fa-lg"></i></font>  FONO</th>
                            <th style="color: #000; font-size: 14px;"><font color="#006eb6"><i class="fas fa-envelope fa-lg"></i></font>  EMAIL</th>
                            <th style="color: #000; font-size: 14px;"></th>
                        </tr>
                    </thead>
                </table>
              </font>
            </div>
        </div>

    </body>
    <script type="text/javascript" language="javascript" >
    function showfield(name){
      if(name=='other')document.getElementById('div1').innerHTML='<input id="other" class="form-control" type="text" name="other" />';
      else document.getElementById('div1').innerHTML='';
      }
    function showfieldd(name){
      if(name=='otheer')document.getElementById('div2').innerHTML='<input id="otheer" class="form-control" type="text" name="otheer" />';
      else document.getElementById('div2').innerHTML='';
      }
        $(document).ready(function () {

            fetch_data();

            function fetch_data()
            {
                var dataTable = $('#user_data').DataTable({
                    "language": {
                        "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
                    },
                    "processing": true,
                    "serverSide": true,
                    "order": false,
                    "ordering": false,
                    "bInfo": false,
                    "ajax": {
                        url: "../funcionesDirectorio/fetch2.php",
                        type: "POST",
                        dataType: "json"
                    }
                });
            }

            function update_data(id, column_name, value)
            {
                $.ajax({
                    url: "../funcionesDirectorio/update.php",
                    method: "POST",
                    data: {id: id, column_name: column_name, value: value},
                    success: function (data)
                    {
                        $('#alert_message').html('<div class="alert alert-success">' + data + '</div>');
                        $('#user_data').DataTable().destroy();
                        fetch_data();
                    }
                });
                setInterval(function () {
                    $('#alert_message').html('');
                }, 5000);
            }

            $(document).on('blur', '.update', function () {
                var id = $(this).data("id");
                var column_name = $(this).data("column");

                var value = $(this).text();
                var validaRut = /^\d{7,8}-[k|K|\d]{1}$/;
                var reg = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.([a-zA-Z]{2,4})+$/;
                if (column_name != "rut" && column_name != "email") {
                    update_data(id, column_name, value);
                } else if (column_name == "rut" && validaRut.test(value)) {
                    update_data(id, column_name, value);
                } else if (column_name == "email" && reg.test(value)) {
                    update_data(id, column_name, value);
                } else {
                    alert("El e-mail no es validos");
                    window.location = "table.php";
                }
            });
            $('#add').click(function () {
                var html = '<tr>';
                //html += '<td></td>';
                html += '<td contenteditable id="data1"></td>';
                html += '<td contenteditable id="data5"></td>';
                html += '<td id="data6"><select name="category" id="category" class="form-control" onchange="showfield(this.options[this.selectedIndex].value)"><option value="">Seleccione Area</option><?php while ($row = mysqli_fetch_array($result)) {echo ('<option value="' . $row["id"] . '">' . $row["nom"] . '</option>');}?><option value="other">Otro</option></select><div id="div1"></div></td>';
                html += '<td id="data2"><select name="categoria" id="categoria" class="form-control" onchange="showfieldd(this.options[this.selectedIndex].value)"><option value="">Seleccione Direccion</option><?php while ($rowi = mysqli_fetch_array($resultado)) {echo ('<option value="' . $rowi["id"] . '">' . $rowi["nomb"] . '</option>');}?><option value="otheer">Otro</option></select><div id="div2"></div></td>';
                html += '<td contenteditable id="data4"></td>';
                html += '<td contenteditable id="data3"></td>';
                html += '<td><button type="button" name="insert" id="insert" class="btn btn-link btn-xs"><font color="#4cae4c"><i class="material-icons">person_add</i></font></button></td>';
                html += '</tr>';
                $('#user_data tbody').prepend(html);
            });

            $(document).on('click', '#borrado', function () {
              if (confirm("¿Estas seguro de eliminar este contacto?"))
                window.location = "../funcionesDirectorio/deleteTotal.php";

              });

            $(document).on('click', '#insert', function () {
                var nombre = $('#data1').text();
                //var rut = $('#data2').text();
                var email = $('#data3').text();
                var telefono = $('#data4').text();
                var cargo = $('#data5').text();
                if ($('#category option:selected').text()=="Otro"){
                  //var r= document.getElementById(div1);
                  var nom_area= document.getElementById("other").value;
                }
                else{
                  var nom_area=  $('#category option:selected').text();
                }
                if ($('#categoria option:selected').text()=="Otro"){
                  //var r= document.getElementById(div1);
                  var nom_dir= document.getElementById("otheer").value;
                }
                else{
                  var nom_dir=  $('#categoria option:selected').text();
                }

                var reg = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.([a-zA-Z]{2,4})+$/;
                if (nombre != '' && email == '') {
                    $.ajax({
                        url: "../funcionesDirectorio/insert.php",
                        method: "POST",
                        data: {nombre: nombre, email: email, telefono: telefono, cargo: cargo, nom_area: nom_area, nom_dir: nom_dir},
                        success: function (data)
                        {
                            $('#alert_message').html('<div class="alert alert-success">' + data + '</div>');
                            $('#user_data').DataTable().destroy();
                            fetch_data();
                        }
                    });
                    setInterval(function () {
                        $('#alert_message').html('');
                    }, 5000);
                } else if (nombre != '' && email != '' && reg.test(email))
                {
                    $.ajax({
                        url: "../funcionesDirectorio/insert.php",
                        method: "POST",
                        data: {nombre: nombre, email: email, telefono: telefono, cargo: cargo, nom_area: nom_area, nom_dir: nom_dir},
                        success: function (data)
                        {
                            $('#alert_message').html('<div class="alert alert-success">' + data + '</div>');
                            $('#user_data').DataTable().destroy();
                            fetch_data();
                        }
                    });
                    setInterval(function () {
                        $('#alert_message').html('');
                    }, 5000);
                } else
                {
                    alert("Debe llenar correctamente los datos");
                }
            });
            $(document).on('click', '.delete', function () {
                var id = $(this).attr("id");
                if (confirm("¿Estas seguro de eliminar este contacto?"))
                {
                    $.ajax({
                        url: "../funcionesDirectorio/delete.php",
                        method: "POST",
                        data: {id: id},
                        success: function (data) {
                            $('#alert_message').html('<div class="alert alert-success">' + data + '</div>');
                            $('#user_data').DataTable().destroy();
                            fetch_data();
                        }
                    });
                    setInterval(function () {
                        $('#alert_message').html('');
                    }, 5000);
                }
            });

            });

    </script>
</html>
