<?php
$connect = mysqli_connect("localhost", "pcspucv_dir", "Z?Z25Kjy7sevc#13", "pcspucv_dir");
mysqli_set_charset($connect, "utf8");
$query = "SELECT * FROM area";
$result = mysqli_query($connect, $query);
?>
<html>
    <head>
        <meta charset="UTF-8"/>
        <title>Directorio</title>
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
        @media screen and (max-width: 600px) {
  table {
    border: 0;
  }

  table caption {
    font-size: 1.3em;
  }

  table thead {
    border: none;
    clip: rect(0 0 0 0);
    height: 1px;
    margin: -1px;
    overflow: hidden;
    padding: 0;
    position: absolute;
    width: 1px;
  }

  table tr {
    border-bottom: 3px solid #ddd;
    display: block;
    margin-bottom: .625em;
  }

  table td {
    border-bottom: 1px solid #ddd;
    display: block;
    font-size: .8em;
    text-align: right;
  }

  td:nth-of-type(1) { font-weight: bold; }
  td:nth-of-type(1):before { content: "nombre"; }
  td:nth-of-type(2):before { content: "cargo"; }
  td:nth-of-type(3):before { content: "area"; }
  td:nth-of-type(4):before { content: "direccion"; }
  td:nth-of-type(5):before { content: "fono"; }
  td:nth-of-type(6):before { content: "email"; }

  table td::before {
    /*
    * aria-label has no advantage, it won't be read inside a table
    content: attr(aria-label);
    */
    content: attr(data-label);
    float: left;
    font-weight: bold;
    text-transform: uppercase;
  }

  table td:last-child {
    border-bottom: 0;
  }
}
        </style>
    </head>
    <body>
        <div class="container-fluid">
          <div align="left">
            <h1 align="center"></h1>
            <select  name="category" id="category" class="btn btn-info dropdown-toggle" style="background-color: #006eb6; color: #FFF" >
                <option value="">Buscar por Area</option>
                  <?php
                  while ($row = mysqli_fetch_array($result)) {
                      echo '<option value="' . $row["id"] . '">' . $row["nom"] . '</option>';
                  }
                  ?>
            </select>
        </div>
        <br>
        <div class="width200">
          <font size="2" face="Quicksand" >
            <table id="listado" style="width: 100%;" class="table table-bordered table-striped anotherhover">
                <thead>
                    <tr>
                      <th style="color: #000; font-size: 14px;"><font color="#006eb6"><i class="fas fa-user-circle fa-lg"></i></font>  NOMBRE</th>
                      <th style="color: #000; font-size: 14px;"><font color="#006eb6"><i class="fas fa-briefcase fa-lg"></i></font>  CARGO</th>
                      <th style="color: #000; font-size: 14px;"><font color="#006eb6"><i class="fas fa-building fa-lg"></i></font>  AREA</th>
                      <th style="color: #000; font-size: 14px;"><font color="#006eb6"><i class="fas fa-users fa-lg"></i></font>  DIRECCION</th>
                      <th style="color: #000; font-size: 14px;"><font color="#006eb6"><i class="fas fa-phone-volume fa-lg"></i></font>  FONO</th>
                      <th style="color: #000; font-size: 14px;"><font color="#006eb6"><i class="fas fa-envelope fa-lg"></i></font>  EMAIL</th>

                    </tr>
                </thead>
            </table>
          </font>
        </div>
      </div>
        <script type="text/javascript" src="librerias/bootstrap-3.3.6/dist/js/bootstrap.min.js"></script>
    </body>
</html>
<script type="text/javascript" language="javascript" >
    $(document).ready(function () {
      load_data();
      function load_data(is_category)
      {
          $('#listado').DataTable({
              "language": {
                  "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
              },
              "lengthMenu": [15, 25, 50, 100],
              "processing": true,
              "serverSide": true,
              "order": false,
              "ordering": false,
              "ajax": {
                  url: "../funcionesDirectorio/lectura.php",
                  type: "POST",
                  data: {is_category: is_category}
              },
              "columnDefs": [
                  {
                      "targets": [2],
                      "orderable": false
                  }
              ]
          });
      }

        $(document).on('change', '#category', function () {
            var category = $(this).val();
            $('#listado').DataTable().destroy();
            if (category != '')
            {
                load_data(category);
            } else
            {
                load_data();
            }
        });
    });


</script>
