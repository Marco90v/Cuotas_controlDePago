<?php
	class cone
	{
		private $datosConn = array(
				"direcSQL"=>"localhost",
				"nomSQL"=>"root",
				"claveSQL"=>"",
				"BaseSQL"=>"cuotas");

		private $c_t_Miembros=
			"create table `miembros` (
				`id` int(11) NOT NULL AUTO_INCREMENT,
				`cedula` int(9) NOT NULL,
				`nombre` varchar(50) NOT NULL,
				`apellido` varchar(50) NOT NULL,
				`telefono` int(15) NOT NULL,
				`correo` varchar(50) NOT NULL,
				`nacimiento` date NOT NULL,
				`ingreso` date NOT NULL,
				`estado` int(1) NOT NULL,
				PRIMARY KEY (id)
			)";

		private $c_t_Pagos =
			"create table `pagos` (
				`id` int (11) NOT NULL AUTO_INCREMENT,
				`ceduela` int (9) NOT NULL,
				`cuota` int (9) NOT NULL,
				`monto` int (9) NOT NULL,
				`estado` int (1) NOT NULL,
				`f_pago` date NOT NULL,
				`f_cancelacion` date NOT NULL,
				PRIMARY KEY (id)
			)";

		private $c_t_Montos =
			"create table `montos` (
				`id` int (11) NOT NULL AUTO_INCREMENT,
				`f_creacion` date NOT NULL,
				`monto` int (9) NOT NULL,
				PRIMARY KEY (id)
			)";

		//INICIO DE SESION EN LA BASE DE DATOS
		private function conectar(){
			$conn = new mysqli($this->datosConn["direcSQL"],
								$this->datosConn["nomSQL"],
								$this->datosConn["claveSQL"]);
			$conn = $this->conecDB($conn);
			$conn = $this->createTable($conn);
			return $conn;}

		//REALIZAR CONSULTAS SQL
		function consulQuery($quer){
			$conex = $this->conectar();
			$res = $conex->query($quer);
			$conex->close();
			return $res;}

		// CONECTA A LA BASE DE DATOS, SI NO EXISTE LLAMA A LA FUNCION PARA CREARLA
		private function conecDB($conn){ return $conn->select_db($this->datosConn["BaseSQL"]) ? $conn : $this->createDB($conn); }

		// CREAR BASE DEDATOS, UNA VEZ CREADA LLAMA A LA FUNCION PARA CREAR TABLAS
		private function createDB($conn){ return $conn->query("create database ".$this->datosConn["BaseSQL"]) ? $this->createTable($conn) : false; }

		// SI LAS TABLAS NO EXISTEN LLAMA A LAS FUNCIONES PARA CREARLAS
		private function createTable($conn){
			$conn->select_db("cuotas");
			$conn->query("show tables like 'miembros'")->num_rows<1 ? $conn->query($this->c_t_Miembros) ? true: false : false;
			$conn->query("show tables like 'pagos'")->num_rows<1 ? $conn->query($this->c_t_Pagos) ? true : false : false;
			$conn->query("show tables like 'montos'")->num_rows<1 ? $conn->query($this->c_t_Montos) ? true : false : false;
			return $conn;
		}

		private function createTableMiembros($conn){ return $conn->query($this->c_t_Miembros) ? true : false; }
		private function createTablePagos($conn) { return $conn->query($this->c_t_Pagos) ? true : false; }
		private function creteTableMontos($conn) { return $conn->query($this->c_t_Montos) ? true : false; }

		// function prueba(){
		// 	return $this->conectar();
		// }
	}

// $insta = new cone();
// $conn = $insta->prueba();

?>