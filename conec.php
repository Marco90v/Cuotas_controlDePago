<?php
class cone
{
	private $datosConn = array(
			"direcSQL"=>"localhost",
			"nomSQL"=>"marco",
			"claveSQL"=>"1234",
			"BaseSQL"=>"masones");

	//INICIO DE SESION EN LA BASE DE DATOS
	private function conectar(){
		$conn = new mysqli($this->datosConn["direcSQL"],
							$this->datosConn["nomSQL"], 
							$this->datosConn["claveSQL"],
							$this->datosConn["BaseSQL"]);
		return $conn;}

	//REALIZAR CONSULTAS SQL
	function consulQuery($quer){
		$conex = $this->conectar();
		$res = $conex->query($quer);
		$conex->close();
		return $res;}
}

?>