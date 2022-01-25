<?php
/**
 *
 */
class Result
{
	private $reporte;
	private $reporteArray;
	private $cabeceras;
	private $mensajes;
	private $result;
    private $pdf;
    private $filterString;
    private $titleRpt;
	function __construct()
	{
        $this->reporte      = null;
        $this->reporteArray = array();
        $this->cabeceras    = array();
        $this->mensajes     = array();
        $this->result       = 0;
        $this->filterString = "";
        $this->titleRpt     = "";
        $this->pdf          = null;
	}

	public function convertDataReporteEstados()
	{
        //$this->setTitleRpt("REPORTE POR ESTADOS");
		$ancho1 = 24;
		$ancho2 = 30;
		$ancho3 = 10;
		$ancho4 = 20;
		$ancho5 = 20;
		$ancho6 = 20;
        $ancho7 = 25;
        $ancho8 = 25;
        $ancho9 = 18;
        $ancho10 = 20;
        $ancho11 = 45;
        $ancho12 = 20;

		$cabeceras = array(
			array("value" =>"ZONA","ancho"=>$ancho1),
			array("value" =>"CATEGORIA","ancho"=>$ancho2),
			array("value" =>"NRO.","ancho"=>$ancho3),
			array("value" =>"TICKET","ancho"=>$ancho4),
			array("value" =>"FECHA IMP.","ancho"=>$ancho5),
			array("value" =>"HORA IMP.","ancho"=>$ancho6),
            array("value" =>"T.ATENC.(SP)(seg)","ancho"=>$ancho7),
            array("value" =>"T.ATENC.(seg)","ancho"=>$ancho8),
            array("value" =>"LLAMADAS","ancho"=>$ancho9),
            array("value" =>"ESTACIÓN","ancho"=>$ancho10),
            array("value" =>"OPERADOR","ancho"=>$ancho11),
            array("value" =>"ESTADO","ancho"=>$ancho12),
		);
		$this->setCabeceras($cabeceras);

		$aux = array();
		if($this->reporte != null){
			foreach ($this->reporte as $ticket) {
                foreach ($ticket->getAtencionList() as $atencion) {
				    $aux[0] = array("value" => $atencion->getZonasLiteral(), "ancho" => $ancho1,"align"=>'L');
				    $aux[1] = array("value" => $atencion->getCategoriaLiteral(), "ancho"=> $ancho2,"align"=>'L');
                    $aux[2] = array("value" => $ticket->getNumero(), "ancho" => $ancho3,"align"=>'L');
    				$aux[3] = array("value" => $ticket->getCodigo(), "ancho" => $ancho4,"align"=>'L');
    				$aux[4] = array("value" => format_date_view($ticket->getFechaImp()), "ancho" => $ancho5,"align"=>'C');
    				$aux[5] = array("value" => $ticket->getHoraImp(), "ancho" => $ancho6,"align"=>'C');

                    $aux[6] = array("value" => $atencion->getAtencionWithOutPauses(), "ancho" => $ancho7,"align"=>'C');
                    $aux[7] = array("value" => $atencion->getAtencionWithPauses(), "ancho" => $ancho8,"align"=>'C');
                    $aux[8] = array("value" => $atencion->getNroLlamadas(), "ancho" => $ancho9,"align"=>'C');
                    $aux[9] = array("value" => $atencion->getEstacionCode(), "ancho" => $ancho10,"align"=>'C');
                    $aux[10] = array("value" => $atencion->getUsuarioLiteral(), "ancho" => $ancho11,"align"=>'C');
                    $aux[11] = array("value" => $atencion->getEstadoFinalLiteral(), "ancho" => $ancho12,"align"=>'C');
				    array_push($this->reporteArray,$aux);
                }

			}
		}
	}

    public function getTitleRpt()
    {
        return $this->titleRpt;
    }
    public function setTitleRpt($title)
    {
        $this->titleRpt = $title;
        return $this;
    }
    public function getMensajes()
    {
        $res = "";
        foreach($this->mensajes as $msg)
            $res .= $msg;
        return $res;
    }
    /* GETTER - SETTERS*/
    public function getFilterString()
    {
        return $this->filterString;
    }
    public function setFilterString($filter)
    {
        $this->filterString = $filter;
        return $this;
    }
	public function getReporteArray()
	{
		return $this->reporteArray;
	}

    /**
     * @return mixed
     */
    public function getReporte()
    {
        return $this->reporte;
    }

    /**
     * @param mixed $reporte
     *
     * @return self
     */
    public function setReporte($reporte)
    {
        $this->reporte = $reporte;

        return $this;
    }
    public function getPdf()
    {
        return $this->pdf;
    }
    public function setPdf($pdf)
    {
        $this->pdf = $pdf;
        return $this;
    }

    /**
     * @return mixed
     */

    /**
     * @param mixed $mensajes
     *
     * @return self
     */
    public function setMensajes($mensajes)
    {
        $this->mensajes = $mensajes;

        return $this;
    }
    /**
     * @return mixed
     */
    public function getResult()
    {
        return $this->result;
    }

    /**
     * @param mixed $mensajes
     *
     * @return self
     */
    public function setResult($result)
    {
        $this->result = $result;

        return $this;
    }
    public function getCabeceras()
    {
        return $this->cabeceras;
    }

    /**
     * @param mixed $mensajes
     *
     * @return self
     */
    public function setCabeceras($cabeceras)
    {
        $this->cabeceras = $cabeceras;
        return $this;
    }

}