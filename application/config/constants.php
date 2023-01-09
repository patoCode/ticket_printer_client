<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Display Debug backtrace
|--------------------------------------------------------------------------
|
| If set to TRUE, a backtrace will be displayed along with php errors. If
| error_reporting is disabled, the backtrace will not display, regardless
| of this setting
|
*/
defined('SHOW_DEBUG_BACKTRACE') OR define('SHOW_DEBUG_BACKTRACE', TRUE);

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
defined('FILE_READ_MODE')  OR define('FILE_READ_MODE', 0644);
defined('FILE_WRITE_MODE') OR define('FILE_WRITE_MODE', 0666);
defined('DIR_READ_MODE')   OR define('DIR_READ_MODE', 0755);
defined('DIR_WRITE_MODE')  OR define('DIR_WRITE_MODE', 0755);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/
defined('FOPEN_READ')                           OR define('FOPEN_READ', 'rb');
defined('FOPEN_READ_WRITE')                     OR define('FOPEN_READ_WRITE', 'r+b');
defined('FOPEN_WRITE_CREATE_DESTRUCTIVE')       OR define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb'); // truncates existing file data, use with care
defined('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE')  OR define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b'); // truncates existing file data, use with care
defined('FOPEN_WRITE_CREATE')                   OR define('FOPEN_WRITE_CREATE', 'ab');
defined('FOPEN_READ_WRITE_CREATE')              OR define('FOPEN_READ_WRITE_CREATE', 'a+b');
defined('FOPEN_WRITE_CREATE_STRICT')            OR define('FOPEN_WRITE_CREATE_STRICT', 'xb');
defined('FOPEN_READ_WRITE_CREATE_STRICT')       OR define('FOPEN_READ_WRITE_CREATE_STRICT', 'x+b');

/*
|--------------------------------------------------------------------------
| Exit Status Codes
|--------------------------------------------------------------------------
|
| Used to indicate the conditions under which the script is exit()ing.
| While there is no universal standard for error codes, there are some
| broad conventions.  Three such conventions are mentioned below, for
| those who wish to make use of them.  The CodeIgniter defaults were
| chosen for the least overlap with these conventions, while still
| leaving room for others to be defined in future versions and user
| applications.
|
| The three main conventions used for determining exit status codes
| are as follows:
|
|    Standard C/C++ Library (stdlibc):
|       http://www.gnu.org/software/libc/manual/html_node/Exit-Status.html
|       (This link also contains other GNU-specific conventions)
|    BSD sysexits.h:
|       http://www.gsp.com/cgi-bin/man.cgi?section=3&topic=sysexits
|    Bash scripting:
|       http://tldp.org/LDP/abs/html/exitcodes.html
|
*/
defined('EXIT_SUCCESS')        OR define('EXIT_SUCCESS', 0); // no errors
defined('EXIT_ERROR')          OR define('EXIT_ERROR', 1); // generic error
defined('EXIT_CONFIG')         OR define('EXIT_CONFIG', 3); // configuration error
defined('EXIT_UNKNOWN_FILE')   OR define('EXIT_UNKNOWN_FILE', 4); // file not found
defined('EXIT_UNKNOWN_CLASS')  OR define('EXIT_UNKNOWN_CLASS', 5); // unknown class
defined('EXIT_UNKNOWN_METHOD') OR define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
defined('EXIT_USER_INPUT')     OR define('EXIT_USER_INPUT', 7); // invalid user input
defined('EXIT_DATABASE')       OR define('EXIT_DATABASE', 8); // database error
defined('EXIT__AUTO_MIN')      OR define('EXIT__AUTO_MIN', 9); // lowest automatically-assigned error code
defined('EXIT__AUTO_MAX')      OR define('EXIT__AUTO_MAX', 125); // highest automatically-assigned error code

define('NOMBRE_SIS', '**********');
/* CONSTANTES DE EMPRESA*/
define('NOMBRE_EMP','**********');
define('SIGLA_EMP','**********');
define('WEB_EMPRESA','www.**********.bo');
define('ENCABEZADO_TK','BIENVENIDO A ');
define('SUCURSAL_TK','SUCURSAL');
define('SERVER','http://**********.**********.bo/**********/');

define('SHOW_COUNTDOWN', true);
define('COUNTDOWN_TIME', 0.1); //MINUTOS

define('PRINTER_DATA', 'Star BSC10');
define('PRINTER_ONLINE', true);

/* MAXIMO DE LLAMADAS*/
define('MAX_LLAMADAS', 3);

/* FORMATO DE FECHA PARA SQL Y-M-D NO MODIFICAR */
define('FOMAT_DATE_SQL', 'Y-m-d');

/* FORMATO DE FECHA PARA VISTA d/m/Y */
define('FOMAT_DATE_VIEW', 'd/m/Y');

