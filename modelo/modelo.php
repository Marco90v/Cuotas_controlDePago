<?php
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE");
    header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
    
    setlocale(LC_TIME, "spanish");
    include ('conec.php');

    class Modelo {

        // Ejecución del Query
        private function querys($query){
            $conn = new cone();
            $result = $conn->consulQuery($query);
            unset($conn);
            return $result;
        }

        // Fecha actual
        private function fechaActual(){ return date("Y-m-d"); }

        // Dar formato al select para su devolución
        private function formatSelect($result){
            $fila;
            foreach ($result as $key => $value) {$fila[$key]=$value; }
            return $fila;
        }

        // Cargar todos loes elemento de la tabla miembro
        public function listMiembros($query = "select * from `miembros`"){
            $result = $this->querys($query);
            return $result->num_rows > 0 ? json_encode($this->formatSelect($result)) : '{"msg":false}';
        }

        // Agrega nuevo usuario
        public function nuevoUsuario($datos){
            $monto = $this->getUltimoMonto();
            if (!$monto){return '{"msg":"Debe agregar un Monto primero"}';}
            $result = $this->querys("select * from `miembros` where `cedula`=".$datos->ced);
            if ($result->num_rows > 0){return '{"msg":"Usuario ya Existe"}';}
            $query = "insert into `miembros` values (NULL, ".$datos->ced.",
            '".$datos->nomb."',
            '".$datos->apell."',
            ".$datos->cel.",
            '".$datos->eMail."',
            '".$datos->dateN."',
            '".$datos->dateI."',
            '".$datos->estado."')";
            $result = $this->querys($query);
            $d = json_decode('{"accion":2,"cedula":'.$datos->ced.',"monto":'.$monto[0]['monto'].',"fecha":"'.date("Y").'-'.date("m").'-1"}');
            $result = $result ? $this->setPago($d) : false;
            return json_encode($result);
            // return '{"msg":"Usuario Agregado"}';
        }

        // Agrega nuevo monto
        public function nuevoMonto($datos){
            $query = "insert into `montos` values (NULL, '".$this->fechaActual()."', '".$datos->monto."')";
            $result = $this->querys($query);
            if($result){
                $result = $this->querys("select * from `montos` order by id desc limit 1");
                return json_encode($this->formatSelect($result));
            }else{  $result = '{"msg":false}'; }
            return json_encode($result);
        }

        // Retorna lista de monto
        public function cargarMonto($query = "select * from `montos`"){
            $result = $this->querys($query);
            return $result->num_rows > 0 ? json_encode($this->formatSelect($result)) : '{"msg":false}';
        }

        // Retorna historial de pagos
        public function getPagos($cedula){
            $query = "select `pagos`.`id`, `miembros`.`cedula`, `miembros`.`nombre`, `miembros`.`apellido`, `pagos`.`f_pago`, `pagos`.`f_cancelacion`, `pagos`.`monto` from `miembros`, `pagos` where `miembros`.`cedula`=".$cedula." and `pagos`.`cedula`=".$cedula."";
            $result = $this->querys($query);
            return $result->num_rows > 0 ? json_encode($this->formatSelect($result)) : '{"msg":false}';
        }
    
        // Retorna ultimo pago y genera pagos pendientes
        public function getUltimoPago($cedula){
            $query = "select * from `pagos` where cedula = '".$cedula."' order by id desc limit 1";
            $result = $this->formatSelect($this->querys($query));
            $fA = new DateTime($this->fechaActual());
            $fC = new DateTime($result[0]["f_pago"]);
            $diferencia = $fC->diff($fA);
            $meses = $diferencia->m;
            if ($diferencia->m == 1){
                $fecha = $this->fechaActual();
                $mes = (int)explode("-", $fecha)[1];
                $monto = $this->getUltimoMonto()[0]["monto"];
                return '[{"fecha":"'.$fecha.'","mes":"'.$mes.'", "monto":"'.$monto.'"}]';
            }else if($diferencia->m >= 2){
                $monto = $this->getUltimoMonto()[0]["monto"];
                $fecha1 = $result[0]["f_pago"];
                $fecha2 = date("Y")."-".date("m")."-1";
                return '[{"mes":'.(int)explode("-", $fecha1)[1].',"fecha":"'.$fecha1.'", "monto":"'.$monto.'"},{"mes":'.(int)date("m").',"fecha":"'.$fecha2.'", "monto":"'.$monto.'"}]';
            }
            return '{"msg":false}';
        }

        // Retorna ultimo monto
        public function getUltimoMonto(){
            $query = "select monto from `montos` order by f_creacion desc limit 1";
            $result = $this->querys($query);
            return $result->num_rows > 0 ? $this->formatSelect($result) : false;
        }

        // Agrega pago
        public function setPago($d){
            $fechaActual = $this->fechaActual();
            if($d->accion==2){
                $query = "insert into `pagos` values (NULL, ".$d->cedula.", ".$d->monto.", '".$d->fecha."', '".$fechaActual."')";
                return $this->querys($query);
            }else if($d->accion==5){
                $res = false;
                foreach ($d->datos as $value) {
                    $query = "insert into `pagos` values (NULL, ".$d->cedula.", ".$value->monto.", '".$value->fecha."', '".$fechaActual."')";
                    $res = $this->querys($query);
                }
                return '{"msg":'.$res.'}';
            }
        }

        // Recuperar datos de un usuario en concreto
        public function getDatos($id){ return $this->listMiembros("select * from `miembros` where `id` = ".$id); }

        // Actualizar datos del usuario
        public function setDatos($datos){
           $query = "update `miembros` set `cedula`=".$datos->ced." , `nombre`='".$datos->nomb."' , `apellido`='".$datos->apell."' , `telefono`=".$datos->cel." , `correo`='".$datos->eMail."' , `nacimiento`='".$datos->dateN."' , `ingreso`='".$datos->dateI."' , `estado`='".$datos->estado."' where `id`='".$datos->id."' ";
           return $this->querys($query);
        }

    }

?>