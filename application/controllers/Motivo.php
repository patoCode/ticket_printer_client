<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Motivo extends CI_Controller {
	public function __construct()
    {
		parent::__construct();
		$this->load->model('Motivo_model','motivo');
    }
    public function list()
    {
    	$tipo = trim($this->input->post("tipo"));
    	$motivoList = $this->motivo->findByTipo($tipo);
    	if($motivoList != null){
    		$respuesta = array('response' => 1, 'data' => $motivoList,'msg' => 'ok');
    	}else{
    		$respuesta = array('response' => 0, 'data' => $motivoList,'msg' => "No existen motivos de pausa creados");
    	}
        echo json_encode($respuesta);
    }

}