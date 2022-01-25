<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Estacion_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }
    public function getById($idEstacion)
    {
		$this->db->from('tk_estacion');
		$this->db->where('id_estacion', $idEstacion);
		$query = $this->db->get();
		return $query->row();
    }
    public function getByIdUsuario($idUsuario)
    {
        $this->db->from('tk_usuario_estacion');
        $this->db->where('id_usuario', $idUsuario);
        $this->db->where('estado', EST_ACTIVO);
        $query = $this->db->get();
        return $query->row();
    }
    public function getByUsuarioZona($getCategoriaZona)
    {
        # code...
    }
}