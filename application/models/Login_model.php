<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Login_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}
	public function login_user($usuario,$pass)
	{
		$this->db->where('NOMBRE_USUARIO',$usuario);
		$this->db->where('PASSWORD',md5($pass));
		$query = $this->db->get('tk_usuario');
		if($query->num_rows() == 1)
		{
			return $query->row();
		}
	}
	public function getUserById($id)
	{
		$this->db->where('ID_USUARIO',$id);
		$query = $this->db->get('tk_usuario');
		if($query->num_rows() == 1)
		{
			return $query->row();
		}
	}
}