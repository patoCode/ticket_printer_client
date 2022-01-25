<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class UsuarioEstacion_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }
    public function find($idUsr, $idEstacion, $idZona)
    {
        $this->db->from('tk_usuario_estacion');
        $this->db->where('id_usuario', $idUsr);
        $this->db->where('id_estacion', $idEstacion);
        $this->db->where('id_zona', $idZona);
        $this->db->where('estado', EST_ACTIVO);
        $query = $this->db->get();
        if($query->num_rows() > 0)
            return $query->row();
        else
            return null;

    }
    public function getEstacionByUsuarioZona($idUsuario,$idZona)
    {
    	$this->db->select('tk_estacion.*');
    	$this->db->from('tk_usuario_estacion');
    	$this->db->join('tk_estacion', 'tk_estacion.id_estacion = tk_usuario_estacion.id_estacion');
    	$this->db->where('tk_usuario_estacion.id_zona', $idZona);
    	$this->db->where('tk_usuario_estacion.id_usuario', $idUsuario);
    	$this->db->where('tk_usuario_estacion.estado', EST_ACTIVO);
		$query = $this->db->get();
        return $query->row();
    }
    public function updateEstado($idUsrEstacion, $estado)
    {
        $this->db->set('estado', $estado);
        $this->db->where('id_usuario_estacion', $idUsrEstacion);
        return $this->db->update('tk_usuario_estacion');
    }
}