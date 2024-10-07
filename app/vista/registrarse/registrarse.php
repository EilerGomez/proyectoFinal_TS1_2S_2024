<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSS-->
    <link rel="stylesheet" type="text/css" href="http://localhost/proyecto_final_ts1/assets/css/main.css">
    <title>Registrarse</title>
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
                                    <form class="form-horizontal" method="POST" action="http://localhost/proyecto_final_ts1/?c=usuario&a=GuardarUsuario">
                                        <fieldset>
                                            <legend>Ingrese sus datos</legend>
                                            <div class="form-group">
                                                <label class="col-lg-2 control-label" for="nombres">Nombres</label>
                                                <div class="col-lg-10">
                                                    <input class="form-control" id="nombres" name="nombres" type="text" placeholder="Nombres" required>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-lg-2 control-label" for="apellidos">Apellidos</label>
                                                <div class="col-lg-10">
                                                    <input class="form-control" id="apellidos" name="apellidos" type="text" placeholder="Apellidos" required>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-lg-2 control-label" for="telefono">Teléfono</label>
                                                <div class="col-lg-10">
                                                    <input class="form-control" id="telefono" name="telefono" type="number" placeholder="Teléfono" required>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-lg-2 control-label" for="edad">Edad</label>
                                                <div class="col-lg-10">
                                                    <input class="form-control" id="edad" name="edad" type="number" placeholder="Edad" required>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-lg-2 control-label" for="rol">Tipo</label>
                                                <div class="col-lg-10">
                                                    <select class="form-control" id="rol" name="rol" required>
                                                        <option value=2>Publicador</option>
                                                        <option value=3>Usuario registrado</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-lg-2 control-label" for="password1">Contraseña</label>
                                                <div class="col-lg-10">
                                                    <input class="form-control" id="password1" name="password1" type="password" placeholder="Contraseña" required>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-lg-2 control-label" for="password2">Confirmar</label>
                                                <div class="col-lg-10">
                                                    <input class="form-control" id="password2" name="password2" type="password" placeholder="Confirme su contraseña" required>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-lg-15 col-lg-offset-4">
                                                    <button class="btn btn-default" type="button" onclick="window.location.href='http://localhost/proyecto_final_ts1/'">Cancelar</button>
                                                    <button class="btn" id="submitBtn" type="submit" disabled style="background-color: #007bff; color: white;">Crear cuenta</button>
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