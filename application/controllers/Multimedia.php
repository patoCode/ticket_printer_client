<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Multimedia extends CI_Controller {
	public function __construct()
    {
		parent::__construct();
		$this->load->model('Multimedia_model','multimedia');
    }
    public function getNextMultimedia()
    {
    	$multimedia = $this->multimedia->getActivo();
    	$data = array('reproducido'=>$multimedia->REPRODUCIDO + 1);
    	$this->multimedia->updateReporudccion($data, $multimedia->ID);
    	return $multimedia;
    }
}