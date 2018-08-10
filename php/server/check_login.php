<?php

require('class.php');
$conn = new ConectorDB();

if ($conn->initConexion()){
	$username = $_POST['username'];
	$password = $_POST['password'];
	$response['msg'] = 'Conectado';
	$result = $conn->getData(['usuarios'], ['*'], 'WHERE username ="'.$username.'"');
	if ($result->num_rows > 0){ // Si encontro algun usuario
		if (password_verify($password, $result->fetch_assoc()['password'])){
			session_start();
			$_SESSION['username'] = $username;
			$response['msg'] = 'OK';
		} else $response['msg'] = 'Contraseña invalida';
	} else $response['msg'] = 'Usuario no valido';
} else $response['msg'] = 'No se ha podido conectar con la base de datos';

$conn->closeConexion();
echo json_encode($response);

?>
