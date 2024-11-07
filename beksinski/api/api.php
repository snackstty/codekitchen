<?php
include_once("../inc/ajustes.php");

$comando = $_REQUEST['comando'];

$out = array();			// Este array será el que devolveremos como JSON
$out['data'] = array();
$out['meta'] = array();

// Examinamos el valor de la variable $comando:
switch($comando) {
	case "galeria":
		$sql = "SELECT * FROM bek_obras";
		$resultado = mysqli_query($con, $sql);
		$out['data'] = mysqli_fetch_all($resultado, MYSQLI_ASSOC);
		$out['meta']['ok'] = true;
		break;
		
		
	case "eventos":
		$sql = "SELECT * FROM bek_eventos";
		$resultado = mysqli_query($con, $sql);
		$out['data'] = mysqli_fetch_all($resultado, MYSQLI_ASSOC);
		$out['meta']['ok'] = true;
		break;
		
		
	case "contacto":
		// Para el comando de contacto, nos hacen falta los datos enviados por el formulario
		// Estos datos los tengo en el array $_POST (el $_REQUEST también podría valer)
		$out['meta']['cosas'] = $_POST;	
		$errores = "";
		
		////////////////////////////////////////////////////////////////////////
		// TÚ SÓLO TIENES QUE HACER LO QUE ESTÁ ENTRE ESTAS LÍNEAS
		////////////////////////////////////////////////////////////////////////
		// VALIDACIÓN - Hay que validar lo siguiente:
		// nombre - obligatorio
		// email - obligatorio
		// email - formato válido
		// asunto - distinto de 0
		// mensaje - obligatorio
		
		if($_REQUEST['nombre'] == "") {
			$errores .= "El nombre de usuario es obligatorio\n";
		}
		
		if($_REQUEST['email'] == "") {
			$errores .= "El email es obligatorio\n";
		}
		else if (!filter_var($_REQUEST['email'], FILTER_VALIDATE_EMAIL)) {
    			$errores .= "El formato de email no es válido\n";
			}
		
		if($_REQUEST['asunto'] == 0) {
			$errores .= "Debes seleccionar el asunto\n";
		}
		
		if($_REQUEST['mensaje'] == "") {
			$errores .= "El mensaje es obligatorio\n";
		}
		
		////////////////////////////////////////////////////////////////////////

		if($errores == "") {
			// Se puede mejorar la seguridad aquí, con una consulta parametrizada, pero en este examen no pedimos tanto.
			$sql = "INSERT INTO bek_contactos(fecha, nombre, email, asunto, mensaje, ip, user_agent) VALUES(NOW(), '{$_POST['nombre']}', '{$_POST['email']}', '{$_POST['asunto']}', '{$_POST['mensaje']}', '{$_SERVER['REMOTE_ADDR']}', '{$_SERVER['HTTP_USER_AGENT']}')";
			$resultado = mysqli_query($con, $sql);
			$out['meta']['ok'] = true;
		} else {
			$out['meta']['ok'] = false;
			$out['meta']['errores'] = $errores;
		}
		break;

	default: 
		$out['meta']['errores'] = "Comando no válido";
		$out['meta']['ok'] = false;
}
$out['meta']['params'] = $_REQUEST;
echo json_encode($out);
?>