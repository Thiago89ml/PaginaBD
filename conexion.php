<?php

$server = "localhost";
$user = "root";
$password = "";
$database = "usuarios";

// 1. Crear la conexión
$conexion = new mysqli($server, $user, $password, $database);

// Verificar la conexión
if ($conexion->connect_errno) {
    die("Conexión fallida: " . $conexion->connect_error);
}

// 2. Verificar si se enviaron datos a través del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Capturamos los datos basándonos EXACTAMENTE en el atributo 'name' de tu HTML
    // Usamos el operador null coalescing (?? '') para evitar que falle si un campo llega vacío
    $usuario      = mysqli_real_escape_string($conexion, $_POST['Usuario'] ?? '');
    $contrasena   = mysqli_real_escape_string($conexion, $_POST['Contrasena'] ?? '');
    $correo       = mysqli_real_escape_string($conexion, $_POST['Correo'] ?? '');
    $contacto     = mysqli_real_escape_string($conexion, $_POST['Contacto'] ?? '');
    $departamento = mysqli_real_escape_string($conexion, $_POST['Departamento'] ?? '');

    // 3. Preparar la consulta SQL
    // Si tu columna física de la base de datos de contraseña usa Ñ, cámbiala abajo (ej: Contraseña)
    $sql = "INSERT INTO usuario (Usuario, Contrasena, Correo, Contacto, Departamento) 
            VALUES ('$usuario', '$contrasena', '$correo', '$contacto', '$departamento')";

    // 4. Ejecutar la consulta
    if ($conexion->query($sql) === TRUE) {
        echo "<script>
                alert('¡Usuario registrado con éxito!');
                window.location.href = 'index.html'; 
              </script>";
    } else {
        echo "Error al registrar el usuario: " . $conexion->error;
    }
}

// Cerrar conexión
$conexion->close();

?>