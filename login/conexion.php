<?php

//Configurar nuestros datos de conexión a la BD ////////////////////////////////////////



$servidor = "localhost";
$usuario = "root";
$password ="";

$conexion = mysqli_connect($servidor, $usuario, $password) or die ("Error de conexión");



$conn = mysqli_connect('localhost','root','') or die("Error, conexion");

$bd = mysqli_select_db($conn,'practicas') or die("Error, Base de datos");

?>