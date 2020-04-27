<?php
	include ("conec.php");
	
	$dato = json_decode(file_get_contents("php://input"));

	//CONVERTIR DE CADENA A FECHA
	function converFecha($f){
		$fecha=strtotime($f);
		$fecha=date('Y-m-d',$fecha);
		return $fecha;}

	//EXTRAER MES Y CONVIERTE A INT
	function extraeMes($f){
		$f=strtotime($f);
		$mes = date('m',$f);
		return (int) $mes;
	}
	//EXTRAER AÑO Y CONVIERTE A INT
	function extraeAno($f){
		$f=strtotime($f);
		$ano = date('Y',$f);
		return (int) $ano;
	}

	//INSTANCIA
	function clase($q){
		$con = new cone();
		$r = $con->consulQuery($q);
		unset($con);
		return $r;
	}

	//FUNCION OBTENER MONTO DE LA ULTIMA CUOTA
	function mCuota(){
		$quer = "select monto from cuota order by fecha desc limit 1";
		$result = clase($quer);
		if(!$result){
			return "Error de Consulta";}
		else{
			$m=$result->fetch_array();
			return $m[0];}
	}

	//FUNCION CARGAR
	function cargar(){
		$resCade = "";
		$quer="select * from miembros";
		$result = clase($quer);
		$num = $result->num_rows;
		if($num<1){
			echo '{"msg":"No se encontro registro"}';}
		else{
			while($fila = $result->fetch_array()){
				if ($resCade != "") {$resCade .= ",";}
				$resCade.= '{"cedula" : "'.$fila["cedula"].'",';
				$resCade.= '"nombre" : "'.$fila["nomb"].'",';
				$resCade.= '"apellido" : "'.$fila["apell"].'",';
				$resCade.= '"cel" : "'.$fila["cel"].'",';
				$resCade.= '"eMail" : "'.$fila["correo"].'",';
				$resCade.= '"f_nac" : "'.$fila["f_nac"].'",';
				$resCade.= '"f_ingr" : "'.$fila["f_ingr"].'",';
				$resCade.= '"G" : "'.$fila["grado"].'"}';}
		echo '{"lista":['.$resCade.'], "Total":"'.$num.'"}';}
	}

	//FUNCION NUEVO
	function nuevo($dato){
		$quer="insert into miembros (cedula, nomb, apell, cel, correo, f_nac, f_ingr, grado) values ('".$dato->ced."',
																						'".$dato->nomb."',
																						'".$dato->apell."',
																						'".$dato->cel."',
																						'".$dato->correo."',
																						'".converFecha($dato->f_nac)."',
																						'".converFecha($dato->f_ingr)."',
																						'0')";
		$result = clase($quer);
		if(!$result){
			echo '{"msg":"Error al ingresar datos"}';}
		else{
			echo '{"msg":"Mienbro Agregado"}';}
	}

	function Cad_Fec($cad){
		$c = (string) $cad;
		if(strlen($c)<2){$c = "0".$c;}
		$var = strtotime('2000-'.$c.'-01');
		$var = date('m',$var);
		return $var;
	}


	//FUNCION CONSULTA PAGOS
	function consPago($ced){
		$fMs = (int) date("m");//FECHA MES SERVIDOR
		$fYs = (int) date("Y");//FECHA AÑO SERVIDOR
		$f_dR;
		$c;
		$resCade = "";
		$resCade2 = "";
		$cA = mCuota(); //MONTO DE LA ULTIMA CUOTA
		$quer="select * from pagos where cedula = '".$ced."' order by f_pago desc";

		$result = clase($quer);
		$num = $result->num_rows;
		if($num<1){
			echo '{"msg":"No se encontro registro de '.$ced.'"}';}
		else{
			$t=true;
			
			while($fila = $result->fetch_array()){
				if ($resCade != "") {$resCade .= ",";}
				$resCade.= '{"cedula" : "'.$fila["cedula"].'",';
				$resCade.= '"cuot" : "'.$fila["cuota"].'",';
				$resCade.= '"mont" : "'.$fila["monto"].'",';
				$resCade.= '"est" : "'.$fila["estado"].'",';
				$resCade.= '"f_p" : "'.$fila["f_pago"].'",';
				$resCade.= '"f_r" : "'.$fila["f_real"].'"}';

				if($t){
					$t=false;
					$f_dR = $fila["f_pago"];
					$c = $fila["cedula"];
				}
			}

			$M=extraeMes($f_dR);
			$A=extraeAno($f_dR);

			if($fMs > $M && $fYs==$A ){
				while ($M < $fMs) {
					if ($resCade2 != "") {$resCade2 .= ",";}

					$resCade2.= '{"cedula" : "'.$c.'",';
					$resCade2.= '"cuot" : "'.$cA.'",';
					$resCade2.= '"mont" : "0",';
					$resCade2.= '"est" : "Pendiente",';
					$resCade2.= '"f_p" : "'.$fYs.'-'.Cad_Fec($fMs).'",';
					$resCade2.= '"f_r" : "Sin Fecha"}';
					$fMs--;}				
			}
			elseif ($fYs>$A) {
				$n=1;
				while($A <= $fYs){
					while ($fMs >= $n) {
						if ($resCade2 != "") {$resCade2 .= ",";}

						$resCade2.= '{"cedula" : "'.$c.'",';
						$resCade2.= '"cuot" : "'.$cA.'",';
						$resCade2.= '"mont" : "0",';
						$resCade2.= '"est" : "Pendiente",';
						$resCade2.= '"f_p" : "'.$fYs.'-'.Cad_Fec($fMs).'",';
						$resCade2.= '"f_r" : "Sin Fecha"}';
						$fMs--;}
					$fYs--;
					$fMs = 12;
					if($A == $fYs){$n=$M;}
				}
			}
		echo '{"lista":['.$resCade.'], "lista2":['.$resCade2.']}';}
	}


	//ULTIMO REGISTRO DE PAGO
	function ult_R_P(){
		//$fMs = (int) date("m");//FECHA MES SERVIDOR
		//$fYs = (int) date("Y");//FECHA AÑO SERVIDOR
		$ultFP;//ULTIMA FECHA DE PAGO
		$ultRC;//ULTIMO REGISTRO DE CUOTA
		$quer = "select f_pago from pagos order by f_pago desc limit 1";
		$result = clase($quer);
		if(!$result){
			echo '{"msg":"Error de consulta"}';exit;}
		else{
			$f=$result->fetch_array();
			$ultFP = $f[0];
			$ultRC = mCuota();}
		if(extraeAno($ultFP) == (int) date("Y") && extraeMes($ultFP) ==(int) date("m")){
			echo '{"msg":"No posee cuotas pendientes"}';
		}
		else{
			echo '{"ulti_A":"'.extraeAno($ultFP).'","ulti_M":"'.Cad_Fec(extraeMes($ultFP)+1).'","mon_Cuo":"'.$ultRC.'", "aS":"'.date("Y").'","mS":"'.date("m").'"}';
		}
	}

	//FUNCION PARA PAGAR CUOTA
	function pagar($d){
		$fServer = date("Y-m-d");//FECHA SERVIDOR
		$quer = "insert into pagos (cedula, cuota, monto, estado, f_pago, f_real) 
					values ('".(int) $d->ced."', '".(int) $d->cuota."', '".(int) $d->monto."', 'Pago', '".converFecha($d->fp)."', '".$fServer."')";
		$result = clase($quer);
		if(!$result){
			echo '{"msg":"Error al realizar el pago", "msg2":0}';
		}
		else{
			echo '{"msg":"Pago realizado", "msg2":1}';
		}
	}

	//FUNCION RANGO DE REGISTROS A MOSTRAR
	function rango(){
		return 2;
	}

	//FUNCION PARA OBTENER EL HISTORIO DE LAS CUOTAS ESTABLECIDAS
	function carga_cuo(){
		$quer="select * from cuota";
		//$quer="select * from cuota order by fecha desc";
		$result = clase($quer);
		$num =$result->num_rows;
		$np = $num / rango();
		$np = round($np);
		if((rango() + 1) == $num){
			$np = $np +1;
		}
		if($num<1){
			echo '{"msg":"No existe registro historio de cuotas"}';}
		else{
			actualizar(1,$np,true);}
	}


	//FUNCION
	function actualizar($lim = 1, $num = 0, $v = false){
		$resCade = "";
		$rango = rango();
		$fin = $rango * $lim;
		if($rango==1){
			$quer="select * from cuota order by fecha desc limit ".($fin-1).", ".(rango());
		}
		else{
			$quer="select * from cuota order by fecha desc limit ".($fin - $rango).", ".$fin;
		}
		$result = clase($quer);
		while($fila = $result->fetch_array()){
			if ($resCade != "") {$resCade .= ",";}
			$resCade.= '{"fech" : "'.$fila["fecha"].'",';
			$resCade.= '"monto" : "'.$fila["monto"].'"}';}
		if($v){
			echo '{"lista":['.$resCade.'], "nreg":"'.$num.'"}';
		}
		else{
			echo '{"lista":['.$resCade.']}';
		}
	}


	//FUNCION QUE BUSCA Y RECUPERA DATOS DE USUARIO ESPESIFICO PARA LUEGO MODIFICAR
	function cargar2($ced){
		$resCade = "";
		$quer="select * from miembros where cedula='".$ced."'";
		$result = clase($quer);
		$num = $result->num_rows;
		if($num<1){
			echo '{"msg":"No se encontro registro"}';}
		else{
			while($fila = $result->fetch_array()){
				if ($resCade != "") {$resCade .= ",";}
				$resCade.= '{"cedula" : "'.$fila["cedula"].'",';
				$resCade.= '"nombre" : "'.$fila["nomb"].'",';
				$resCade.= '"apellido" : "'.$fila["apell"].'",';
				$resCade.= '"cel" : "'.$fila["cel"].'",';
				$resCade.= '"eMail" : "'.$fila["correo"].'",';
				$resCade.= '"f_nac" : "'.$fila["f_nac"].'",';
				$resCade.= '"f_ingr" : "'.$fila["f_ingr"].'",';
				$resCade.= '"G" : "'.$fila["grado"].'"}';}
			echo $resCade;
			}
	}



	//ACCION
	if($dato->accion==1){
		cargar();}
	elseif($dato->accion==2){
		nuevo($dato);}
	elseif($dato->accion==3){
		consPago($dato->ced);}
	elseif($dato->accion==4){
		ult_R_P($dato->ced);}
	elseif($dato->accion==5){
		pagar($dato);}
	elseif($dato->accion==6){
		carga_cuo();
	}
	elseif($dato->accion==7){
		actualizar($dato->nex);
	}
	elseif($dato->accion==8){
		cargar2($dato->ced);
	}
?>