/* TIEMPO DE ESPERA ENTRE LlAMADAS EXPRESADO EN MILISEGUNDOS */
define('TIEMPO_ENTRE_LLAMADA', 3000);

/* TIEMPO DE ATENCION SIN PAUSAS ? */
define('WITHOUT_PAUSES', true);

/* CONTROLAR PRIORIDADES */
define('WITH_PRIORITY', true);
define('MAX_TICKETS_BY_PRIORITY', 2);
define('NORMAL_TICKET', 5);

/* DISPLAY TEXT */
define('BIENVENIDO_DISPLAY', NOMBRE_EMP);

/* CONSTANTES DE SISTEMA */
define('SIST_INC',1);
define('SIST_SEP','-');

/* ESTADOS DE REGISTROS */
define('EST_ACTIVO','activo');
define('EST_INACTIVO','inactivo');
define('EST_LOCK','bloqueado');

/* ESTADOS REGISTROS PARA BORRADO LOGICO */
define('ESTREG_ACTIVO','1');
define('ESTREG_INACTIVO','0');

/* ESTADOS DISPLAY*/
define('ON_DISPLAY_BLINK', 3); // MOSTRAR
define('ON_DISPLAY_FIN', 2); // SE FINALIZO, SE FUE
define('ON_DISPLAY_TRUE', 1); // MOSTRAR
define('ON_DISPLAY_FALSE', 0); // ESPERANDO

/* ESTADOS TICKETS */
define('TK_EST_ALL','0'); // Todos los estados
define('TK_EST_1','1'); //recien imprimio
define('TK_EST_2','2'); // lo estan llamando
define('TK_EST_3','3'); // esta siendo atendido
define('TK_EST_4','4'); // fin atencion
define('TK_EST_5','5'); // derivado
define('TK_EST_6','6'); // SE FUE :(
define('TK_EST_7','7'); // Esta en pausa
define('TK_EST_8','8'); // FIN DE PAUSA: reanudada la atencion

/* ESTADOS DE ATENCION */
define('EST_LIBRE', '0');
define('EST_LLAMANDO','1');
define('EST_INICIO_ATENCION','2');
define('EST_FINALIZADO','3');
define('EST_DERIVADO','4'); //NO HAY
define('EST_SIN_ATENDER', '5');
define('EST_PAUSADO', '6');
define('EST_FIN_PAUSA', '7');

/* ESTADOS DE OPERARIO */
define('EST_OPERARIO_LIBRE', 1);
define('EST_OPERARIO_ATENCION', 2);
define('EST_OPERARIO_PAUSA_INICIO', 3);
define('EST_OPERARIO_PAUSA_FIN', 4);

/*LEYENDA TICKETS*/
define('LEYENDA_TK_1','Observe en la pantalla el numero de ventanilla en la cual sera atendido.');
define('LEYENDA_TK_2','Si su tiempo de espera supera los 30 min. puede registrar su reclamo en el Punto de Reclamo - PR.');
define('COPYRIGHT','Todos los Derechos Reservados &copy; ET, 2020');

/* MENSAJES*/
define('MSG_NO_TICKET','No hay tickets pendientes de atención');
define('MSG_LOCK','Su equipo esta bloqueado');
define('MSG_MAX_LLAMADAS','Este ticket sera cerrado, cumplio el máximo de llamadas');
define('MSG_OK_TICKET','Ticket recuperado');
define('MSG_TK_INICIO_ATENCION', 'Atendiendo el ticket');
define('MSG_TK_PAUSA', 'Atencion pausada');
define('MSG_TK_FIN_PAUSA', 'Atencion reaunudada, pausa finalizada');
define('MSG_TK_FIN_ATENCION', 'Finalizado el ticket');

/* VARIABLES CONTROL DE PAUSAS */
define('ESTATION_NRO_MAX_PAUSES', 3);
define('TICKET_NRO_MAX_PAUSES', 3);

/* VARIABLES PARA TIEMPOS DE LLAMADA */
define('AUTOMATIC_CALL', true);
define('TIME_TO_CALL_TICKET', 20);
define('LOCK_WHEN_MAX_PAUSES', true);
define('ESTATION_PAUSE', true);
define('TICKET_PAUSE', true);

/* ADMIN COMMONS FIELDS */
define('ADM_USUARIO_REG', 'Usr.Reg.');
define('ADM_USUARIO_MOD', 'Usr.Mod.');
define('ADM_FECHA_REG', 'Fec.Reg.');
define('ADM_FECHA_MOD', 'Fec.Mod.');

/* PATH PARA ARCHIVOS */
define('PATH_ICONO_CATEGORIA', 'public/imgs/categoria');
define('PATH_MULTIMEDIA_DISPLAY', 'public/multimedia/');

