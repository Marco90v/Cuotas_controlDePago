<?php
    include ('conec.php');

    class Modelo {

        // Ejecucion del Query
        private function querys($query){
            $conn = new cone();
            $result = $conn->consulQuery($query);
            unset($conn);
            return $result;
        }

        // Fecha actual
        private function fechaActual(){
            return date("Y")."-".date("m")."-".date("d");
        }

        // Dar formato al select para su devolucion
        private function formatSelect($result)
        {
            $fila;
            foreach ($result as $key => $value) {
                $fila[$key]=$value;
                //echo $key;
            }
            // echo $fila;
            // foreach ($variable as $row) {
            //     $fila["all"][]=$row;
            // }
            // print_r($fila);
            return $fila;
        }

        // Cargar todos loes elemento de la tabla miembro
        public function cargar(){
            $query = "select * from `miembros`";
            $result = $this->querys($query);
            // $this->formatSelect($result);
            return $result->num_rows > 0 ? json_encode($this->formatSelect($result)) : '{"msg":false}';
        }

        // Agrega nuevo suario
        public function nuevoUsuario($datos){
            $query = "insert into `miembros` values (NULL, ".$datos->ced.",
            '".$datos->nomb."',
            '".$datos->apell."',
            ".$datos->cel.",
            '".$datos->eMail."',
            '".$datos->dateN."',
            '".$datos->dateI."',
            '".$datos->estado."')";
            $result = $this->querys($query);
            return json_encode($result);
        }

        // Agrega nuevo monto
        public function nuevoMonto($datos){
            $query = "insert into `montos` values (NULL, '".$this->fechaActual()."', '".$datos->monto."')";
            $result = $this->querys($query);
            if($result){
                // $result = $this->cargarMonto("select top 1 * from `montos` order by id desc");
                // return $result;
                $result = $this->querys("select * from `montos` order by id desc limit 1");
                return json_encode($this->formatSelect($result));
            }else{
                $result = '{"msg":false}';
            }
            return json_encode($result);
        }

        public function cargarMonto($query = "select * from `montos`"){
            $result = $this->querys($query);
            return $result->num_rows > 0 ? json_encode($this->formatSelect($result)) : '{"msg":false}';
        }
    

    }

    // $datos['ced']=20262861;
    // $datos['nomb']="Marco";
    // $datos['apell']="Velasquez";
    // $datos['cel'] = 4148930664;
    // $datos['eMail']="correo@correo.com";
    // $datos['dateN']="1990-05-30";
    // $datos['dateI']="2020-04-18";
    // $datos['estado']=0;

    // $insta = new Modelo();
    // $datos = json_encode($datos);
    // $datos = json_decode($datos);
    // echo $insta->NuevoUsuario($datos);

    //echo true;

    // print_r($insta->cargar());

?>