<?php
class Filtro
{
	private $reporte;
	private $estado;
	private $fechaInicio;
	private $fechaFin;
	private $fechaFinDefault;
	private $formato = 'PDF';
	private $usuarios;
	private $estaciones;
	private $zonas;
    private $categorias;
	private $mensajes;
    private $filterString;

	public function __construct($reporte, $estado, $fechaInicio, $fechaFin, $zonas, $categorias, $usuarios, $estaciones, $fechaFinDefault, $formato = 'PDF'){
		$this->reporte         = $reporte;
		$this->estado          = trim($estado);
		$this->fechaInicio     = trim($fechaInicio);
		$this->fechaFin        = trim($fechaFin);
		$this->fechaFinDefault = $fechaFinDefault;
		$this->formato         = trim($formato);
		$this->usuarios        = $usuarios!=''?trim($usuarios):'';
		$this->estaciones      = $estaciones!=''?trim($estaciones):'';
		$this->zonas           = $zonas!=''?trim($zonas):'';
        $this->categorias      = $categorias!=''?trim($categorias):'';
		$this->mensajes        = array();
        $this->filterString    = "";

	}
	public function getData(){
		echo "REPORTE: ".$this->reporte;
		echo "<br>FECHA INI: ".$this->fechaInicio;
		echo "<br>FECHA FIN: ".$this->fechaFin;
		echo "<br>ESTADO: ".$this->estado;
		echo "<br>FORMATO: ".$this->formato;
		echo "<br>MSG: <pre>";
		print_r($this->getMensajes());

	}
	public function validarFechaInicio()
	{
		$res = false;
		if($this->fechaInicio != ''){
			$this->setFechaInicio(format_date_sql($this->fechaInicio));
			$res = true;
		}else{
			$this->addMessage("La fecha DESDE no esta definida");
		}
		return $res;
	}
	public function validarFechaFin()
	{
		$res = false;
		$hoy = date('d/m/Y');
		if($this->fechaFin != ''){
			$this->setFechaFin(format_date_sql($this->fechaFin));
			$res = true;
		}else{
			if($this->fechaFinDefault)
			{
				$this->setFechaFin(format_date_sql($hoy));
				$res = true;
			}else{
				$this->addMessage("La fecha no esta definida ");
			}
		}
		return $res;
	}
	public function validarEstado()
	{
		$res = false;
		if($this->estado != ''){
			$res = true;
		}else{
			$this->addMessage("Debe seleccionar un estado.");
		}
		return $res;
	}
	public function validarFormato()
	{
		$res = false;
		switch ($this->formato) {
			case 'XLS':
				$res = true;
				break;
			case 'PDF':
				$res = true;
				break;
            case 'VIEW':
                $res = true;
                break;
			default:
				$this->addMessage("el formato solicitado no existe ".$this->formato());
				break;
		}
		return $res;
	}
    public function validarZona()
    {
        $res = false;
        if($this->getZonas()!=''){
            $res = true;
        }else{
            $this->addMessage("Debe seleccionar una Zona");
        }
        return $res;
    }
    public function validarCategoria(){
        $res = false;
        if($this->getCategorias() != ''){
            $res = true;
        }else{
            $this->addMessage("Debe seleccionar una categoria");
        }
        return $res;
    }
    public function validarZonaCategoria(){
        $res = false;
        if($this->getZonas() != 0){
            if($this->validarCategoria()){
                $res = true;
            }
        }else{
            if($this->getZonas() == 0){
                if($this->getCategorias() == ''){
                    $res = true;
                }
            }
        }
        return $res;
    }
    public function validarUsuario()
    {
        $res = false;

        if($this->getUsuarios() != ''){
            $res = true;
        }else{
            $this->addMessage("Debe seleccionar una persona");
        }
        return $res;
    }
    public function validarEstacion()
    {
        $res = false;
        if($this->getEstaciones() != ''){
            $res = true;
        }
        return $res;
    }
    public function fillFilterString()
    {
        $res = $this->getFilterString();
        if($this->estado != ''){
            $res .= " Estado: ".estado_literal($this->getEstado()).' | ';
        }
        if($this->fechaInicio != ''){
            $res .= " Desde: ".format_date_view($this->getFechaInicio()).' | ';
        }
        if($this->fechaFin != ''){
            $res .= " Hasta: ".format_date_view($this->getFechaFin()).' | ';
        }
        $this->setFilterString($res);
        return $res;
    }
    public function addFilterString($cadena)
    {
        $this->setFilterString($this->getFilterString().$cadena);
    }

    public function getFilterString()
    {
        return $this->filterString;
    }
    public function setFilterString($filter)
    {
        $this->filterString = $filter;
    }
	public function addMessage($msg){
		array_push($this->mensajes, $msg);
	}
	public function getMensajes()
	{
		return $this->mensajes;
	}
	public function setMensajes($mensajes = array())
	{
		$this->mensajes = $mensajes;
	}

	public function getEstado()
	{
		return $this->estado;
	}
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

    /**
     * @param mixed $estado
     *
     * @return self
     */
    public function setEstado($estado)
    {
        $this->estado = $estado;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getFechaInicio()
    {
        return $this->fechaInicio;
    }

    /**
     * @param mixed $fechaInicio
     *
     * @return self
     */
    public function setFechaInicio($fechaInicio)
    {
        $this->fechaInicio = $fechaInicio;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getFechaFin()
    {
        return $this->fechaFin;
    }

    /**
     * @param mixed $fechaFin
     *
     * @return self
     */
    public function setFechaFin($fechaFin)
    {
        $this->fechaFin = $fechaFin;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getFormato()
    {
        return $this->formato;
    }

    /**
     * @param mixed $formato
     *
     * @return self
     */
    public function setFormato($formato)
    {
        $this->formato = $formato;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getUsuarios()
    {
        return $this->usuarios;
    }

    /**
     * @param mixed $usuarios
     *
     * @return self
     */
    public function setUsuarios($usuarios)
    {
        $this->usuarios = $usuarios;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getEstaciones()
    {
        return $this->estaciones;
    }

    /**
     * @param mixed $estaciones
     *
     * @return self
     */
    public function setEstaciones($estaciones)
    {
        $this->estaciones = $estaciones;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getZonas()
    {
        return $this->zonas;
    }

    /**
     * @param mixed $zonas
     *
     * @return self
     */
    public function setZonas($zonas)
    {
        $this->zonas = $zonas;

        return $this;
    }
    /**
     * @return mixed
     */
    public function getCategorias()
    {
        return $this->categorias;
    }

    /**
     * @param mixed $zonas
     *
     * @return self
     */
    public function setCategorias($categorias)
    {
        $this->categorias = $categorias;

        return $this;
    }
}