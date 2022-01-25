<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Reporte_model extends CI_Model
{
	public function consultaUno($params)
	{

		if(isset($params['estado']) && $params['estado'] != '' && $params['estado'] > 0)
		{

		}
		if(isset($params['fini']) && $params['fini'] != ''){
			if(isset($params['ffin']) && $params['ffin'] != ''){
				$this->db->where('FECHA_IMPRESION BETWEEN "'. format_date_sql($params['fini']). '" and "'. format_date_sql($params['ffin']).'"');
			}else{
				$hoy = date('Y-m-d');
				$this->db->where('FECHA_IMPRESION BETWEEN "'. format_date_sql($params['fini']). '" and "'.$hoy.'"');
			}
		}
		$query = $this->db->get();
		if($query->num_rows() > 0)
			return $query->result();
		else
			return null;

	}
	public function getData($estado, $fechaIni, $fechaFin)
	{
		$this->db->select('t.*, c.NOMBRE as categoria, z.NOMBRE as zona');
		$this->db->from('tk_ticket t');
		$this->db->join('tk_categoria c', 'c.ID_CATEGORIA = t.ID_CATEGORIA', '');
		$this->db->join('tk_zona_atencion z', 'z.ID_ZONA = t.ID_ZONA', '');
		if($estado != 0)
			$this->db->where('t.estado', $estado);
		$this->db->where('FECHA_IMPRESION BETWEEN "'. format_date_sql($fechaIni). '" and "'. format_date_sql($fechaFin).'"');
		$this->db->order_by('t.NUMERO', 'asc');
		$query = $this->db->get();

		if($query->num_rows() > 0)
			return $query->result();
		else
			return null;


	}
	public function getData2($idZona, $idCategoria, $fechaIni, $fechaFin)
	{

		$this->db->select('t.*, c.NOMBRE as categoria, z.NOMBRE as zona');
		$this->db->from('tk_ticket t');
		$this->db->join('tk_categoria c', 'c.ID_CATEGORIA = t.ID_CATEGORIA', '');
		$this->db->join('tk_zona_atencion z', 'z.ID_ZONA = t.ID_ZONA', '');

		if($idCategoria != '' && $idCategoria > 0)
			$this->db->where('t.ID_CATEGORIA', $idCategoria);
		if($idZona != '' && $idZona > 0)
			$this->db->where('t.ID_ZONA', $idZona);

		$this->db->where('FECHA_IMPRESION BETWEEN "'. format_date_sql($fechaIni). '" and "'. format_date_sql($fechaFin).'"');

		$this->db->order_by('t.NUMERO', 'asc');
		$query = $this->db->get();
		if($query->num_rows() > 0)
			return $query->result();
		else
			return null;
	}
	public function getBitacoraAtencioByUsuario($idPersona, $fechaIni, $fechaFin)
	{
		/* SELECT id_usuario, id_ticket FROM `tk_bitacora_atencion` WHERE ACCION in (2,3) group by id_usuario, id_ticket */
		$this->db->select('id_usuario, id_ticket');
		$this->db->from('tk_bitacora_atencion');
		$this->db->where('ID_USUARIO', $idPersona);
		$this->db->where('FECHA_INICIO_ATENCION BETWEEN "'. format_date_sql($fechaIni). '" and "'. format_date_sql($fechaFin).'"');
		$this->db->group_by('id_usuario, id_ticket');
		$this->db->order_by('id_ticket', 'asc');
		$query = $this->db->get();
		if($query->num_rows() > 0)
			return $query->result();
		else
			return null;
	}
	public function getData3($idPersona, $fechaIni, $fechaFin)
	{

		$this->db->select('t.*, c.NOMBRE as categoria, z.NOMBRE as zona');
		$this->db->from('tk_ticket t');
		$this->db->join('tk_categoria c', 'c.ID_CATEGORIA = t.ID_CATEGORIA', '');
		$this->db->join('tk_zona_atencion z', 'z.ID_ZONA = t.ID_ZONA', '');

		if($idPersona != '' && $idPersona > 0)
			$this->db->where('t.ID_CATEGORIA', $idPersona);

		$this->db->where('FECHA_IMPRESION BETWEEN "'. format_date_sql($fechaIni). '" and "'. format_date_sql($fechaFin).'"');

		$this->db->order_by('t.NUMERO', 'asc');
		$query = $this->db->get();
		echo $this->db->last_query();exit;
		if($query->num_rows() > 0)
			return $query->result();
		else
			return null;
	}
}