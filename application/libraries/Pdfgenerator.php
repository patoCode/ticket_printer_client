<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use Dompdf\Dompdf;

class Pdfgenerator {
  public function generate($username, $html, $filename='', $stream=TRUE, $paper = 'A4', $orientation = "portrait")
  {
    $dompdf = new Dompdf();
    $options = $dompdf->getOptions();
    $options->setDefaultFont('Courier');
    $dompdf->setOptions($options);
    $dompdf->loadHtml($html);
    $dompdf->setPaper($paper, $orientation);
    $dompdf->render();
    $this->injectPageCount($dompdf);
    // Parameters
    if($orientation == "portrait"){
        $x          = 530;
        $y          = 760;
    }else{
        $x          = 700;
        $y          = 580;
    }

    $font       = $dompdf->getFontMetrics()->get_font('Fira Code', 'normal');
    $size       = 10;
    $color      = array(0,0,0);
    $word_space = 0.0;
    $char_space = 0.0;
    $angle      = 0.0;

    $canvas = $dompdf->getCanvas();
    $cpdf = $canvas->get_cpdf();

    $firstPageId = $cpdf->getFirstPageId();
    $objects = $cpdf->objects;
    $pages = array_filter($objects, function($v) {
        return $v['t'] == 'page';
    });

    $number = 1;
    $fecha = date(FOMAT_DATE_VIEW.' H:i:s');

    foreach($pages as $pageId => $page) {
            $canvas->reopen_object($pageId + 1);
            $canvas->text(50, $y, "Usuario: $username", $font, 8, array(0,0,0));
            $canvas->text(50, $y+10, $fecha, $font, 8, array(0,0,0));
            $canvas->text($x, $y, "Pagina $number de ".count($pages), $font, 8, array(0,0,0));
            $canvas->close_object();
            $number++;
    }

    // $dompdf->getCanvas()->page_text(
    //   $x, $y, $text, $font, $size, $color, $word_space, $char_space, $angle
    // );

    if ($stream) {
      $dompdf->stream($filename.".pdf", array("Attachment" => false));
    }else{
      return $dompdf->output();
    }
  }
  function injectPageCount(Dompdf $dompdf)
{
    /** @var CPDF $canvas */
    $canvas = $dompdf->getCanvas();
    $pdf = $canvas->get_cpdf();

    foreach ($pdf->objects as &$o) {
        if ($o['t'] === 'contents') {
            $o['c'] = str_replace('_PGC', $canvas->get_page_count(), $o['c']);
        }
    }
}
}