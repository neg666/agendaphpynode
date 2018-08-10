<?php
  
require('class.php');

session_start();

if (isset($_SESSION['username'])) { // Si el usuario ha iniciado sesión
	
	$conn = new ConectorDB();
	if ($conn->initConexion()) {  // Si hay conexion con la base de datos
		$response['msg'] = 'OK';
		// Consultamos el usuario para obtener el ID
		$result = $conn->getData(['usuarios'], ['*'], 'WHERE username = "'.$_SESSION['username'].'"');
		$fila = $result->fetch_assoc();
		// Consultamos los eventos del usuario
		$result = $conn->getData(['eventos'], ['*'], 'WHERE fk_usuario = "'.$fila['id'].'"');
		$i = 0;
		while ($fila = $result->fetch_assoc()) {
			$response['eventos'][$i]['_id'] = $fila['id'];
			$response['eventos'][$i]['title'] = $fila['titulo'];
			if ($fila['allday'] == 0) {
				$response['eventos'][$i]['allday'] = false;
				$response['eventos'][$i]['start'] = $fila['fecha_inicio'].' '.$fila['hora_inicio'];
				$response['eventos'][$i]['end'] = $fila['fecha_fin'].' '.$fila['hora_fin'];
			} else {
				$response['eventos'][$i]['allday'] = true;
				$response['eventos'][$i]['start'] = $fila['fecha_inicio'];
				$response['eventos'][$i]['end'] = '';
			}
			$i++;			
		}
	} else $response['msg'] = 'No se puedo conectar con la base de datos';	
} else $response['msg'] = 'Ud no ha iniciado sesión';

$conn->closeConexion();         // Cerramos la conexion a la base de datos
echo json_encode($response);
?>
