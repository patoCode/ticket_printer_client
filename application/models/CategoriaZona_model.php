<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class CategoriaZona_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }
    public function getById($id)
    {
        $this->db->select('tk_categoria_zona.id_categoria_zona,tk_categoria_zona.id_zona, tk_categoria_zona.id_categoria,
            tk_categoria.nombre as nombre_cat, tk_categoria.codigo as codigo_cat, tk_categoria.secuencial as sec_cat, tk_categoria.prioridad,
            tk_zona_atencion.nombre as nombre_zona,
            tk_zona_atencion.codigo as codigo_zona');
        $this->db->from('tk_categoria_zona');
        $this->db->join('tk_categoria', 'tk_categoria.id_categoria = tk_categoria_zona.id_categoria');
        $this->db->join('tk_zona_atencion', 'tk_zona_atencion.id_zona = tk_categoria_zona.id_zona');
        $this->db->where('id_categoria_zona', $id);
        $query = $this->db->get();

        return $query->row();

    }
}
