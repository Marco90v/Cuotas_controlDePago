<?php
$c = 20262861;
$conn = new mysqli("localhost","marco", "1234","masones");
$res = $conn->query("select nomb from miembros where cedula = '20262861'");
while($fila = $res->fetch_array()){
	echo $fila["nomb"];
}
//echo $res;
$conn->close();
?>