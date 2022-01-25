<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Ticket_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }
    public function getAll()
    {
        $this->db->from('tk_ticket');
        $query = $this->db->get();
        return $query->result();
    }
    public function checkPendientes($idZona, $fecha, $limit = true)
    {
        $this->db->from('tk_ticket');
        $this->db->where('id_zona', $idZona);
        $this->db->where('estado', TK_EST_1);
        $this->db->where('fecha_impresion', $fecha);
        $this->db->order_by('id_ticket', 'asc');
        $this->db->order_by('prioridad','desc');

        if($limit)
            $this->db->limit(1);

        $query = $this->db->get();
        if($query->num_rows() > 0)
        {
            if($limit)
                return $query->row();
            else
                return $query->result();
        }
        else{
            return null;
        }
    }
    public function getById($idTicket)
    {
        $this->db->from('tk_ticket');
        $this->db->where('id_ticket', $idTicket);
        $query = $this->db->get();
        if($query->num_rows() > 0)
            return $query->row();
        else
            return null;
    }
    public function getTicketsByZona($idZona, $fecha)
    {
        $this->db->from('tk_ticket');
        $this->db->where('id_zona', $idZona);
        $this->db->where('estado', TK_EST_1);
        $this->db->where('fecha_impresion', $fecha);
        $this->db->order_by('id_ticket', 'asc');
        $this->db->order_by('prioridad','desc');
        $this->db->limit(1);
        $query = $this->db->get();
        if($query->num_rows() > 0)
            return $query->row();
        else
            return null;
    }
    public function getTicketsByZonaCategoria($idZona, $idCategoria, $fecha)
    {
        $this->db->from('tk_ticket');
        $this->db->where('id_zona', $idZona);
        $this->db->where('id_categoria', $idCategoria);
        $this->db->where('estado', TK_EST_1);
        $this->db->where('fecha_impresion', $fecha);
        $this->db->order_by('id_ticket', 'asc');
        $this->db->order_by('prioridad','desc');
        $this->db->limit(1);
        $query = $this->db->get();
        if($query->num_rows() > 0)
            return $query->row();
        else
            return null;
    }
    public function getQtyTicketsByZona($idZona, $fecha)
    {
        $this->db->from('tk_ticket');
        $this->db->where('id_zona', $idZona);
        $this->db->where('estado', TK_EST_1);
        $this->db->where('fecha_impresion', $fecha);
        $this->db->order_by('prioridad','desc');
        $query = $this->db->get();
        if($query->num_rows() > 0)
            return $query->num_rows();
        else
            return 0;
    }
    public function getTiempoDeAtencion($id)
    {
        $this->db->from('tk_bitacora_atencion');
        $this->db->where('ID_TICKET', $id);
        $this->db->order_by('ID_TICKET', 'asc');
        $query = $this->db->get();
        if($query->num_rows() > 0)
            return $query->result();
        else
            return 0;
    }
    public function getBitacoraByAction($id, $action)
    {
        $this->db->from('tk_bitacora_atencion');
        $this->db->where('ID_TICKET', $id);
        $this->db->where('ACCION', $action);
        $this->db->order_by('ID_TICKET', 'asc');
        $this->db->limit(1);
        $query = $this->db->get();
        if($query->num_rows() > 0)
            return $query->row();
        else
            return 0;
    }
    public function getAllBitacoraByAction($id, $action = null)
    {
        $this->db->from('tk_bitacora_atencion');
        $this->db->where('ID_TICKET', $id);
        if($action != null)
            $this->db->where('ACCION', $action);
        $this->db->order_by('ID_TICKET', 'asc');

        $query = $this->db->get();
        if($query->num_rows() > 0)
            return $query->result();
        else
            return 0;
    }
    public function getAccionFinal($id, $idUsuario = null)
    {
        $this->db->from('tk_bitacora_atencion');
        $this->db->where('ID_TICKET', $id);
        if($idUsuario != null)
            $this->db->where('ID_USUARIO', $idUsuario);
        $this->db->order_by('ID_TICKET', 'desc');
        $this->db->limit(1);
        $query = $this->db->get();
        if($query->num_rows() > 0)
            return $query->row();
        else
            return 0;
    }
    public function getAlertList()
    {
        $hoy = date("Y-m-d");
        $this->db->select('ID_TICKET,NUMERO, CODIGO, FECHA_IMPRESION, HORA_IMPRESION');
        $this->db->from("tk_ticket t");
        $this->db->where('SHOW_ALERT', 'si');
        $this->db->where('FECHA_IMPRESION', $hoy);
        $query = $this->db->get();
        if($query->num_rows() > 0)
            return $query->result();
        else
            return null;
    }
    public function getAtencionInfo($id)
    {
        $this->db->select('za.NOMBRE as nombreZona, u.NOMBRE_USUARIO as username,  e.NOMBRE_DISPLAY as nombreEstacion');
        $this->db->from('tk_bitacora_atencion ba');
        $this->db->join('tk_zona_atencion za', 'za.ID_ZONA = ba.ID_ZONA', 'left');
        $this->db->join('tk_estacion e', 'e.ID_ESTACION = ba.ID_ESTACION', 'left');
        $this->db->join('tk_usuario u', 'u.ID_USUARIO = ba.ID_USUARIO', 'left');
        $this->db->where('ba.ID_TICKET', $id);
        $this->db->order_by('ID_BITACORA_ATENCION', 'desc');
        $this->db->limit(1);
        $query = $this->db->get();
        if($query->num_rows() > 0)
            return $query->row();
        else
            return null;
    }
    public function getNroLlamadas($id)
    {
        return 2;
    }
    public function getAtendidoEn($id)
    {
        return "cadena";
    }
    public function getUsuariosAtencion($id)
    {
        return "cadena";
    }
    public function countPauses($idTicket)
    {
        $hoy = date('Y-m-d');
        $this->db->select('COUNT(*) as total');
        $this->db->from('tk_bitacora_atencion');
        $this->db->where('cast(fecha_inicio_atencion as date) = ', $hoy);
        $this->db->where('id_ticket', $idTicket);
        $this->db->where('accion', TK_EST_7);
        $query = $this->db->get();
        if($query->num_rows() > 0)
            return $query->row();
        else
            return null;

    }
    /**********************/
    /*** TICKET GEL ALL ***/
    /**********************/

    public function getTicketByFilter($fechaIni, $fechaFin, $estado = 0, $zona = 0, $categoria = 0)
    {
        $this->db->select('ID_TICKET,FECHA_IMPRESION, HORA_IMPRESION, NUMERO, CODIGO');
        $this->db->from('tk_ticket');

        $this->db->where('FECHA_IMPRESION BETWEEN "'. format_date_sql($fechaIni). '" and "'. format_date_sql($fechaFin).'"');

        if($estado!=0 && $estado != "")
            $this->db->where('ESTADO', $estado);
        if($zona!=0 && $zona != "")
            $this->db->where('ID_ZONA', $zona);
        if($categoria!= 0 && $categoria != "")
            $this->db->where('ID_CATEGORIA', $categoria);

        $this->db->order_by('FECHA_IMPRESION, HORA_IMPRESION', 'asc');
        $query = $this->db->get();
        if($query->num_rows() > 0)
            return $query->result();
        else
            return null;
    }
    public function getEstacionesTicket($idTicket)
    {
        $this->db->select('ID_ESTACION');
        $this->db->from('tk_bitacora_atencion');
        $this->db->where('ID_TICKET', $idTicket);
        $this->db->group_by('ID_ESTACION');
        $query = $this->db->get();
        if($query->num_rows() > 0)
            return $query->result();
        else
            return null;
    }
    public function getBitacoraTicketEstacion($idTicket, $idEstacion, $idUsuario = null)
    {
        $this->db->from('tk_bitacora_atencion');
        $this->db->where('ID_TICKET', $idTicket);
        $this->db->where('ID_ESTACION', $idEstacion);
        if($idUsuario != null)
            $this->db->where('ID_USUARIO', $idUsuario);
        $this->db->order_by('ID_BITACORA_ATENCION', 'asc');
        $query = $this->db->get();
        if($query->num_rows() > 0)
            return $query->result();
        else
            return null;
    }

    /**********************/
    /* FIN TICKET GET ALL */
    /**********************/

    public function insert($data)
    {
        return $this->db->insert('tk_ticket', $data);
    }
    public function updateEstado($idTicket, $estado)
    {
        $this->db->set('estado', $estado);
        $this->db->where('id_ticket', $idTicket);
        return $this->db->update('tk_ticket');
    }
    public function updateonDisplay($idTicket, $onDisplay)
    {
        $this->db->set('on_display', $onDisplay);
        $this->db->where('id_ticket', $idTicket);
        return $this->db->update('tk_ticket');
    }
    public function update($data, $id)
    {
        $this->db->where('id_ticket', $id);
        return $this->db->update('tk_ticket', $data);
    }
    public function listarOnDisplay()
    {
        $hoy = date("Y-m-d");
        $this->db->from('tk_ticket');

        $this->db->group_start();
        $this->db->where('on_display', ON_DISPLAY_TRUE);
        $this->db->or_where('on_display', ON_DISPLAY_BLINK);
        $this->db->group_end();

        $this->db->group_start();
        $this->db->where('estado', TK_EST_2);
        $this->db->or_where('estado', TK_EST_3);
        $this->db->group_end();

        $this->db->where('FECHA_IMPRESION', $hoy);
        $this->db->order_by('on_display', 'desc');
        $query = $this->db->get();
        return $query->result();
    }
}
