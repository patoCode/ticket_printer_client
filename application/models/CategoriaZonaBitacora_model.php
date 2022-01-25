<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class CategoriaZonaBitacora_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }
    public function createAutomatic($data)
    {
        $this->db->insert('tk_categoria_zona_bitacora', $data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }
    public function getByCategoriaZonaToday($id, $hoy)
    {
        $this->db->from('tk_categoria_zona_bitacora');
        $this->db->where('id_categoria_zona', $id);
        $this->db->where('fecha_reg', $hoy);
        $query = $this->db->get();
        if($query->num_rows() > 0)
            return $query->row();
        else
            return "0";
    }
    public function getById($id)
    {
        $this->db->from('tk_categoria_zona_bitacora');
        $this->db->where('id_cat_zona_bitacora', $id);        
        $query = $this->db->get();
        if($query->num_rows() > 0)
            return $query->row();
        else
            return "0";
    }
    public function updateSecuencial($id, $cantidad)
    {
        $this->db->set('secuencial_zona_cat', $cantidad);
        $this->db->where('id_cat_zona_bitacora', $id);
        return $this->db->update('tk_categoria_zona_bitacora');
    }
}
