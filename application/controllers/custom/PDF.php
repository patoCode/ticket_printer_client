<?php
require_once APPPATH.'third_party/fpdf/fpdf.php';
/**
 *
 */
// http://localhost/tomaturn/public/image/LOGO_ENDE_TECNOLOGIAS_FO.png
class PDF extends FPDF
{
    private $stringFilter = "";
    private $username = "";
    private $title = "";
    private $logo = "";
    public function setLogo($logo)
    {
        $this->logo = $logo;
        return $this;
    }
    public function getLogo()
    {
        return $this->logo;
    }
    public function setStringFilter($stringFilter)
    {
        $this->stringFilter .= $stringFilter;
        return $this;
    }
    public function getStringFilter($value='')
    {
        return $this->stringFilter;
    }
    public function getUsername()
    {
        return $this->username;
    }
    public function setUsername($user)
    {
        $this->username = $user;
        return $this;
    }
    public function getNewTitle()
    {
        return $this->title;
    }
    public function setNewTitle($title)
    {
        $this->title = $title;
        return $this;
    }
	function Header()
    {

        $logo = base_url().'public/image/logo.jpg';
        $logoApp = base_url().'public/image/main.png';

        $this->SetFont('Arial','B',15);
        $this->Image($logoApp,12,8,10,0,'');
        $this->Cell(45,10,utf8_decode(NOMBRE_SIS),0,0,'C');
        $this->Cell(187,10,utf8_decode(strtoupper($this->getNewTitle())),0,0,'C');
        $this->Image($logo,253,8,30,0,'');

        //$this->Cell(45,10,utf8_decode(SIGLA_EMP),1,0,'C');
        $this->Ln(12);
        $this->SetFillColor(209,209,209);
        $this->SetFont('Arial','I',8);
        $this->Cell(0,5,utf8_decode("FILTRADO POR: ".$this->getStringFilter()),1,0,'L', true);
        $this->Ln(7);
    }

    function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial','I',7);
        $this->Cell(0,5,utf8_decode('Impreso por: '.strtoupper($this->getUsername()).' - '.date('d/m/Y H:i:s')),0,0,'L');
        $this->Cell(-15,10,utf8_decode('Página ') . $this->PageNo(),0,0,'C');
    }
     function cabeceraHorizontal($cabecera)
    {
        $this->SetXY(10, 28);
        $this->SetFillColor(209,209,209);
        $this->SetFont('Arial','B',7);
        foreach($cabecera as $fila)
        {
            $this->Cell($fila['ancho']!=''?$fila['ancho']:30,7, utf8_decode($fila['value']),1, 0 , 'C', true);
        }
    }

    function datosHorizontal($datos)
    {
        $this->SetXY(10,35);
        $this->SetFont('Arial','',8);
        foreach($datos as $fila)
        {
            for ($i=0; $i < count($fila); $i++) {
                $this->Cell($fila[$i]['ancho']!=''?$fila[$i]['ancho']:35,7, utf8_decode($fila[$i]['value']),1, 0 , $fila[$i]['align']!=''?$fila[$i]['align']:'L' );
            }
            $this->Ln();//Salto de línea para generar otra fila
        }
    }

    //Integrando cabecera y datos en un solo método
    function tablaHorizontal($cabeceraHorizontal, $datosHorizontal)
    {
        $this->cabeceraHorizontal($cabeceraHorizontal);
        $this->datosHorizontal($datosHorizontal);
    }

}