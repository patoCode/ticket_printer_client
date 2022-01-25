<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Motivo_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }
    public function findByTipo($tipo)
    {
        $this->db->from('tk_motivo');
        $this->db->where('ESTADO', EST_ACTIVO);
        $this->db->where('tipo', $tipo);
        $query = $this->db->get();
        if($query->num_rows() > 0)
            return $query->result();
        else
            return null;

    }
}
