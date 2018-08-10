<?php

class ConectorDB {
	// PARAMETROS ESPECIFICOS PARA ESTE PROYECTO
	private $host  = 'localhost';
	private $user  = 'a_general';
	private $pass  = 'sLW7t56V7qYwWK5Z';
	private $db    = 'agenda_db';
	private $conn;

	function __construct($params = ''){     // Si se define una conexion nueva
		if ($params != '') {
			$this->host = $params['host'];
			$this->user = $params['user'];
			$this->pass = $params['pass'];
			$this->db   = $params['db'];
		}
	}

	function initConexion(){       // Iniciar la conexión
		/*$params = Array(
			$this->host,
			$this->user,
			$this->pass,
			$this->db
		);		*/
		$this->conn = new mysqli($this->host, $this->user, $this->pass, $this->db);
		if ($this->conn->connect_error) return "Error: ".$this->conn->connect_error;
		else return true;
	}

	function getConexion(){        // Obtener la conexión
		return $this->conn;
	}

	function closeConexion(){      // Cerrar la conexión
		$this->conn->close();
	}

	function runQuery($sql){				// Ejecutar una consulta
		return $this->conn->query($sql);
	}

	function insertData($table, $data){   // Insertar datos en una tabla
		$sql = 'INSERT INTO '.$table.' (';
		$last = end(array_keys($data));
		foreach ($data as $key => $value) {
        $sql .= $key;
        if ($key != $last) $sql .= ', ';
        else $sql .= ')';
    }
    $sql .= ' VALUES (';
    foreach ($data as $key => $value) {
        $sql .= $value;
        if ($key != $last) $sql .= ', ';
        else $sql .= ');';
    }
		return $this->runQuery($sql);
	}

	function getData($table, $field, $cond = ''){  // Realizar una consulta
		$sql = 'SELECT ';
		$last = end(array_keys($field));
		foreach ($field as $key => $value) {
			$sql .= $value;
			if ($key != $last) $sql .= ', ';
			else $sql .= ' FROM ';
		}
		$last = end(array_keys($table));
		foreach ($table as $key => $value) {
			$sql .= $value;
			if ($key != $last) $sql .= ', ';
			else $sql .= ' ';
		}
		if ($cond != '') $sql .= $cond;
		else $sql .= ';';
		
		return $this->runQuery($sql);
	}

	function deleteData($table, $cond){         // Eliminas datos de una tabla
		$sql = 'DELETE FROM '.$table.' WHERE '.$cond.';';
		return $this->runQuery($sql);
	}

	// Actualizar datos de una tabla 
	function updateData($table, $field, $cond){     
		$sql = 'UPDATE '.$table.' SET ';
		$last = end(array_keys($field));
		foreach ($field as $key => $value) {
			$sql .= $key.' = '.$value;
			if ($key != $last) $sql .= ', ';
			else $sql .= ' WHERE '.$cond.';';
		}
		
		return $this->runQuery($sql);
	}

}
?>