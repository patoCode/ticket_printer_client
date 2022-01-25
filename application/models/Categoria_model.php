<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Categoria_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }
    public function getCategoriaData($idCategoria)
    {
        $this->db->from('tk_categoria');
        $this->db->where('id_categoria', $idCategoria);
        $query = $this->db->get();
        return $query->row();
    }
    public function getDisponibles()
    {
        $this->db->from('tk_categoria');
        $this->db->where('estado', EST_ACTIVO);
        $this->db->where('estado_reg', ESTREG_ACTIVO);
        $query = $this->db->get();
        return $query->result();
    }
    public function getbyId($id)
    {
        $this->db->from('tk_categoria');
        $this->db->where('id_categoria', $id);
        $this->db->where('estado', EST_ACTIVO);
        $this->db->where('estado_reg', ESTREG_ACTIVO);
        $query = $this->db->get();
        return $query->row();
    }
    public function getCategoriaByZona($id)
    {
        $this->db->from('tk_categoria');
        $this->db->join('tk_categoria_zona', 'tk_categoria.id_categoria = tk_categoria_zona.id_categoria');
        $this->db->where('id_zona', $id);
        $this->db->where('tk_categoria_zona.estado', EST_ACTIVO);
        $query = $this->db->get();
        return $query->result();
    }
    public function findCategoryByZonaByPriority($idZona)
    {
        $this->db->select('c.ID_CATEGORIA, c.NOMBRE,c.CODIGO, c.PRIORIDAD');
        $this->db->from('tk_categoria_zona cz');
        $this->db->join('tk_categoria c', 'c.ID_CATEGORIA = cz.ID_CATEGORIA', 'left');
        $this->db->where('ID_ZONA', $idZona);
        $this->db->where('cz.ESTADO', EST_ACTIVO);
        $this->db->order_by('c.PRIORIDAD', 'desc');
        $query = $this->db->get();
        if($query->num_rows() > 0)
            return $query->result();
        else
            return null;
    }
    public function updateSecuencial($cantidad, $id_categoria)
    {
        $this->db->set('secuencial', $cantidad);
        $this->db->where('id_categoria', $id_categoria);
        return $this->db->update('tk_categoria');
    }


}
