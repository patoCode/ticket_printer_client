<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Privilegio_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }
    public function getPrivilegioBloque($idPrivilegio)
    {
        $this->db->select('m.menu as MENU, p.uri as URI, p.privilegio as PRIVILEGIO, p.orden ORDEN');
		$this->db->from('tk_privilegio p');
        $this->db->join('tk_menu m', 'm.ID_MENU = p.ID_MENU', '');
		$this->db->where('p.ID_PRIVILEGIO', $idPrivilegio);
        $this->db->where('p.estado', EST_ACTIVO);
        $this->db->where('p.estado_reg', ESTREG_ACTIVO);
        $this->db->order_by('p.orden', 'asc');
		$query = $this->db->get();
		return $query->row();
    }
}