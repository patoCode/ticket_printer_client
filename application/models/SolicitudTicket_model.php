<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class SolicitudTicket_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }
    public function insert($data)
    {
    	return $this->db->insert('tk_solicitud_ticket', $data);
    }
    public function countNroLlamada($idTicket, $idUsuario, $fecha)
    {	
    	$this->db->from('tk_solicitud_ticket');
    	$this->db->where('id_ticket', $idTicket);
    	$this->db->where('id_usuario', $idUsuario);
    	$this->db->where('fecha_llamada', $fecha);
		$query = $this->db->get();
		return $query->num_rows();		
    }
    public function getSolicitudTicketByIdTicket($idTicket)
    {
        $this->db->from('tk_solicitud_ticket');
        $this->db->where('id_ticket', $idTicket);
        $this->db->order_by('id_solicitud', 'desc');
        $this->db->limit(1);
        $query = $this->db->get();
        return $query->row();
    }
}