<?php
class TicketDto
{
	private $idTicket;
	private $fechaImp;
	private $horaImp;
    private $numero;
    private $codigo;
	private $atencionList; //array de EstacionAtencionDto;

	function __construct($idTicket, $numero, $codigo, $fechaImp, $horaImp)
	{
        $this->idTicket     = $idTicket;
        $this->numero       = $numero;
        $this->codigo       = $codigo;
        $this->fechaImp     = $fechaImp;
        $this->horaImp      = $horaImp;
        $this->atencionList = array();
	}



    /**
     * @return mixed
     */
    public function getIdTicket()
    {
        return $this->idTicket;
    }

    /**
     * @param mixed $idTicket
     *
     * @return self
     */
    public function setIdTicket($idTicket)
    {
        $this->idTicket = $idTicket;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getFechaImp()
    {
        return $this->fechaImp;
    }

    /**
     * @param mixed $fechaImp
     *
     * @return self
     */
    public function setFechaImp($fechaImp)
    {
        $this->fechaImp = $fechaImp;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getHoraImp()
    {
        return $this->horaImp;
    }

    /**
     * @param mixed $horaImp
     *
     * @return self
     */
    public function setHoraImp($horaImp)
    {
        $this->horaImp = $horaImp;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getNumero()
    {
        return $this->numero;
    }

    /**
     * @param mixed $numero
     *
     * @return self
     */
    public function setNumero($numero)
    {
        $this->numero = $numero;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getCodigo()
    {
        return $this->codigo;
    }

    /**
     * @param mixed $codigo
     *
     * @return self
     */
    public function setCodigo($codigo)
    {
        $this->codigo = $codigo;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getAtencionList()
    {
        return $this->atencionList;
    }

    /**
     * @param mixed $atencionList
     *
     * @return self
     */
    public function setAtencionList($atencionList)
    {
        $this->atencionList = $atencionList;

        return $this;
    }
}