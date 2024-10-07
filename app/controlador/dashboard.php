<?php
// Asegúrate de que el archivo tenga la extensión .php y no sólo HTML

// En dashboard.php, puedes hacer algo como esto:
echo "<script>
        const usuario = JSON.parse(localStorage.getItem('usuario'));
        console.log('Usuario recuperado:', usuario);
        
        if (usuario) {
            // Verificar el rol y redirigir según sea necesario
            if (usuario.rol === 1) {
                window.location.href = 'admin_dashboard.php'; // Redirigir a un dashboard de administrador
            }else if(usuario.rol===2){
                window.location.href = 'http://localhost/proyecto_final_ts1/?c=publicacion&a=Inicio&n='+usuario.nombres + '&rol='+usuario.rol+'&id='+usuario.id; // Redirigir a un dashboard de publicador
            } 
            else {
                window.location.href = 'http://localhost/proyecto_final_ts1'; // Redirigir a un dashboard de usuario normal
            }
        } else {
            // Manejo de error si no hay usuario en localStorage
            console.error('No hay usuario en localStorage.');
            window.location.href = 'http://localhost/proyecto_final_ts1'; // Redirigir a login si no hay usuario
        }
      </script>";

exit();
