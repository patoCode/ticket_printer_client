<?php
if (!function_exists('add_fields_reg')) {
    function add_fields_reg($crud, $username) {
		$crud->field_type('USUARIO_REG', 'hidden', $username);
		$crud->field_type('FECHA_REG', 'hidden', date("Y-m-d H:i:s"));
    }
}
if (!function_exists('add_fields_edit')) {
    function add_fields_edit($crud, $username) {
		$crud->field_type('USUARIO_MOD', 'hidden', $username);
		$crud->field_type('FECHA_MOD', 'hidden', date("Y-m-d H:i:s"));
    }
}
if(!function_exists('format_date_sql')){
	function format_date_sql($data) {
		$data = str_replace('/', '-', $data);
		return date(FOMAT_DATE_SQL, strtotime($data));
    }
}
if(!function_exists('format_date_view')){
	function format_date_view($fecha) {
		$date = new DateTime($fecha);
		return $date->format(FOMAT_DATE_VIEW);
    }
}
if(!function_exists('format_datetime_view')){
	function format_datetime_view($fecha) {
		$date = new DateTime($fecha);
		return $date->format(FOMAT_DATE_VIEW.' H:i:s');
    }
}
if(!function_exists('estado_literal')){
	function estado_literal($data) {
		switch ($data) {
			case '0':
				return 'TODOS';
				break;
			case '1':
				return 'IMPRESO';
				break;
			case '2':
				return 'LLAMANDO';
				break;
			case '3':
				return 'EN-ATENCION';
				break;
			case '4':
				return 'ATENDIDO';
				break;
			case '5':
				return 'DERIVADO';
				break;
			case '6':
				return 'ABANDONADO';
				break;
		}
    }
}
if(!function_exists('accion_literal')){
	function accion_literal($data) {
		switch ($data) {
			case '0':
				return '--';
				break;
			case '1':
				return 'Llamado';
				break;
			case '2':
				return 'EN-ATENCIÓN';
				break;
			case '3':
				return 'FINALIZADO';
				break;
			case '4':
				return 'DERIVADO';
				break;
			case '5':
				return '*ABANDONO*';
				break;
			case '6':
				return 'INICIO-PAUSA';
				break;
			case '6':
				return 'FIN-PAUSA';
				break;
		}
    }
}
if(!function_exists('dd')){
	function dd($data) {
		echo "<pre>";
		print_r($data);
		echo "</pre>";
    }
}
if(!function_exists('stringDateTimeToMillis')){
	function stringDateTimeToMillis($fecha, $hora) {
		$stringDateTime = $fecha.' '.$hora;
		$date = strtotime($stringDateTime);
		return $date;
    }
}