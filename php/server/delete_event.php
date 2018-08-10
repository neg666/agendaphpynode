<?php
require('class.php');
session_start();

if (isset($_SESSION['username'])){          // Si hay sesion iniciada
	$conn = new ConectorDB();
	if ($conn->initConexion()){								// Nos conectamos a la base de datos
		if ($conn->deleteData('eventos', 'id ='.$_POST['_id'])){
			$response['msg'] = 'OK';							// Inidcar que se elimino el evento
		} else $response['msg'] = 'No se pudo elimiar el evento';
	} else $response['msg'] = 'No se pudo conectar con la base de datos';
} else $response['msg'] = 'logout';     // Indicar que el usuario no esta logeado

$conn->closeConexion();                // Cerramos siempre la conexión
echo json_encode($response);

?>
