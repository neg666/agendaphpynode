<?php
require('class.php');
session_start();

if (isset($_SESSION['username'])){          // Si hay sesion iniciada
	$conn = new ConectorDB();
	if ($conn->initConexion()){								// Nos conectamos a la base de datos
		$data['fecha_inicio'] = '"'.$_POST['start_date'].'"';
		$data['fecha_fin']    = '"'.$_POST['end_date'].'"';
		$data['hora_inicio']  = '"'.$_POST['start_hour'].'"';
		$data['hora_fin']     = '"'.$_POST['end_hour'].'"';
		if ($conn->updateData('eventos', $data, 'id = '.$_POST['_id'])){
			$response['msg'] = 'OK';							// Inidcar que se actualizo el evento
		} else $response['msg'] = 'No se pudo actualizar el evento';
	} else $response['msg'] = 'No se pudo conectar con la base de datos';
} else $response['msg'] = 'logout';     // Indicar que el usuario no esta logeado

$conn->closeConexion();          // Cerramos la conexion a la base de datos
echo json_encode($response);


?>
