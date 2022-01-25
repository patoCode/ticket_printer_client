<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

use Mike42\Escpos\Printer;
use Mike42\Escpos\EscposImage;
use Mike42\Escpos\ImagickEscposImage;

use Mike42\Escpos\CapabilityProfile;
use Mike42\Escpos\PrintConnectors\NetworkPrintConnector;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\PrintConnectors\FilePrintConnector;

class ReceiptPrint {

  private $CI;
  private $connector;
  private $printer;
  private $printer_width = 4;
  private $margin_left = 4;

  function __construct()
  {
    $this->CI =& get_instance();
  }

  function connect($ip_address, $port)
  {
    $this->connector = new NetworkPrintConnector($ip_address, $port);
    $this->printer = new Printer($this->connector);
  }

  private function check_connection()
  {
    if (!$this->connector OR !$this->printer OR !is_a($this->printer, 'Mike42\Escpos\Printer')) {
      throw new Exception("Tried to create receipt without being connected to a printer.");
    }
  }

  public function close_after_exception()
  {
    if (isset($this->printer) && is_a($this->printer, 'Mike42\Escpos\Printer')) {
      $this->printer->close();
    }
    $this->connector = null;
    $this->printer = null;
    $this->emc_printer = null;
  }
  private function add_line($text = "", $should_wordwrap = true)
  {
    $text = $should_wordwrap ? wordwrap($text, $this->printer_width) : $text;
    $this->printer->text($text."\n");
  }
  public function printTicket($data = "")
  {
    $titulo = ENCABEZADO_TK.NOMBRE_EMP;

    $connector = new WindowsPrintConnector(PRINTER_DATA);
    $this->printer = new Printer($connector);
    $this->printer->initialize();
    $this->printer->selectPrintMode(Printer::MODE_FONT_A);
    $this->printer->setFont(Printer::FONT_B);
    $this->printer->setJustification(1); //centrado
    $this->printer->setTextSize(1,1);
    $this->printer->text($titulo."\n");
    $this->printer->text(WEB_EMPRESA."\n");
    $this->printer->text(SUCURSAL_TK."\n");
    $this->printer->setTextSize(2,2);
    $this->printer->setEmphasis(true);
    $this->printer->text($data['ticket']['codigo']."\n\n");
    $this->printer->setTextSize(1,1);
    $this->printer->setEmphasis(false);
    $this->printer->setJustification(1); // izq
    $this->printer->text($data['ticket']['fecha_impresion_view']." ".$data['ticket']['hora_impresion']."\n");
    $this->printer->setJustification(0); // izq
    $this->printer->text(LEYENDA_TK_1.LEYENDA_TK_2."\n");
    $this->printer->cut(Printer::CUT_PARTIAL);
    $this->printer->close();

  }
  public function print_test_receipt__($data = "")
  {
    /*
      [response] => 1
      [ticket] => Array
          (
              [id_categoria] => 1
              [id_zona] => 2
              [numero] => 125
              [codigo] => SRV-AT-125
              [prioridad] => 1
              [qr] => ...
              [usuario_reg] => localhost
              [fecha_reg] => 2021-08-18
              [estado] => 1
              [fecha_impresion] => 2021-08-18
              [hora_impresion] => 16:35:55
              [fecha_impresion_view] => 18/08/2021
          )
      [categoria] => Persona
      [zona] => Servicios
    */
    $saltos = "\n\n\n";
    $connector = new WindowsPrintConnector(PRINTER_DATA);
    $this->printer = new Printer($connector);

    $this->printer->initialize();

    $this->printer->selectPrintMode(Printer::MODE_FONT_B);
    $this->printer->text($this->_getHeaderTicket());

    $this->printer->text($this->_createSpace(28,3).SUCURSAL_TK.$this->_createSpace(29,3));

    $this->printer->text($this->_createSpace(25,5)."TICKET ".$data['ticket']['codigo'].$this->_createSpace(26,5));

    $this->printer->text($this->_createSpace(25,'.').$data['ticket']['fecha_impresion_view']." ".$data['ticket']['hora_impresion'].$this->_createSpace(24,'.'));

    $this->printer->text(LEYENDA_TK_1.LEYENDA_TK_2."\n");

    $this->printer->text($saltos);
    $this->printer->cut(Printer::CUT_PARTIAL);
    $this->printer->close();
  }
  private function _getHeaderTicket()
  {
    $titulo = ENCABEZADO_TK.NOMBRE_EMP;
    return $this->_createSpace(19).$titulo.$this->_createSpace(19);
  }
  private function _createSpace($count, $char = " ")
  {
    $res = " ";
    for ($i=0; $i < $count; $i++) {
      $res .=" ";
    }
    return $res;
  }
  public function test()
  {
    $saltos = "\n\n\n";
    $connector = new WindowsPrintConnector(PRINTER_DATA);
    $this->printer = new Printer($connector);
    $pdf = base_url()."documento.pdf";

    try {
        $pages = ImagickEscposImage::loadPdf($pdf);
        foreach ($pages as $page) {
            $this->printer->graphics($page);
        }
        $this->printer->cut();
    } catch (Exception $e) {
        echo $e -> getMessage() . "\n";
    } finally {
        $this->printer->close();
    }
  }

}