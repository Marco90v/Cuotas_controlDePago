<?php
    include ("modelo.php");
    $datos = json_decode(file_get_contents("php://input"));

    // if($datos->accion==1){
    //     $accion = new Modelo();
    //     echo $accion->cargar();
    // }else if($datos->accion==2){
    //     $accion = new Modelo();
    //     echo $accion->NuevoUsuario($datos);
    // }else if($datos->accion==6){
    //     $accion = new Modelo();
    // }

    // switch ($datos->accion) {
    //     case 1:
    //         $accion = new Modelo();
    //         echo $accion->cargar();
    //         break;
    //     case 2:
    //         $accion = new Modelo();
    //         echo $accion->NuevoUsuario($datos);
    //     case 6:
    //         $accion = new Modelo();
    //     default:
    //         # code...
    //         break;
    // }

    if (isset($datos)) {
        // Instanccia de modelo para las accion del backend
        $accion = new Modelo();
        // Acciones
        switch ($datos->accion) {
            case 1:
                echo $accion->cargar();
                break;
            case 2:
                echo $accion->nuevoUsuario($datos);
                break;
            case 6:
                echo $accion->cargarMonto();
            break;
            case 7:
                echo $accion->nuevoMonto($datos);
                break;
            default:
                echo "Accion no valida";
                break;
        }
    }
    
?>