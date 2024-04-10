<?php
include "../conexion/conexion.php"; // Incluye el archivo de conexión a la base de datos

session_start(); // Inicia la sesión

if (!isset($_SESSION['nombre'])) { // Verifica si el usuario está autenticado
    header("Location: ../index.php"); // Redirige a la página de inicio de sesión si no está autenticado
    exit;
}
date_default_timezone_set("America/Bogota");
setlocale(LC_ALL,"es_ES");
include "config.php"; // Incluye el archivo de configuración (aunque no se usa explícitamente en este script)
date_default_timezone_set("America/Bogota");
setlocale(LC_ALL,"es_ES");
$usuario = $_SESSION['nombre']; // Obtiene el nombre de usuario de la sesión

// Obtener el ID del usuario de la base de datos
mysqli_select_db($con, "practicas");
$sql = "SELECT id_usuario FROM usuario WHERE nombre='$usuario'";
$res = mysqli_query($con, $sql);
$fila = mysqli_fetch_assoc($res);
$id_usuario = $fila['id_usuario']; // Obtiene el ID de usuario

// Recibe los datos del formulario
$evento = $_POST["evento"];
$descripcion = $_POST["descripcion"];
$color = $_POST["color"];
// $fecha_fin = $_POST["fecha_fin"];
// $fecha_inicio = $_POST["fecha_inicio"];
$f_inicio          = $_REQUEST['fecha_inicio'];
$fecha_inicio      = date('Y-m-d', strtotime($f_inicio)); 

$f_fin             = $_REQUEST['fecha_fin']; 
$seteando_f_final  = date('Y-m-d', strtotime($f_fin));  
$fecha_fin1        = strtotime($seteando_f_final."+ 1 days");
$fecha_fin         = date('Y-m-d', ($fecha_fin1)); 
$id_etiqueta = $_POST["id_etiqueta"];
$id_estado = $_POST["id_estado"];

// Validación y manejo de archivos
$directorioSubida = "../ficheros/";
$max_file_size = "5120000";
$extensionesValidas = array("jpg", "png", "gif", "pdf");

if (isset($_FILES['fotografia']) && isset($_FILES['fotografia']['name'])) {
    $errores = 0;
    $nombreArchivo = $_FILES['fotografia']['name'];
    $filesize = $_FILES['fotografia']['size'];
    $directorioTemp = $_FILES['fotografia']['tmp_name'];
    $tipoArchivo = $_FILES['fotografia']['type'];
    $arrayArchivo = pathinfo($nombreArchivo);
    $extension = strtolower($arrayArchivo['extension']);

    if (!in_array($extension, $extensionesValidas)) {
        echo "Extensión no válida";
        $errores = 1;
    }
    if ($filesize > $max_file_size) {
        echo "El archivo debe tener un tamaño inferior";
        $errores = 1;
    }

    if ($errores == 0) {
        $nombreCompleto = $directorioSubida . $nombreArchivo;
        move_uploaded_file($directorioTemp, $nombreCompleto);
    }
}

// Si el estado es "Pendiente", establece la fecha de finalización como NULL
if ($id_estado == 'pendiente') {
    $fecha_fin = NULL;
}

// Insertar evento en la base de datos
$insertardos = "INSERT INTO eventoscalendar (archivos, color_evento, descripcion, evento, fecha_fin, fecha_inicio, id_etiquetas, id_usuario, id_estado) VALUES ('$nombreCompleto', '$color', '$descripcion', '$evento', '$fecha_fin', '$fecha_inicio', '$id_etiqueta', '$id_usuario', '$id_estado')";
$resultadoNuevoEvento =mysqli_query($con, $insertardos); // Ejecuta la consulta SQL para insertar el evento en la base de datos
// echo $insertardos; // Imprime el nombre del archivo subido (puede ser útil para depurar)
if ($resultadoNuevoEvento) {
    header("Location: calendario.php?e=1");
  }  // Redirige a la página principal después de completar la inserción del evento
  if (!$resultadoNuevoEvento) {
    echo "Error al insertar el evento: " . mysqli_error($con);
}
?>
