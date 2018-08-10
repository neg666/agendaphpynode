<?php

require('class.php');

$conn = new ConectorDB();
$conn->initConexion();         // Los datos ya estan en la clase ConectorDB

//************** PRIMER USUARIO ******************//
//** Consultamos si ya existe el usuario DEMO   **//
$result = $conn->getData(['usuarios'], ['*'], 'WHERE username ="demo"'); 
if ($result->num_rows == 0) {       // Si no existe
	// PREPARAMOS LOS DATOS
	$hash = password_hash('demo', PASSWORD_DEFAULT);
	$data['username'] = '"demo"';
	$data['password'] = '"'.$hash.'"';
	$data['nombre'] = '"Usuario demo para prueba"';
	$data['fec_nac'] = '"2018-05-26"';

	$conn->insertData('usuarios', $data);  // Agregamos el usuario
}
$conn->closeConexion(); // Cerramos la conexion a la base de datos
$response = 'Utilice los siguientes datos: <br> Usuario: demo | Contrase&ntilde;a: demo';

echo json_encode($response)
//************** SEGUNDO USUARIO ******************//
//	 READY FOR MORE



?>
