<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSS-->
    <link rel="stylesheet" type="text/css" href="http://localhost/proyecto_final_ts1/assets/css/main.css">
    <title>Nueva publicacion</title>
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
                                    <form class="form-horizontal" method="POST" action="http://localhost/proyecto_final_ts1/?c=publicacion&a=GuardarEvento&n=<?= $n ?>&rol=<?= $rol ?>&id=<?= $id ?>" enctype="multipart/form-data">
                                        <fieldset>
                                            <legend>Ingrese los datos para la nueva publicacion</legend>
                                            <div class="form-group">
                                                <label class="col-lg-2 control-label" for="lugar">Lugar*</label>
                                                <div class="col-lg-10">
                                                    <input class="form-control" id="lugar" name="lugar" type="text" placeholder="Lugar" required>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-lg-2 control-label" for="fecha">Fecha*</label>
                                                <div class="col-lg-10">
                                                    <input class="form-control" id="fecha" name="fecha" type="date" placeholder="Fecha" required>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-lg-2 control-label" for="hora">Hora*</label>
                                                <div class="col-lg-10">
                                                    <input class="form-control" id="hora" name="hora" type="time" placeholder="Hora" required>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-lg-2 control-label" for="cupo">Cupo*</label>
                                                <div class="col-lg-10">
                                                    <input class="form-control" id="cupo" name="cupo" type="number" placeholder="Cupo de evento" required>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-lg-2 control-label" for="url">Url*</label>
                                                <div class="col-lg-10">
                                                    <input class="form-control" id="url" name="url" type="text" placeholder="Url del evento" required>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-lg-2 control-label" for="publico">Publico*</label>
                                                <div class="col-lg-10">
                                                    <select class="form-control" id="publico" name="publico" required>
                                                        <option value="T">Todos</option>
                                                        <option value="ME">Menores de edad</option>
                                                        <option value="MA">Mayores de edad</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-lg-2 control-label" for="imagen">Imagen</label>
                                                <div class="col-lg-10">
                                                    <input class="form-control" id="imagen" name="imagen" type="file" placeholder="Agrega una imagen">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-lg-15 col-lg-offset-4">
                                                    <button class="btn btn-default" type="button" onclick="window.location.href='http://localhost/proyecto_final_ts1/?c=publicacion&a=Home&n=<?= $n ?>&rol=<?= $rol ?>&id=<?= $id ?>'">Cancelar</button>
                                                    <button class="btn" id="submitBtn" type="submit" style="background-color: #007bff; color: white;">Crear publicacion</button>
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

    <script>
        const password1 = document.getElementById('password1');
        const password2 = document.getElementById('password2');
        const submitBtn = document.getElementById('submitBtn');

        // Verificar si las contraseñas coinciden
        function checkPasswords() {
            if (password1.value === password2.value && password1.value.length > 0) {
                submitBtn.disabled = false; // Habilitar el botón si las contraseñas coinciden
            } else {
                submitBtn.disabled = true; // Deshabilitar el botón si no coinciden
            }
        }

        // Ejecutar la validación cuando se modifiquen las contraseñas
        password1.addEventListener('input', checkPasswords);
        password2.addEventListener('input', checkPasswords);
    </script>
</body>

</html>