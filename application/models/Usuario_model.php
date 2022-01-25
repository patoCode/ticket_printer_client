<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Usuario_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }
    public function getUsuarioData($idUsuario)
    {
    	$this->db->select('CONCAT(p.nombre, " ", p.apellidos, " (", u.nombre_usuario,")") as usuario');
    	$this->db->from('tk_usuario u');
    	$this->db->join('tk_persona p', 'p.id_persona = u.id_persona', 'right');
        $this->db->where('u.id_usuario', $idUsuario);
        $query = $this->db->get();
        return $query->row();
    }
	public function search($key)
	{
		$parametro = trim($key);
		$this->db->select("u.id_usuario as id, CONCAT(p.NOMBRE,' ',p.APELLIDOS) as persona, u.NOMBRE_USUARIO");
		$this->db->from('tk_persona p');
		$this->db->join('tk_usuario u', 'u.id_persona = p.id_persona', 'left');
		$this->db->like('CONCAT(p.NOMBRE,p.APELLIDOS)', $parametro);
		$this->db->where('estado_reg', ESTREG_ACTIVO);
		$query = $this->db->get();
        if($query->num_rows() > 0)
            return $query->result();
        else
          return null;
	}
}