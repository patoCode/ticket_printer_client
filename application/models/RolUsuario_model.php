<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class RolUsuario_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }
    public function getNotificable($idUsuario)
    {
		$this->db->from('tk_rol_usuario ru');
        $this->db->join('tk_rol r', 'r.ID_ROL = ru.ID_ROL', '');
		$this->db->where('ru.id_usuario', $idUsuario);
        $this->db->where('r.estado', EST_ACTIVO);
        $this->db->where('r.CODE', 'NOTY');
		$query = $this->db->get();
		if($query->num_rows() > 0)
        {
            return $query->result();
        }
        else{
            return null;
        }
    }
}