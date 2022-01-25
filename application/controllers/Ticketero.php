<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ticketero extends CI_Controller {

	public function __construct()
    {
		parent::__construct();
		$this->load->model('Categoria_model','categoria');
        $this->load->model('Zona_model','zona');
    }
    public function index()
    {
        $data['zonas'] = $this->zona->getActivas();
    	$this->load->view('public/zona', $data);
    }
    public function categoriasZona($id)
    {
        $data['categorias'] = $this->categoria->getCategoriaByZona($id);
        $this->load->view('public/ticketero', $data);
    }
}