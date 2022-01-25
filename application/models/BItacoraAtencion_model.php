<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class BitacoraAtencion_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }
  	public function insert($data)
    {
        return $this->db->insert('tk_bitacora_atencion', $data);
    }
    public function getAtendidosByUsuario($id_usuario)
    {
    	//SELECT tk.* FROM `tk_bitacora_atencion`tba JOIN tk_ticket tk on tk.ID_TICKET = tba.id_ticket WHERE tba.id_usuario = 1 and tk.ID_ZONA = 1 and tk.ESTADO = 4 group by tk.id_ticket
    	$this->db->select('tk.*');
    	$this->db->from('tk_bitacora_atencion as tba');
    	$this->db->join('tk_ticket tk ', 'tk.ID_TICKET = tba.ID_TICKET');
    	$this->db->where('tba.id_usuario', $id_usuario);
    	$this->db->group_by('tk.id_ticket');
    	$query = $this->db->get();
    	return $query->result();
    }
    public function getUltimoLlamado($idZona, $idEstacion)
    {
        $hoy = date('Y-m-d');
        $this->db->from('tk_bitacora_atencion ba');
        $this->db->where('ID_ZONA', $idZona);
        $this->db->where('ID_ESTACION', $idEstacion);
        $this->db->where('FECHA_INICIO_ATENCION', $hoy);
        $this->db->where('ACCION', EST_LLAMANDO);
        $this->db->limit(1);
        $query = $this->db->get();
        if($query->num_rows() > 0)
            return $query->row();
        else
          return null;
    }
}