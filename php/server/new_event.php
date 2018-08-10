<?php
require('class.php');
session_start();



if (isset($_SESSION['username'])) { // Si el usuario ha iniciado sesión
	$conn = new ConectorDB();  
	if ($conn->initConexion()) {  // Si hay conexión con la base de datos
		$result = $conn->getData(['usuarios'], ['*'], 'WHERE username = "'.$_SESSION['username'].'"');	// Obtenermos el ID del usuario
		$fila = $result->fetch_assoc();
		$data['titulo'] = '"'.$_POST['titulo'].'"';
 		$data['fecha_inicio'] = '"'.$_POST['start_date'].'"';
  	$data['hora_inicio'] = '"'.$_POST['start_hour'].':00"';    /*Add ":00" to fill datetime format*/
  	$data['fecha_fin'] = '"'.$_POST['end_date'].'"';
  	$data['hora_fin'] = '"'.$_POST['end_hour'].':00"';         /*Add ":00" to fill datetime format*/
  	$data['allday'] = $_POST['allDay'];
  	$data['fk_usuario'] = '"'.$fila['id'].'"';

  	if ($conn->insertData('eventos', $data)) {                 // Insertamos el evento
  		$result = $conn->getData(['eventos'],['MAX(id) as id']);			 // Buscamos el ID del nuevo evento	
  		$fila = $result->fetch_assoc();
  		$response['id'] = $fila['id'];
  		$response['msg'] = 'OK';
  	} else $response['msg'] = 'No se pudo registrar el evento';
	
	} else $response['msg'] = 'No se pudo conectar a la base de datos';
} else $response['msg'] = 'logout';

$conn->closeConexion();   // Cerramos la conexion a la base de datos
echo json_encode($response);
?>
