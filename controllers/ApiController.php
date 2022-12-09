<?php 

namespace Controllers;

use Model\Cita;
use Model\Servicio;
use Model\CitaServicio;

class APIController{
    public static function index()
    {
        $servicios = Servicio::all();//consulto tabla servicios

        echo json_encode($servicios);//trasnformo la consulta a json
    }

    public static function guardar()
    {
        //creo el objeto Cita con los datos enviados
        $cita = new Cita($_POST);

        //inserta la cita y devuelve el id
        $resultado = $cita->guardar();//retorna true y el id
        $id = $resultado['id'];

        //almacena la cita y el id
        $idServicios = explode(",", $_POST['servicios']);//retrona como string y lo transformo a array

        //almacena los servicios con el id de la cita
        foreach($idServicios as $idSerivicio){
            $args = [
                'citaId' => $id,
                'servicioId' => $idSerivicio
            ];
            $citaServicio = new CitaServicio($args);
            $citaServicio->guardar();
        }

        //retornamos una respuesta
        echo json_encode(['resultado' => $resultado]);
    }

    public static function eliminar()
    {
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $id = $_POST['id'];

            $cita = Cita::find($id);
            $cita->eliminar();
            header("Location: " . $_SERVER['HTTP_REFERER']);
        }   
    }
}
?>
