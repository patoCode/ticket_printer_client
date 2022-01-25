<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ticket extends CI_Controller {

	public function __construct()
  {
		parent::__construct();
		$this->load->model('Categoria_model','categoria');
		$this->load->model('CategoriaZona_model','cz');
		$this->load->model('CategoriaZonaBitacora_model','czb');
		$this->load->model('Ticket_model','tk');
  }
	public function create($id_categoria_zona)
	{
		$hoy                          = date("Y-m-d");
		$hora                         = date("H:i:s");
		$categoria_zona_bitacora_data = $this->czb->getByCategoriaZonaToday($id_categoria_zona, $hoy);
		$categoria_zona_data          = $this->cz->getById($id_categoria_zona);
		/* DATOS PARA TICKET */
		$id_zona          = $categoria_zona_data->id_zona;
		$codigo_zona      = $categoria_zona_data->codigo_zona;
		$nombre_zona      = $categoria_zona_data->nombre_zona;
		$codigo_categoria = $categoria_zona_data->codigo_cat;
		$nombre_categoria = $categoria_zona_data->nombre_cat;
		$id_categoria     = $categoria_zona_data->id_categoria;
		$prioridad_cat    = $categoria_zona_data->prioridad;
		/* END DATOS PARA TICKET*/
		if($categoria_zona_bitacora_data == '0'){
			$data = array(
				'ID_CATEGORIA_ZONA'    => $id_categoria_zona,
				'FECHA_REG'            => $hoy,
				'HORA_INICIO_ATENCION' => $hora,
				'SECUENCIAL_ZONA_CAT'  => 0,
				'CODIGO'               => $codigo_zona.SIST_SEP.$codigo_categoria
			);
			$id = $this->czb->createAutomatic($data);
			$categoria_zona_bitacora_data = $this->czb->getById($id);
		}
		$id_cat_zona_bitacora = $categoria_zona_bitacora_data->ID_CAT_ZONA_BITACORA;
		$numero_ticket        = $categoria_zona_bitacora_data->SECUENCIAL_ZONA_CAT + SIST_INC;
		$codigo_ticket        = $categoria_zona_bitacora_data->CODIGO.SIST_SEP.($numero_ticket);

		$ticket_data = array(
			'id_categoria'    => $id_categoria,
			'id_zona'         => $id_zona,
			'numero'          => $numero_ticket,
			'codigo'          => $codigo_ticket,
			'prioridad'       => $prioridad_cat,
			'qr'              => '...',
			'usuario_reg'     => 'localhost',
			'fecha_reg'       => $hoy,
			'estado'          => TK_EST_1,
			'fecha_impresion' => $hoy,
			'hora_impresion'  => $hora
		);
		$insert_ticket = $this->tk->insert($ticket_data);
		if($insert_ticket)
		{
			$this->czb->updateSecuencial($id_cat_zona_bitacora, $numero_ticket);
			$ticket_data['fecha_impresion_view'] = format_date_view($hoy);
			$respuesta = array('response' => 1, 'ticket'=>$ticket_data, 'categoria'=>$nombre_categoria, 'zona' => $nombre_zona);
			if(PRINTER_ONLINE){
				try{
					$this->load->library('ReceiptPrint');
					$this->receiptprint->printTicket($respuesta);
				} catch (Exception $e) {
					echo $e->getMessage();
				  log_message("error", "Error: Could not print. Message ".$e->getMessage());
				  $this->receiptprint->close_after_exception();
				}
			}
			echo json_encode($respuesta);
		}
		else
		{

			$respuesta = array('response' => 0, 'ticket'=>$ticket_data);
			echo json_encode($respuesta);
		}
	}
	public function updateCountdown()
	{
		$id = $this->input->post('ticket');
		$countdown = $this->_operacionCount($id);

		if($countdown > 0 ){
			$data = array('COUNTDOWN' => $countdown,'SHOW_ALERT'=> 'si');
			$this->tk->update($data, $id);
		}
		echo 1;
	}
	private function _operacionCount($id)
	{
		$res = 0;
		$ticket = $this->tk->getById($id);
		if($ticket != null){
	   	$res = $ticket->COUNTDOWN + COUNTDOWN_TIME*60;
		}
		return $res;
	}
	public function alertList()
	{
		$data = array();
		$response = 1;
		$message = "";
	    if($this->session->userdata('notificable')){
				$list = $this->tk->getAlertList();
				if($list != null){
					foreach($list as $ticket){
						$datosAtencion = $this->tk->getAtencionInfo($ticket->ID_TICKET);
						if($datosAtencion != null){
							$lineaMessage = array('idTicket'=>$ticket->ID_TICKET,'codigo' => $ticket->CODIGO,"usuario" => $datosAtencion->username,"zona"=>$datosAtencion->nombreZona,"estacion"=>$datosAtencion->nombreEstacion);
									array_push($data, $lineaMessage);
							//$this->tk->update(array('SHOW_ALERT','no'),$ticket->ID_TICKET);
						}
					}
					$response = 0;
					$message = "Encontrados ".count($data);
				}
	    }else{
				$message = "Sin resultados";
	    }
	    $respuesta = array("response" => $response, "data" => $data, "mensaje" => $message);
	    echo json_encode($respuesta);
	}
	public function update(){
		$id = $this->input->post('id');
		$data = array('SHOW_ALERT'=>'no');
		$this->tk->update($data,$id);
		echo json_encode(array('data' => 1, 'response' => 0));
	}
	public function info()
  {
      echo phpinfo();
  }
	public function test()
    {
		try {
		  $this->load->library('ReceiptPrint');
		  $this->receiptprint->testDemo();
		} catch (Exception $e) {
		  log_message("error", "Error: Could not print. Message ".$e->getMessage());
		  $this->receiptprint->close_after_exception();
		}

    }

}
