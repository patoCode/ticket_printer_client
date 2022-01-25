<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Administrar_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }
  	public function updateADM($data,$tabla,$id,$id_pk)
    {
        $this->db->where($id_pk, $id);
        return $this->db->update($tabla,$data);
    }
}