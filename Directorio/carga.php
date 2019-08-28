<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" crossorigin="anonymous">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" crossorigin="anonymous"></script>
</head>
<body>
    <div id="wrap">
        <div class="container-fluid">
            <div class="row">
                <form class="form-horizontal" action="functions.php" method="post" name="upload_excel" enctype="multipart/form-data">
                    <fieldset>
                        <!-- Form Name
                        <legend>Carga Masiva de Datos Directorio PUCV</legend> -->
                        <!-- File Button -->

                        <div class="form-group">
                          <div class="col-sm-3">
                          </div>
                            <label class="col-sm-2 control-label" for="filebutton">Seleccione Archivo .csv</label>
                            <div class="col-sm-3">
                                <input type="file" name="file" id="file" class="input-large">
                            </div>
                            <div class="col-sm-3">
                            </div>
                        </div>
                        <!-- Button -->
                        <div class="form-group">
                          <div class="col-sm-3">
                          </div>
                            <label class="col-sm-2 control-label" for="singlebutton">Importar Datos</label>
                            <div class="col-sm-3">
                                <button type="submit" id="submit" name="Import" class="btn btn-primary button-loading" data-loading-text="Loading...">Importar</button>
                            </div>
                            <div class="col-sm-3">
                            </div>
                        </div>
                    </fieldset>
                </form>
            </div>
            <?php
               //get_all_records();
            ?>
        </div>
    </div>
</body>
</html>
