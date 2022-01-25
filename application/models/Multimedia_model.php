<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Multimedia_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }
  	public function getActivo()
    {
        $this->db->from('tk_multimedia');
        $this->db->where('estado', EST_ACTIVO);
        $this->db->order_by('reproducido', 'asc');
        $this->db->limit(1);
		$query = $this->db->get();
        return $query->row();
    }
    public function updateReporudccion($data, $idMultimedia)
    {
    	$this->db->where('id_multimedia', $idMultimedia);
    	$this->db->update('tk_multimedia', $data);
    }
}