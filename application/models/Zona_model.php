<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Zona_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }
    public function getZonaData($idZona)
    {
        $this->db->from('tk_zona_atencion');
        $this->db->where('ID_ZONA', $idZona);
        $query = $this->db->get();
        if($query->num_rows() > 0)
            return $query->row();
        else
          return null;
    }
    public function getZona($id)
    {
        $this->db->from('tk_zona_atencion');
        $this->db->where('id_zona', $id);
        $this->db->where('estado', EST_ACTIVO);
        $this->db->where('estado_reg', ESTREG_ACTIVO);
        $query = $this->db->get();
        if($query->num_rows() > 0)
            return $query->row();
        else
          return null;
    }
    public function getActivas()
    {
        $this->db->from('tk_zona_atencion');
        $this->db->where('estado', EST_ACTIVO);
        $this->db->where('estado_reg', ESTREG_ACTIVO);
        $query = $this->db->get();
        return $query->result();
    }
    public function getZonasByUsuario($id)
    {
        $this->db->select('tk_zona_atencion.*');
        $this->db->from('tk_zona_atencion');
        $this->db->join('tk_usuario_zona', 'tk_usuario_zona.id_zona = tk_zona_atencion.id_zona');
        $this->db->where('tk_zona_atencion.estado', EST_ACTIVO);
        $this->db->where('tk_usuario_zona.id_usuario', $id);
        $query = $this->db->get();
        return $query->result();
    }
    public function getTicketsPendientes($idZona)
    {
        $hoy = date("Y-m-d");
        $this->db->select('COUNT(*) as total');
        $this->db->from('tk_ticket t');
        $this->db->join('tk_zona_atencion z', 'z.ID_ZONA = t.ID_ZONA', 'left');
        $this->db->where('t.ID_ZONA', $idZona);
        $this->db->where('t.ESTADO', TK_EST_1);
        $this->db->where('FECHA_IMPRESION', $hoy);
        $query = $this->db->get();
        if($query->num_rows() > 0)
            return $query->row();
        else
          return null;
    }
    public function getTicketsSortByPriority($idZona,$idCategoria)
    {
        $hoy = date("Y-m-d");
        $this->db->from('tk_ticket t');
        $this->db->where('t.ID_ZONA', $idZona);
        $this->db->where('t.ID_CATEGORIA', $idCategoria);
        $this->db->where('t.ESTADO', TK_EST_1);
        $this->db->where('FECHA_IMPRESION', $hoy);
        $this->db->order_by('ID_TICKET', 'asc');
        $this->db->limit(1);
        $query = $this->db->get();
        if($query->num_rows() > 0)
            return $query->row();
        else
          return null;
    }
    public function insert($data)
    {
        return $this->db->insert('tk_ticket', $data);
    }
}