<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class UsuarioBitacora_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }
    public function find($idZona, $idEstacion, $idUsr)
    {
    	$hoy = date("Y-m-d");
    	$this->db->from('tk_usuario_bitacora');
    	$this->db->where('cast(fecha_reg as date) = ', $hoy);
    	$this->db->order_by('id_usuario_bitacora', 'desc');
    	$this->db->limit(1);
		$query = $this->db->get();
        if($query->num_rows() > 0)
            return $query->row();
        else
            return null;

    }
    public function countPauses($idUsr, $idZona, $idEstacion)
    {
    	$hoy = date("Y-m-d");
    	$this->db->select('COUNT(*) as total');
    	$this->db->from('tk_usuario_bitacora');
    	$this->db->where('cast(fecha_reg as date) = ', $hoy);
    	$this->db->where('id_usuario', $idUsr);
    	$this->db->where('id_zona', $idZona);
    	$this->db->where('id_estacion', $idEstacion);
    	$query = $this->db->get();
    	if($query->num_rows() > 0)
            return $query->row();
        else
            return null;
    }
    public function insert($data){
    	return $this->db->insert('tk_usuario_bitacora', $data);
    }
}