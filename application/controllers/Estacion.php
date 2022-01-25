<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Estacion extends CI_Controller {

	public function __construct()
    {
		parent::__construct();
        $this->load->model('UsuarioEstacion_model','usrestacion');
    }
    public function bloquear($idZona)
    {
    	$response = 0;
    	$usuarioEstacion = $this->usrestacion->find($this->session->userdata('id_usuario'), $this->session->userdata('estacion'), $idZona);
    	if($usuarioEstacion != null){
    		if($this->usrestacion->updateEstado($usuarioEstacion->ID_USUARIO_ESTACION,EST_LOCK)){
    			$response = 1;
    			$mensaje = "Equipo bloqueado, solo un administrador puede desbloquear el equipo";
			}else{
				$mensaje = "Ocurrió un error al bloquear el equipo";
			}
    	}else{
			$mensaje = "El equipo no se encuentra, o se encuentra bloqueado.";
    	}
		$respuesta = array('response' => $response, 'mensaje' => $mensaje);
        echo json_encode($respuesta);
    }
    public function desbloquear()
    {
    	# code...
    }
}
