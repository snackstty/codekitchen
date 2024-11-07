<?php
//////////////////////////////////////////////////////////
// CONEXIÓN CON LA BBDD
// Hay que poner los parámetros correctos para conectarse a la base de datos
$con = mysqli_connect(
	"localhost", 		// nombre del servidor
	"user123", 			// usuario
	"Password123", 		// contraseña
	"database_name"	// base de datos
);
mysqli_query($con, "SET NAMES utf8");
//////////////////////////////////////////////////////////


//////////////////////////////////////////////////////////
// SANEADO DE PARÁMETROS
// Aquí tienes que añadir el código que hace el saneado de los parámetros $_GET, $_POST y $_REQUEST

foreach($_REQUEST as $clave => $valor) {
	$saneado = strip_tags($valor);
	$saneado = htmlspecialchars($saneado);
	$_REQUEST[$clave] = $saneado;
}
foreach($_GET as $clave => $valor) {
	$saneado = strip_tags($valor);
	$saneado = htmlspecialchars($saneado);
	$_GET[$clave] = $saneado;
}
foreach($_POST as $clave => $valor) {
	$saneado = strip_tags($valor);
	$saneado = htmlspecialchars($saneado);
	$_POST[$clave] = $saneado;
}
//////////////////////////////////////////////////////////

?>