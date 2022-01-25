<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Turno extends CI_Controller {

	public function __construct()
    {
		parent::__construct();
        $this->load->model('Categoria_model','categoria');
        $this->load->model('Zona_model','zona');
        $this->load->model('Ticket_model','tk');
        $this->load->model('SolicitudTicket_model','st');
        $this->load->model('BitacoraAtencion_model','ba');
        $this->load->model('UsuarioEstacion_model','eu');
        $this->load->model('Estacion_model','est');
        $this->load->model('Multimedia_model','multimedia');
        $this->load->model('UsuarioBitacora_model','usrbitacora');
        $this->load->model('AtencionCola_model','cola');
    }
    public function index()
    {
        $data['zonas'] = $this->zona->getActivas();
    	$this->load->view('operario/zona', $data);
    }
    public function dashboard($idZona)
    {
        $hoy = date("Y-m-d");
        $data['zona'] = $this->zona->getZona($idZona);
        $data['atendidos'] = $this->ba->getAtendidosByUsuario($this->session->userdata('id_usuario'));
        $data['pendientes'] = $this->tk->checkPendientes($idZona, $hoy, false);
        $this->load->view('operario/dashboard_test', $data);
    }
    public function pendientes($idZona)
    {
        $hoy = date("Y-m-d");
        $list = $this->tk->checkPendientes($idZona, $hoy, false);
        if($list != null){
            $respuesta = array('response' => 0, 'nro' => count($list),'mensaje' => 'Se encontraron '.count($list).' pendientes');
        }
        else{
            $respuesta = array('response' => 1, 'nro' => 0, 'mensaje' =>'Ningun ticket pendiente');
        }
        echo json_encode($respuesta);
    }
    public function solicitarTicket($idZona)
    {
        $id_usuario     = $this->session->userdata('id_usuario');;
        $fecha          = date("Y-m-d");
        $hora           = date("H:i:s");
        $estado_llamada = EST_LLAMANDO;
        $ticket         = $this->getNextTicket($idZona, $fecha);
        $estacion       = $this->eu->getEstacionByUsuarioZona($id_usuario, $idZona);

        if( $ticket != null && $estacion != null)
        {
            $this->tk->updateEstado($ticket->ID_TICKET, TK_EST_2 );
            $this->tk->updateOnDisplay($ticket->ID_TICKET, ON_DISPLAY_BLINK );
            $nro_llamada_actual = $this->countNroLlamada($ticket->ID_TICKET, $id_usuario, $fecha) + 1;
            $data_llamada = array(
                        'id_usuario'     => $id_usuario,
                        'id_ticket'      => $ticket->ID_TICKET,
                        'id_estacion'    => $estacion->ID_ESTACION,
                        'fecha_llamada'  => $fecha,
                        'hora_llamada'   => $hora,
                        'estado_llamada' => TK_EST_2,
                        'nro_llamada'    => $nro_llamada_actual
                        );
            if($this->st->insert($data_llamada))
            {

                 $data_registro = array(
                        'id_usuario'            => $id_usuario,
                        'id_ticket'             => $ticket->ID_TICKET,
                        'id_estacion'           => $estacion->ID_ESTACION,
                        'id_zona'               => $ticket->ID_ZONA,
                        'id_categoria'          => $ticket->ID_CATEGORIA,
                        'fecha_inicio_atencion' => $fecha,
                        'hora_inicio_atencion'  => $hora,
                        'accion'                => $estado_llamada
                );
                $this->ba->insert($data_registro);
                $respuesta = array('response' => 1, 'ticket' => $ticket, 'llamada' =>$nro_llamada_actual);
                $this->session->set_userdata( array('disponibilidad' => EST_OPERARIO_ATENCION) );
            }else{

                $respuesta = array('response' => 0, 'mensaje' => MSG_NO_TICKET);
            }

        }else{
            if($ticket == null){
                $respuesta = array('response' => 0, 'mensaje' => MSG_NO_TICKET);
            }else{
                if($estacion == null){
                    $respuesta = array('response' => 0, 'mensaje' => MSG_LOCK);
                }else{
                    $respuesta = array('response' => 0, 'mensaje' => "Error! intente nuevamente");
                }
            }
        }
        echo json_encode($respuesta);
    }
    public function llamarTicker($idTicket)
    {
        $id_usuario         = $this->session->userdata('id_usuario');
        $ticket             = $this->tk->getById($idTicket);
        $estacion           = $this->eu->getEstacionByUsuarioZona($id_usuario, $ticket->ID_ZONA);
        $fecha              = date("Y-m-d");
        $hora               = date("H:i:s");
        $nro_llamada_actual = $this->countNroLlamada($idTicket, $id_usuario, $fecha) +1;
        $respuesta          = 1;
        $mensaje            = MSG_OK_TICKET;
        $estado_llamada     = EST_LLAMANDO;

        if($nro_llamada_actual <= MAX_LLAMADAS &&
            $ticket->ESTADO == TK_EST_2 &&
            (   $ticket->ESTADO != TK_EST_3 &&
                $ticket->ESTADO != TK_EST_4 &&
                $ticket->ESTADO != TK_EST_6 &&
                $ticket->ESTADO != TK_EST_7))
        {
            $estado_ticket = TK_EST_2;
        }else{
            //EL TICKET SE FUE
            $estado_ticket  = TK_EST_6;
            $respuesta      = 0;
            $mensaje        = MSG_MAX_LLAMADAS;
            $estado_llamada = EST_SIN_ATENDER;
            $this->tk->updateOnDisplay($idTicket, ON_DISPLAY_FIN );
            $this->session->set_userdata( array('disponibilidad' => EST_OPERARIO_LIBRE) );
        }
        $data_registro = array(
                'id_usuario'            => $id_usuario,
                'id_ticket'             => $idTicket,
                'id_estacion'           => $estacion->ID_ESTACION,
                'id_zona'               => $ticket->ID_ZONA,
                'id_categoria'          => $ticket->ID_CATEGORIA,
                'fecha_inicio_atencion' => $fecha,
                'hora_inicio_atencion'  => $hora,
                'accion'                => $estado_llamada
        );
        $this->ba->insert($data_registro);

        $this->tk->updateEstado($idTicket, $estado_ticket);

        $data_llamada = array(
                    'id_usuario' => $id_usuario,
                    'id_ticket' => $idTicket,
                    'id_estacion' => $estacion->ID_ESTACION,
                    'fecha_llamada' => $fecha,
                    'hora_llamada' => $hora,
                    'estado_llamada' => $estado_ticket ,
                    'nro_llamada' => $nro_llamada_actual
                    );
        $this->st->insert($data_llamada);
        $respuesta = array('response' => $respuesta, 'ticket' => $ticket, 'llamada' => $nro_llamada_actual, 'mensaje' => $mensaje);
        echo json_encode($respuesta);
    }
    public function iniciarAtencionTicket($idTicket)
    {
        $ticket     = $this->tk->getById($idTicket);

        $id_usuario = $this->session->userdata('id_usuario');
        $estacion   = $this->eu->getEstacionByUsuarioZona($id_usuario, $ticket->ID_ZONA);
        $fecha      = date("Y-m-d");
        $hora       = date("H:i:s");
        $respuesta  = 1;
        $mensaje    = MSG_OK_TICKET;
        $data_registro = array(
                        'id_usuario'            => $id_usuario,
                        'id_ticket'             => $idTicket,
                        'id_estacion'           => $estacion->ID_ESTACION,
                        'id_zona'               => $ticket->ID_ZONA,
                        'id_categoria'          => $ticket->ID_CATEGORIA,
                        'fecha_inicio_atencion' => $fecha,
                        'hora_inicio_atencion'  => $hora,
                        'accion'                => EST_INICIO_ATENCION
                        );
        if($this->ba->insert($data_registro)){
            $mensaje = MSG_TK_INICIO_ATENCION.' '.$ticket->CODIGO;
            $this->tk->updateEstado($idTicket, TK_EST_3 );
            $this->tk->updateOnDisplay($idTicket, ON_DISPLAY_TRUE );
        }else{
            $respuesta = 0;
        }
        $respuesta = array('response' => $respuesta, 'ticket' => $ticket, 'mensaje' => $mensaje);
        echo json_encode($respuesta);
    }
    public function pausarAtencionTicket($idTicket)
    {
        echo json_encode($this->_pausarAtencionTicketByMotivo($idTicket));
    }
    private function _pausarAtencionTicketByMotivo($idTicket, $idMotivo = 0)
    {
        $respuesta   = 0;
        $ticket     = $this->tk->getById($idTicket);
        if($ticket->ESTADO == TK_EST_3 || $ticket->ESTADO == TK_EST_8){
            $id_usuario = $this->session->userdata('id_usuario');
            $estacion   = $this->eu->getEstacionByUsuarioZona($id_usuario, $ticket->ID_ZONA);
            $fecha       = date("Y-m-d");
            $hora        = date("H:i:s");
            $data_registro = array(
                            'id_usuario'            => $id_usuario,
                            'id_ticket'             => $idTicket,
                            'id_estacion'           => $estacion->ID_ESTACION,
                            'id_zona'               => $ticket->ID_ZONA,
                            'id_categoria'          => $ticket->ID_CATEGORIA,
                            'fecha_inicio_atencion' => $fecha,
                            'hora_inicio_atencion'  => $hora,
                            'accion'                => EST_PAUSADO,
                            'id_motivo_pausa'       => $idMotivo
                            );
            if($this->ba->insert($data_registro)){
                $respuesta   = 1;
                $mensaje = MSG_TK_PAUSA.' '.$ticket->CODIGO;
                $this->tk->updateEstado($idTicket, TK_EST_7 );
                $this->tk->updateOnDisplay($idTicket, ON_DISPLAY_TRUE );
            }
        }else{

            $mensaje ='El Ticket esta en el estado '.$ticket->ESTADO.', verifique el estado actual';
        }
        $respuesta = array('response' => $respuesta, 'ticket' => $ticket, 'mensaje' => $mensaje);
        return $respuesta;
    }
    public function continuarAtencionTicket($idTicket)
    {
        echo json_encode($this->_continuarAtencionTicket($idTicket));
    }
    private function _continuarAtencionTicket($idTicket)
    {
        $respuesta   = 0;
        $mensaje = "";
        $ticket     = $this->tk->getById($idTicket);
        if($ticket->ESTADO ==  TK_EST_7){
            $id_usuario  = $this->session->userdata('id_usuario');
            $estacion   = $this->eu->getEstacionByUsuarioZona($id_usuario, $ticket->ID_ZONA);
            $fecha       = date("Y-m-d");
            $hora        = date("H:i:s");
            $data_registro = array(
                            'id_usuario'            => $id_usuario,
                            'id_ticket'             => $idTicket,
                            'id_estacion'           => $estacion->ID_ESTACION,
                            'id_zona'               => $ticket->ID_ZONA,
                            'id_categoria'          => $ticket->ID_CATEGORIA,
                            'fecha_inicio_atencion' => $fecha,
                            'hora_inicio_atencion'  => $hora,
                            'accion'                => EST_FIN_PAUSA
                            );
            if($this->ba->insert($data_registro)){
                $mensaje = MSG_TK_FIN_PAUSA.' '.$ticket->CODIGO;
                $this->tk->updateEstado($idTicket, TK_EST_8 );
                $this->tk->updateOnDisplay($idTicket, ON_DISPLAY_TRUE );
                $respuesta = 1;
            }else{
                $mensaje = "No es posible el cambio de estado";
            }
        }else{
            $mensaje = "El Ticket ".$ticket->CODIGO." no se encuentra en pausa, no puede continuar.";
        }
        $respuesta = array('response' => $respuesta, 'ticket' => $ticket, 'mensaje' => $mensaje);
        return $respuesta;
    }
    public function finalizarAtencionTicket($idTicket)
    {
        $id_usuario = $this->session->userdata('id_usuario');;
        $ticket     = $this->tk->getById($idTicket);
        $estacion   = $this->eu->getEstacionByUsuarioZona($id_usuario, $ticket->ID_ZONA);
        $fecha      = date("Y-m-d");
        $hora       = date("H:i:s");
        $respuesta  = 1;
        $mensaje    = MSG_OK_TICKET;
        if($ticket->ESTADO == TK_EST_3 || $ticket->ESTADO == TK_EST_8 ){
            $data_registro = array(
                        'id_usuario'            => $id_usuario,
                        'id_ticket'             => $idTicket,
                        'id_estacion'           => $estacion->ID_ESTACION,
                        'id_zona'               => $ticket->ID_ZONA,
                        'id_categoria'          => $ticket->ID_CATEGORIA,
                        'fecha_inicio_atencion' => $fecha,
                        'hora_inicio_atencion'  => $hora,
                        'accion'                => EST_FINALIZADO
                        );
            if($this->ba->insert($data_registro)){
                $this->tk->updateEstado($idTicket, TK_EST_4);
                $this->tk->updateOnDisplay($idTicket, ON_DISPLAY_FIN );
                $mensaje = MSG_TK_FIN_ATENCION.' '.$ticket->CODIGO;
            }else{
                $respuesta = 0;
            }
            $this->session->set_userdata( array('disponibilidad' => EST_OPERARIO_LIBRE) );
        }else{
            $respuesta = 2;
            $mensaje = "No puede finalizar este ticket";

        }
        $respuesta = array('response' => $respuesta, 'ticket' => $ticket, 'mensaje' => $mensaje);
        echo json_encode($respuesta);
    }
    public function derivarTicket($idTicket, $idZona)
    {
        $id_usuario  = $this->session->userdata('id_usuario');;
        $id_estacion = 1;
        $fecha       = date("Y-m-d");
        $hora        = date("H:i:s");
        $ticket      = $this->tk->getById($idTicket);
        $respuesta   = 1;
        $mensaje     = MSG_OK_TICKET;
        $data_registro = array(
                        'id_usuario'            => $id_usuario,
                        'id_ticket'             => $idTicket,
                        'id_estacion'           => $id_estacion,
                        'fecha_inicio_atencion' => $fecha,
                        'hora_inicio_atencion'  => $hora,
                        'accion'                => EST_DERIVADO
                        );
        if($this->ba->insert($data_registro)){
            $mensaje = MSG_TK_INICIO_ATENCION.' '.$ticket->CODIGO;
            $this->session->set_userdata( array('disponibilidad' => EST_OPERARIO_LIBRE) );
        }else{
            $respuesta = 0;
        }
        $respuesta = array('response' => $respuesta, 'ticket' => $ticket, 'mensaje' => $mensaje);
        echo json_encode($respuesta);
    }
    public function pausar()
    {
        // TODO refactor, esto debria estar en la clase filtro o s deberi rea un filtro especail para pausas
        $tipoPausa = trim($this->input->post('tipoPausa'));
        $motivo    = trim($this->input->post('motivo'));
        $respuesta = 0;
        $mensaje   = "";
        $data      = '';
        if($motivo != 0){
            switch ($tipoPausa) {
                case 'atc':
                    $zona = trim($this->input->post('zona'));
                    $conditionalPause = $this->_estacionPosiblePausar($this->session->userdata('id_usuario'), $zona,  $this->session->userdata('estacion'));
                    if($conditionalPause == true){
                        $estadoEstacion = $this->usrbitacora->find($zona, $this->session->userdata('estacion'), $this->session->userdata('id_usuario'));
                        if($estadoEstacion == null || $estadoEstacion->estado == EST_LIBRE){
                            $data = array(
                                "id_usuario"  => $this->session->userdata('id_usuario'),
                                "id_zona"     => $zona,
                                "id_estacion" => $this->session->userdata('estacion'),
                                "estado"      => EST_PAUSADO,
                                "id_motivo"   => $motivo,
                                "fecha_reg"   => date('Y-m-d H:i:s'),
                                "usuario_reg" => $this->session->userdata('username')
                            );
                            if($this->usrbitacora->insert($data)){
                                $respuesta = 1;
                                $mensaje   = "Pausa";
                            }else{
                                $mensaje = "Error en pausa";
                            }
                        }else{
                            $mensaje = "La estación ya se encuentra en estado de Pausa";
                        }
                    }else{
                        $mensaje = "La estación ya generó todas las pausas posibles por hoy ".format_date_view(date("Y-m-d"));
                    }
                break;
                case 'tk':
                    $ticket = trim($this->input->post("ticket"));
                    $conditionalPause = $this->_ticketPosiblePausar($ticket);
                    if($conditionalPause){
                        $pausaTicket = $this->_pausarAtencionTicketByMotivo($ticket, $motivo);
                        if($pausaTicket['response'] == 1 ){
                            $respuesta = $pausaTicket['response'];
                            $data      = $pausaTicket['ticket'];
                        }
                        $mensaje = $pausaTicket['mensaje'];
                    }else{
                        $mensaje = "El ticket no puede tener mas pausas";
                    }
                    break;
            }
        }else{
            $mensaje = "Seleccione un motivo por favor";
        }
        $respuesta = array('response' => $respuesta, 'registro' => $data, 'mensaje' => $mensaje);
        echo json_encode($respuesta);
    }
    public function continuar()
    {
        $tipoPausa = trim($this->input->post('tipoPausa'));
        $respuesta = 0;
        $mensaje   = "";
        $data      = '';
        switch ($tipoPausa) {
            case 'atc':
                $zona = trim($this->input->post('zona'));
                $estadoEstacion = $this->usrbitacora->find($zona, $this->session->userdata('estacion'), $this->session->userdata('id_usuario'));
                if($estadoEstacion != null){
                    $data = array(
                        "id_usuario"  => $this->session->userdata('id_usuario'),
                        "id_zona"     => $zona,
                        "id_estacion" => $this->session->userdata('estacion'),
                        "estado"      => EST_LIBRE,
                        "id_motivo"   => $estadoEstacion->ID_MOTIVO,
                        "fecha_reg"   => date('Y-m-d H:i:s'),
                        "usuario_reg" => $this->session->userdata('username')
                    );
                    if($this->usrbitacora->insert($data)){
                        $respuesta = 1;
                        $mensaje   = "Continuar Atención";
                    }else{
                        $mensaje = "Error, notifique al administrador";
                    }
                }else{
                    $mensaje = "La estación ya se encuentra en estado libre.";
                }
                break;
            case 'tk':
                $ticket = trim($this->input->post("ticket"));
                $continuaTicket = $this->_continuarAtencionTicket($ticket);
                if($continuaTicket['response'] == 1 ){
                    $respuesta = $continuaTicket['response'];
                    $data      = $continuaTicket['ticket'];
                }
                $mensaje = $continuaTicket['mensaje'];
                break;

        }
        $respuesta = array('response' => $respuesta, 'registro' => $data, 'mensaje' => $mensaje);
        echo json_encode($respuesta);
    }
    private function _estacionPosiblePausar($idUsuario, $idZona, $idEstacion)
    {
        $res = $this->usrbitacora->countPauses($idUsuario, $idZona, $idEstacion);
        if((($res->total)/2) < ESTATION_NRO_MAX_PAUSES){
            return true;
        }
        return false;
    }
    private function _ticketPosiblePausar($idTicket)
    {
        $res = $this->tk->countPauses($idTicket);
        if($res->total < TICKET_NRO_MAX_PAUSES ){
            return true;
        }
        return false;
    }
    public function getNextTicket($idZona)//, $fecha)
    {
        $fecha                = date("Y-m-d");
        $bandera              = 0;
        $currentTicket        = null;
        $ticket               = null;
        ##############################################
        $pendientesDeAtencion = $this->tk->checkPendientes($idZona, $fecha);
        if($pendientesDeAtencion != null){
            if(WITH_PRIORITY){
                $categoryList = $this->categoria->findCategoryByZonaByPriority($idZona);
                // verifico que existe la cola
                $this->_verifyCola($idZona, $categoryList);
                while($ticket == null){
                    $ticket = $this->_getTicket($idZona, $categoryList, $fecha);
                }
            }else{
                $ticket = $this->tk->getTicketsByZona($idZona, $fecha);
            }
        }
        return $ticket;
        ##############################################
    }
    private function _getTicket($idZona, $categoryList, $fecha){
        $bandera = 0;
        foreach ($categoryList as $categoria) {
            if($bandera == 0){
                $atencionByCategoria = $this->cola->getEstadoByCategoria($idZona, $categoria->ID_CATEGORIA, $fecha);
                if($atencionByCategoria != null){
                    $atencionActual = $atencionByCategoria->atenciones;
                    $ticket = $this->tk->getTicketsByZonaCategoria($atencionByCategoria->zona, $atencionByCategoria->idCategoria, $fecha);
                    $atencionActual = $atencionActual+1;
                    $updateData = array('atenciones' => $atencionActual);
                    $this->cola->update($atencionByCategoria->id, $updateData);
                    $bandera++;
                }
            }
            // PIDO TICKET Y VERIFICO SI PUEDO DESBLOQUEAR LAS OTRS CAT O NO
        }
        if($bandera > 0){
            return $ticket;
        }else{
            $this->_updateAtencionCola($idZona, $categoryList);
            return null;
        }
    }
    private function _verifyCola($idZona, $categoryList)
    {
        foreach ($categoryList as $elemento) {
            $colaCategoria = $this->cola->colaCategoria($idZona, $elemento->ID_CATEGORIA);
            if($colaCategoria == null){
                $data = array(
                    "ID_CATEGORIA" => $elemento->ID_CATEGORIA,
                    "ID_ZONA"      => $idZona,
                    "ATENCIONES"   => 0,
                    "PRIORIDAD"    => $elemento->PRIORIDAD,
                    "ESTADO"       => ESTREG_ACTIVO,
                    "FECHA"        => date("Y-m-d"),
                    "DONE"         => 0,
                    "ID_ANTERIOR"  => 0
                );
                $this->cola->insert($data);
            }
        }
    }
    private function _updateAtencionCola($idZona, $categoryList)
    {
        $data = array("atenciones" => 0);
        foreach ($categoryList as $elemento) {
            $_this = $this->cola->colaCategoria($idZona, $elemento->ID_CATEGORIA);
            $this->cola->update($_this->ID, $data);
        }
    }
    public function countNroLlamada($idTicket, $idUsuario, $fecha)
    {
        $numero = $this->st->countNroLlamada($idTicket, $idUsuario, $fecha);
        return $numero;
    }
    // DISPLAY
    public function display()
    {
        $ticket_list         = $this->tk->listarOnDisplay();
        $array_tickets_vista = array();
        foreach ($ticket_list as $ticket)
        {
            $solicitudTicket         = $this->st->getSolicitudTicketByIdTicket($ticket->ID_TICKET);
            $estacion                = $this->est->getById($solicitudTicket->ID_ESTACION);
            $elemento                = new stdClass();
            $elemento->estacion      = $estacion->NOMBRE_DISPLAY;
            $elemento->ticket_codigo = $ticket->CODIGO;
            $elemento->blink         = $ticket->ON_DISPLAY;
            $elemento->on_display    = $ticket->ON_DISPLAY;
            array_push($array_tickets_vista, $elemento);
        }
        $multimedia = $this->multimedia->getActivo();
        $data['multimedia'] = $multimedia;
        $data['tickets'] = $array_tickets_vista;
        $this->load->view('public/display', $data);
    }
}
