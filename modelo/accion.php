<?php
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE");
    header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

    include ("modelo.php");
    $datos = json_decode(file_get_contents("php://input"));
    if (isset($datos)) {
        // Instancia de modelo para las acción del backend
        $accion = new Modelo();
        // Acciones
        switch ($datos->accion) {
            case 1:
                echo $accion->listMiembros();
            break;
            case 2:
                echo $accion->nuevoUsuario($datos);
            break;
            case 3:
                echo $accion->getPagos($datos->cedula);
            break;
            case 4:
                echo $accion->getUltimoPago($datos->cedula);
            break;
            case 5:
                echo $accion->setPago($datos);
            break;
            case 6:
                echo $accion->cargarMonto();
            break;
            case 7:
                echo $accion->nuevoMonto($datos);
            break;
            case 8:
                echo $accion->getDatos($datos->id);
            break;
            case 9:
                echo $accion->setDatos($datos);
            break;
            default:
                echo "Accion no valida";
            break;
        }
    }
    
?>