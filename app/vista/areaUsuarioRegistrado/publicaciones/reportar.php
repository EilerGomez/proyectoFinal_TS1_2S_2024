<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSS-->
    <link rel="stylesheet" type="text/css" href="http://localhost/proyecto_final_ts1/assets/css/main.css">
    <title>Reportar esta publicacion</title>
</head>

<body>
    <div>
        <div class="content-wrapper">
            <div>
                <div class="col-md-8">
                    <div class="card">
                        <div class="row">
                            <div class="col-lg-11">
                                <div class="well bs-component">
                                    <form class="form-horizontal" method="POST" action="http://localhost/proyecto_final_ts1/?c=usuarioregistrado&a=RealizarReporte&n=<?= $n ?>&rol=<?= $rol ?>&id=<?= $id ?>">
                                        <fieldset>
                                            <legend>Reportar esta publicacion</legend><br>
                                            <p><?= $pr->getDescripcion() ?></p>
                                            <?php if (!empty($pr->getImagen())): ?>
                                                <img src="<?= $pr->getImagen() ?>" class="img-fluid rounded mb-3" alt="Sin imagen">
                                            <?php endif; ?><br>

                                            <div class="form-group">
                                                <input class="form-control" type="hidden"
                                                    name="idP" id="idP" value="<?= $pr->getId() ?>">
                                            </div>
                                            <div class="form-group">
                                                <label class="col-lg-2 control-label" for="motivo">Motivo*</label>
                                                <div class="col-lg-10">
                                                    <input class="form-control" id="motivo" name="motivo" type="text" placeholder="Motivo" required>
                                                </div>
                                            </div>


                                            <div class="form-group">
                                                <div class="col-lg-15 col-lg-offset-4">
                                                    <button class="btn btn-default" type="button" onclick="window.location.href='http://localhost/proyecto_final_ts1/?c=usuarioregistrado&a=Inicio&n=<?= $n ?>&rol=<?= $rol ?>&id=<?= $id ?>'">Cancelar</button>
                                                    <button class="btn" id="submitBtn" type="submit" style="background-color: #007bff; color: white;">Hacer reporte</button>
                                                </div>
                                            </div>

                                        </fieldset>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Javascripts-->
    <script src="http://localhost/proyecto_final_ts1/assets/js/jquery-2.1.4.min.js"></script>
    <script src="http://localhost/proyecto_final_ts1/assets/js/bootstrap.min.js"></script>
    <script src="http://localhost/proyecto_final_ts1/assets/js/plugins/pace.min.js"></script>
    <script src="http://localhost/proyecto_final_ts1/assets/js/main.js"></script>


</body>

</html>