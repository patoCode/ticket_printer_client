<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class AtencionCola_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }
    public function addAtenciones($id, $actual)
    {
 		$this->db->set('atenciones', $actual + 1);
        $this->db->where('ID', $id);
        return $this->db->update('tk_atencion_cola');
    }
    public function colaCategoria($idZona, $idCategoria)
    {
        $hoy = date("Y-m-d");
        $this->db->from('tk_atencion_cola');
        $this->db->where('ID_ZONA', $idZona);
        $this->db->where('ID_CATEGORIA', $idCategoria);
        $this->db->where('FECHA', $hoy);
        $this->db->where('ESTADO', ESTREG_ACTIVO);
        $query = $this->db->get();
        if($query->num_rows() > 0)
            return $query->row();
        else
          return null;

    }
  	public function getEstadoCola($idZona)
    {
        $hoy = date("Y-m-d");
        $this->db->from('tk_atencion_cola');
        $this->db->where('ID_ZONA', $idZona);
        $this->db->where('FECHA', $hoy);
        $this->db->where('ESTADO', ESTREG_ACTIVO);
        $this->db->where('DONE < ', MAX_TICKETS_BY_PRIORITY);
        if($query->num_rows() > 0)
            return $query->result();
        else
          return null;
    }
    public function getEstadoByCategoria($idZona, $idCategoria, $fecha)
    {
        $this->db->select('cc.ID as id, cc.ID_CATEGORIA as idCategoria, cc.ID_ZONA as zona, cc.ATENCIONES as atenciones, cc.PRIORIDAD as prioridad, cc.DONE as done');
		$this->db->from('tk_atencion_cola cc');
		$this->db->join('tk_categoria c', 'cc.ID_CATEGORIA = c.ID_CATEGORIA', 'left');
		$this->db->where('cc.ID_ZONA', $idZona);
		$this->db->where('cc.ID_CATEGORIA', $idCategoria);
		$this->db->where('cc.FECHA', $fecha);
		$this->db->where('cc.ESTADO', ESTREG_ACTIVO);
        $this->db->where('cc.DONE', 0);
        $this->db->where('cc.ATENCIONES <', MAX_TICKETS_BY_PRIORITY);
        $this->db->limit(1);
		$query = $this->db->get();
        if($query->num_rows() > 0)
            return $query->row();
        else
          return null;
    }
    public function insert($data)
    {
        $this->db->insert('tk_atencion_cola', $data);
    }
    public function update($id, $data)
    {
        $this->db->where('ID', $id);
        return $this->db->update('tk_atencion_cola', $data);
    }
}