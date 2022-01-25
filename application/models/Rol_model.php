<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Rol_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }
    public function getRolByUser($idUsuario)
    {
		$this->db->from('tk_rol_usuario ru');
        $this->db->join('tk_rol r', 'r.ID_ROL = ru.ID_ROL', '');
		$this->db->where('ru.id_usuario', $idUsuario);
        $this->db->where('r.estado', EST_ACTIVO);
		$query = $this->db->get();
		return $query->result();
    }
    public function getPrivilegio($idRol)
    {
        $this->db->select('pr.ID_PRIVILEGIO');
        $this->db->from('tk_privilegio_rol pr');
        $this->db->join('tk_privilegio p', 'p.ID_PRIVILEGIO = pr.ID_PRIVILEGIO', '');
        $this->db->where('ID_ROL', $idRol);
        $this->db->order_by('p.ORDEN', 'asc');
        $query = $this->db->get();
        return $query->result();
    }
}