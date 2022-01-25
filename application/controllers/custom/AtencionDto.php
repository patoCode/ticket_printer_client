<?php

class AtencionDto
{
	private $zonaList; // array
    private $estacionCode;
	private $idUsuario;
	private $username;
	private $estadoFinal;
	private $nroLlamadas;
    private $tiempoInicio;
    private $tiempoFin;
    private $tiempoPausas;
	private $tiempoEspera;
	private $fechaAtencion;
	private $horaAtencion;

	function __construct()
	{
        $this->zonaList      = array();
        $this->estacionCode  = "";
        $this->idUsuario     = 0;
        $this->username      = "";
        $this->estadoFinal   = "";
        $this->nroLlamadas   = 0;
        $this->tiempoInicio  = 0;
        $this->tiempoFin     = 0;
        $this->tiempoPausas  = 0;

        $this->tiempoEspera  = 0;
        $this->fechaAtencion = "";
        $this->horaAtencion  = "";
	}
    public function getZonasLiteral()
    {
        $res = "";
        foreach ($this->getZonaList() as $zona) {
            if($res != '')
                $res .=' ,';
                $res = $zona['zona'];
        }
        return $res;
    }
    public function getCategoriaLiteral()
    {
        $res = "";
        foreach ($this->getZonaList() as $zona) {
            if($res != '')
                $res .=' ,';
            $res = $zona['categoria'];
        }
        return $res;
    }
    public function getUsuarioLiteral()
    {
        $res = "";
        foreach ($this->getZonaList() as $zona) {
            if($res != '')
                $res .=' ,';
            $res = $zona['usuario'];
        }
        return $res;
    }
    public function getEstadoFinalLiteral()
    {
        return accion_literal($this->getEstadoFinal());
    }
    public function getAtencionWithPauses()
    {
        return ($this->getTiempoFin() - $this->getTiempoInicio());
    }
    public function getAtencionWithOutPauses()
    {
        return $this->getAtencionWithPauses() - $this->getTiempoPausas();
    }

    /**
     * @return mixed
     */
    public function getZonaList()
    {
        return $this->zonaList;
    }

    /**
     * @param mixed $zonaList
     *
     * @return self
     */
    public function setZonaList($zonaList)
    {
        $this->zonaList = $zonaList;

        return $this;
    }
    /**
     * @return mixed
     */
    public function getEstacionCode()
    {
        return $this->estacionCode;
    }

    /**
     * @param mixed $zonaList
     *
     * @return self
     */
    public function setEstacionCode($code)
    {
        $this->estacionCode = $code;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getIdUsuario()
    {
        return $this->idUsuario;
    }

    /**
     * @param mixed $idUsuario
     *
     * @return self
     */
    public function setIdUsuario($idUsuario)
    {
        $this->idUsuario = $idUsuario;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param mixed $username
     *
     * @return self
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getEstadoFinal()
    {
        return $this->estadoFinal;
    }

    /**
     * @param mixed $estadoFinal
     *
     * @return self
     */
    public function setEstadoFinal($estadoFinal)
    {
        $this->estadoFinal = $estadoFinal;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getNroLlamadas()
    {
        return $this->nroLlamadas;
    }

    /**
     * @param mixed $nroLlamadas
     *
     * @return self
     */
    public function setNroLlamadas($nroLlamadas)
    {
        $this->nroLlamadas = $nroLlamadas;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getTiempoInicio()
    {
        return $this->tiempoInicio;
    }

    /**
     * @param mixed $tiempoInicio
     *
     * @return self
     */
    public function setTiempoInicio($tiempoInicio)
    {
        $this->tiempoInicio = $tiempoInicio;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getTiempoFin()
    {
        return $this->tiempoFin;
    }

    /**
     * @param mixed $tiempoFin
     *
     * @return self
     */
    public function setTiempoFin($tiempoFin)
    {
        $this->tiempoFin = $tiempoFin;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getTiempoPausas()
    {
        return $this->tiempoPausas;
    }

    /**
     * @param mixed $tiempoPausas
     *
     * @return self
     */
    public function setTiempoPausas($tiempoPausas)
    {
        $this->tiempoPausas = $tiempoPausas;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getTiempoEspera()
    {
        return $this->tiempoEspera;
    }

    /**
     * @param mixed $tiempoEspera
     *
     * @return self
     */
    public function setTiempoEspera($tiempoEspera)
    {
        $this->tiempoEspera = $tiempoEspera;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getFechaAtencion()
    {
        return $this->fechaAtencion;
    }

    /**
     * @param mixed $fechaAtencion
     *
     * @return self
     */
    public function setFechaAtencion($fechaAtencion)
    {
        $this->fechaAtencion = $fechaAtencion;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getHoraAtencion()
    {
        return $this->horaAtencion;
    }

    /**
     * @param mixed $horaAtencion
     *
     * @return self
     */
    public function setHoraAtencion($horaAtencion)
    {
        $this->horaAtencion = $horaAtencion;

        return $this;
    }
}