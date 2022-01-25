<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require 'custom/PDF.php';
require 'custom/Filtro.php';
require 'custom/Result.php';
require 'custom/TicketDto.php';
require 'custom/AtencionDto.php';

class Reporte extends CI_Controller
{
	private $filtro;
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Reporte_model', 'rpt');
        $this->load->model('Estacion_model','estacion');
        $this->load->model('Zona_model', 'zona');
        $this->load->model('Categoria_model', 'categoria');
        $this->load->model('Usuario_model', 'usuario');
        $this->load->model('Ticket_model', 'tk');
	}
	public function index()
	{
		$this->load->view('admin/reportes_view');
	}
	public function getZonas()
	{
		$zonas = $this->zona->getActivas();
		if($zonas != null){
			$respuesta = array('response'=> 1, 'zonas' => $zonas, 'msg' => 'ZONAS RECUPERADAS '.count($zonas));
		}else{
			$respuesta = array('response' => 0, 'msg' => 'No se encontraron registros');
		}
		echo json_encode($respuesta);
	}
	public function getCategoriasByZona($idZona)
	{
		$categorias = $this->categoria->getCategoriaByZona($idZona);
		if($categorias != null){
			$respuesta = array('response'=>1, 'categorias'=> $categorias, 'msg'=>'CATEGORIAS RECUPERADAS '.count($categorias));
		}
		else{
			$respuesta = array('response' => 0, 'msg' => 'No se encontraron registros');
		}
		echo json_encode($respuesta);
	}
	public function getPersonas()
	{
		$valor = trim($this->input->post('search'));
		$usuarios = $this->usuario->search($valor);
		if($usuarios != null){
			$respuesta = array('response'=>1, 'personas'=> $usuarios, 'total' => count($usuarios),'msg'=>'PERSONAS RECUPERADAS '.count($usuarios));
		}else{
			$respuesta = array('response' => 0, 'msg' => 'No se encontraron registros');
		}
		echo json_encode($respuesta);
	}
	private function _validateFiltros($filtroPost)
	{

		if($filtroPost != null){
			$estado     = array_key_exists('estado', $filtroPost)?trim($filtroPost['estado']):'';
			$fini       = array_key_exists('fini', $filtroPost)?trim($filtroPost['fini']):'';
			$ffin       = array_key_exists('ffin', $filtroPost)?trim($filtroPost['ffin']):'';
			$reporte    = array_key_exists('reporte', $filtroPost)?trim($filtroPost['reporte']):'';
			$zonas      = array_key_exists('zona', $filtroPost)?trim($filtroPost['zona']):'';
			$categorias = array_key_exists('categoria', $filtroPost)?trim($filtroPost['categoria']):'';
			$usuarios   = array_key_exists('usuarios', $filtroPost)?trim($filtroPost['usuarios']):'';
			$estaciones = array_key_exists('estacione', $filtroPost)?trim($filtroPost['estacione']):'';
		}else{
			return null;
		}

		return new Filtro($reporte, $estado, $fini, $ffin,$zonas, $categorias, $usuarios, $estaciones, true);

	}
	public function consultar()
	{
		$xls = $pdf = $view = $titles = "";
		$cadena = "";
		$this->filtro = $this->_validateFiltros($this->input->post("filtro"));
		$data         = $this->_Consultar();
		if($data->getResult() == 1){

			$titles = $data->getCabeceras();
			$view = $data->getReporteArray();

			$pdf          =  base64_encode($this->reportePDF($data->getTitleRpt(),$data->getFilterString(),$data->getCabeceras(), $data->getReporteArray()));

	    	$respuesta = array('response' =>$data->getResult(), 'pdf' => $pdf, 'xls'=> $xls, 'view' => $view, 'titles' => $titles, 'titleRpt'=> $data->getTitleRpt(), 'filter_by'=>$data->getFilterString(),'msg' => "");
		}else{//errores
			$respuesta = array('response' => $data->getResult(), 'pdf' => 0, 'xls'=> 0, 'view' => 0, 'titles' => 0, 'msg' => $data->getMensajes());
		}

		echo json_encode($respuesta);

	}
	private function _Consultar()
	{
		$res = null;
		switch ($this->filtro->getReporte()) {
			case '0':
				$res = $this->_getReporteEstados();
				break;
			case '1':
				$res = $this->_getReporteAgrupado();
				break;
			case '2':
				$res = $this->_getReportePorUsuario();
				break;
		}
		return $res;
	}
	private function _getReporteEstados(){
		$resultado = new Result();
		if($this->filtro->validarEstado() &&
		   $this->filtro->validarFechaInicio() &&
		   $this->filtro->validarFechaFin())
		{
			$data = $this->_getTicketData($this->filtro->getFechaInicio(),$this->filtro->getFechaFin(),$this->filtro->getEstado());
			if($data != null){
				$resultado->setTitleRpt("REPORTE POR ESTADOS");
				$resultado->setReporte($data);
				$resultado->convertDataReporteEstados();
				$resultado->setFilterString($this->filtro->fillFilterString());
				$resultado->setResult(1);
			}else{
				$resultado->setMensajes(array("No se encontraron resultados"));
			}
		}
		else{
			$resultado->setMensajes($this->filtro->getMensajes());
		}

		return $resultado;
	}

	private function _getReporteAgrupado(){
		$result = new Result();
		if($this->filtro->validarZona() &&
		   $this->filtro->validarZonaCategoria() &&
		   $this->filtro->validarFechaInicio() &&
		   $this->filtro->validarFechaFin()
		){
			$data = $this->_getTicketData($this->filtro->getFechaInicio(),$this->filtro->getFechaFin(),0, $this->filtro->getZonas(), $this->filtro->getCategorias());

			$zonasFilter      = $this->_getFiltroZonas($this->filtro->getZonas());
			$categoriasFilter = $this->_getFiltroCategorias($this->filtro->getCategorias());

			$this->filtro->addFilterString($zonasFilter);
			$this->filtro->addFilterString($categoriasFilter);

			if($data != null){
				$result->setTitleRpt("REPORTE AGRUPADO POR ZONAS Y CATEGORIAS");
				$result->setReporte($data);
				$result->convertDataReporteEstados();
				$result->setFilterString($this->filtro->fillFilterString());

				$result->setResult(1);
			}else{
				$result->setMensajes(array("No se encontraron resultados"));
			}

		}else{
			$result->setMensajes($this->filtro->getMensajes());
		}
		return $result;
	}
	private function _getReportePorUsuario(){
		$result = new Result();
		if($this->filtro->validarUsuario() &&
		   $this->filtro->validarFechaInicio() &&
		   $this->filtro->validarFechaFin()
		){
			$data = $this->_getTicketData($this->filtro->getFechaInicio(), $this->filtro->getFechaFin(),0,0,0, $this->filtro->getUsuarios());
			$usuariosFilter = $this->_getFiltroUsuarios($this->filtro->getUsuarios());
			$this->filtro->addFilterString($usuariosFilter);

			if($data != null){
				$result->setTitleRpt("REPORTE AGRUPADO POR USUARIOS");
				$result->setReporte($data);
				$result->convertDataReporteEstados();
				$result->setFilterString($this->filtro->fillFilterString());
				$result->setResult(1);
			}else{
				$result->setMensajes(array("No se encontraron resultados"));
			}
		}else{
			$result->setMensajes($this->filtro->getMensajes());
		}
		return $result;
	}
	/* GET ALL TICKET */

	private function _getTicketData($fechaIni,  $fechaFin, $estado = 0, $zona = 0, $categoria = 0, $idUsuario = 0)
	{
		$add = false;
		$res = array();
		$ticketList = $this->tk->getTicketByFilter($fechaIni, $fechaFin, $estado, $zona, $categoria);
		if($ticketList != null){
			foreach ($ticketList as $ticket) {
				$estacionList = $this->tk->getEstacionesTicket($ticket->ID_TICKET);
				if($estacionList != null){
					$atendidoEn = array();
					foreach ($estacionList as $estacion) {
						$estacionDB = $this->estacion->getById($estacion->ID_ESTACION);
						if($idUsuario == 0){
							$bitacoraList = $this->tk->getBitacoraTicketEstacion($ticket->ID_TICKET, $estacion->ID_ESTACION);
						}
						else{
							$bitacoraList = $this->tk->getBitacoraTicketEstacion($ticket->ID_TICKET, $estacion->ID_ESTACION, $idUsuario);
						}

						if($bitacoraList != null){
							$lineaAtencion = $this->_calcularDatos($bitacoraList);
							$lineaAtencion->setEstacionCode($estacionDB->NOMBRE_DISPLAY);
							$add = true;
							array_push($atendidoEn, $lineaAtencion);
						}
					}
				}
				if($add){
					$dto = new TicketDto($ticket->ID_TICKET, $ticket->NUMERO, $ticket->CODIGO, $ticket->FECHA_IMPRESION, $ticket->HORA_IMPRESION);
					$dto->setAtencionList($atendidoEn);
					array_push($res, $dto);
				}
			}
		}
		if(count($res) > 0 )
			return $res;
		else
			return null;
	}
	private function _calcularDatos($bitacoraList)
	{
		$res = new AtencionDto();
		$nroLlamadas         = 0;
		$tiempoEsperaParcial =  0;
		$fechaAtencion       = "";
		$horaAtencion        = "";
		$estado              = EST_SIN_ATENDER;
		$zonaList            = array();
		/* AUX solo para calculos */
		$zonas                  = array();
		$auxStringZonaCategoria = "";
		$tiempoMillis           = 0;
		$auxTpInicio            = 0;
		$auxTpFin               = 0;
		$auxTpPausas            = 0;
		$auxTpPausaIni          = 0;
		$auxTpPausaFin          = 0;
		/* END AUX */
		foreach ($bitacoraList as $linea) {
			$accion       = $linea->ACCION;
			$tiempoMillis = 0;
			$tiempoMillis = stringDateTimeToMillis($linea->FECHA_INICIO_ATENCION, $linea->HORA_INICIO_ATENCION);
			$auxStringZonaCategoria = $linea->ID_ZONA.'-'.$linea->ID_CATEGORIA.'-'.$linea->ID_USUARIO;

			if(!in_array($auxStringZonaCategoria, $zonas))
			{
				array_push($zonas, $auxStringZonaCategoria);
				$zonaDB = $this->zona->getZonaData($linea->ID_ZONA);
				$categoriaDB = $this->categoria->getCategoriaData($linea->ID_CATEGORIA);
				$usuarioDB = $this->usuario->getUsuarioData($linea->ID_USUARIO);

				array_push($zonaList,array('zona' => $zonaDB->NOMBRE,'categoria'=>$categoriaDB->NOMBRE, 'usuario'=> $usuarioDB->usuario, 'idUsuario' => $linea->ID_USUARIO));
			}

			if($accion == EST_LLAMANDO){
				$nroLlamadas = $nroLlamadas + 1;
			}else{
				if($accion == EST_INICIO_ATENCION){
					$auxTpInicio = $tiempoMillis;
					$fechaAtencion = $linea->FECHA_INICIO_ATENCION;
					$horaAtencion = $linea->HORA_INICIO_ATENCION;
					$tiempoEsperaParcial = $tiempoMillis;
				}else if($accion == EST_PAUSADO){
					$auxTpPausaIni = $tiempoMillis;
				}else if($accion == EST_FIN_PAUSA){
					$auxTpPausaFin = $tiempoMillis;
					$auxTpPausas   = $auxTpPausas + ($auxTpPausaFin  - $auxTpPausaIni);
					$auxTpPausaIni = 0;
					$auxTpPausaFin = 0;
				}else if($accion == EST_FINALIZADO){
					$auxTpFin = $tiempoMillis;
				}
			}
		}
		$res->setZonaList($zonaList)
			->setEstadoFinal($accion)
			->setNroLlamadas($nroLlamadas)
			->setTiempoInicio($auxTpInicio)
			->setTiempoFin($auxTpFin)
			->setTiempoPausas($auxTpPausas)
			->setTiempoEspera($tiempoEsperaParcial);

		return $res;
	}
	private function _calcularTiempo($tinicio, $tfin, $tpausas = 0)
	{
		$res = 0;
		$res = ($tfin - $tinicio);
	    if(WITHOUT_PAUSES){
	    	$res = $res - $tpausas ;
	    }
	    return $res;
	}
	private function _getFiltroZonas($idZona)
	{
		$res ="";
		if($idZona != ''){
			if($idZona == 0)
			{
				$res = "ZONA: TODAS | ";
			}else{
				$zonaDB = $this->zona->getZonaData($idZona);
				$res = "ZONA: ".$zonaDB->NOMBRE." | ";
			}
		}
		return $res;
	}
	private function _getFiltroCategorias($idCategoria)
	{
		$res ="";
		if($idCategoria != ''){
			if($idCategoria == 0)
			{
				$res =  "CATEGORIA: TODAS | ";
			}else{
				$categoriaDB = $this->categoria->getCategoriaData($idCategoria);
				$res = "CATEGORIA: ".$categoriaDB->NOMBRE." | ";
			}
		}

		return $res;
	}
	private function _getFiltroUsuarios($idUsuario)
	{
		$res ="";
		if($idUsuario != ''){
			if($idUsuario == 0)
			{
				$res  = "USUARIO: TODOS | ";
			}else{
				$usuarioDB = $this->usuario->getUsuarioData($idUsuario);
				$res = "USUARIO: ".$usuarioDB->usuario." | ";
			}
		}
		return $res;
	}
	/* END ALL TICKET */
	public function reportePDF($title,$filtros, $cabecera, $datosReporte)
    {
    	$pdf = new PDF();
    	$pdf->setStringFilter($filtros);
    	$pdf->setUserName($this->session->userdata('username'));
    	$pdf->setNewTitle($title);
    	$pdf->setLogo(base_url().'public/image/logo.jpg');
		$pdf->AddPage('L');
		$pdf->tablaHorizontal($cabecera, $datosReporte);
		return $pdf->Output('S','archivo.pdf',true);
    }
    function testPDF(){
		$logo = base_url().'public/image/logo.jpg';
    	$pdf = new PDF();
		$pdf->AddPage('L');
		$pdf->setLogo($logo);
		$pdf->setNewTitle("PRUEBA DE DOCUMENTO PDF");
		$ancho1 = 25;
		$ancho2 = 30;
		$ancho3 = 15;
		$ancho4 = 30;
		$ancho5 = 30;
		$ancho6 = 30;
		$cabeceras = array(
			array("value" =>"ZONA","ancho"=>$ancho1),
			array("value" =>"CATEGORIA","ancho"=>$ancho2),
			array("value" =>"NRO.","ancho"=>$ancho3),
			array("value" =>"TICKET","ancho"=>$ancho4),
			array("value" =>"FECHA IMP.","ancho"=>$ancho5),
			array("value" =>"HORA IMP.","ancho"=>$ancho6),
            array("value" =>"T.Atenc.","ancho"=>$ancho6),
            array("value" =>"Nro. Llamadas","ancho"=>$ancho6),
            array("value" =>"Estacion","ancho"=>$ancho6),
            array("value" =>"Operador","ancho"=>$ancho6),
		);
		$data = array();
		for ($i=0; $i < 200; $i++) {
			$aux = array();
			$aux[0] = array("value" => "PRUEBA", "ancho" => $ancho1,"align"=>'L');
			$aux[1] = array("value" => "PRUEBA", "ancho"=> $ancho2,"align"=>'L');
			$aux[2] = array("value" => "PRUEBA", "ancho" => $ancho3,"align"=>'L');
			$aux[3] = array("value" => "PRUEBA", "ancho" => $ancho4,"align"=>'L');
			$aux[4] = array("value" => "PRUEBA", "ancho" => $ancho5,"align"=>'C');
			$aux[5] = array("value" => "PRUEBA", "ancho" => $ancho6,"align"=>'C');
            $aux[6] = array("value" => "PRUEBA", "ancho" => $ancho6,"align"=>'C');
            $aux[7] = array("value" => "PRUEBA", "ancho" => $ancho6,"align"=>'C');
            $aux[8] = array("value" => "PRUEBA", "ancho" => $ancho6,"align"=>'C');
            $aux[9] = array("value" => "PRUEBA", "ancho" => $ancho6,"align"=>'C');
			array_push($data,$aux);
		}

		$pdf->tablaHorizontal($cabeceras, $data);

		$pdf->Output();


    }

}