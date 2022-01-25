<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Administrar extends CI_Controller {
	public function __construct()
    {
		parent::__construct();
		$this->load->model('Administrar_model', 'adm');
    }
    public function _visualizar_admin($output = null)
	{
		$this->load->view('admin/base',(array)$output);
	}
	public function administrarMenu()
	{
		try{
			$crud = new grocery_CRUD();
			$crud->set_table('tk_menu');
			$crud->set_subject('Menu/Bloque');

			$crud->columns(
				'MENU',
				'DESCRIPCION',
				'ORDEN',
				'ESTADO',
				'USUARIO_REG','FECHA_REG',
				'USUARIO_MOD','FECHA_MOD');
			$crud->display_as('MENU', 'Menu')
				->display_as('ESTADO', 'Estado')
				->display_as('ORDEN', 'Orden')
				->display_as('USUARIO_REG', ADM_USUARIO_REG)
				->display_as('FECHA_REG', ADM_FECHA_REG)
				->display_as('USUARIO_MOD', ADM_USUARIO_MOD)
				->display_as('FECHA_MOD', ADM_FECHA_MOD);
			$crud->add_fields(
				'MENU','ORDEN',
				'ESTADO',
				'FECHA_REG', 'USUARIO_REG');
			$crud->edit_fields(
				'MENU','ORDEN',
				'ESTADO',
				'FECHA_MOD', 'USUARIO_MOD');
			$this->addFieldsHelper($crud, $this->session->userdata('username'));
			$crud->required_fields(
				'MENU','ORDEN',
				'ESTADO'
			);
			$crud->set_field_upload('ICONO','public/tomaturn/iconos');

			$output = $crud->render();

			$this->_visualizar_admin($output);

		}catch(Exception $e){
			show_error($e->getMessage().' --- '.$e->getTraceAsString());
		}
	}
    public function administrarCategoria()
    {
    	try{
			$crud = new grocery_CRUD();

			$crud->set_table('tk_categoria');
			$crud->set_subject('Categoria(s)');

			$crud->columns(
				'NOMBRE',
				'DESCRIPCION',
				'ESTADO',
				'HORA_INICIO_ATENCION',
				'HORA_CIERRE','CODIGO',
				'SECUENCIAL','PRIORIDAD','ICONO',
				'USUARIO_REG','FECHA_REG',
				'USUARIO_MOD','FECHA_MOD');
			$crud->display_as('NOMBRE', 'Categoría')
				->display_as('DESCRIPCION', 'Descripción')
				->display_as('ESTADO', 'Estado')
				->display_as('HORA_INICIO_ATENCION', 'H.I.ATC.')
				->display_as('HORA_CIERRE', 'H.C.ATC.')
				->display_as('CODIGO', 'Código')
				->display_as('ICONO', 'Icono')
				->display_as('SECUENCIAL', 'Secuencial')
				->display_as('PRIORIDAD', 'Prioridad')
				->display_as('USUARIO_REG', ADM_USUARIO_REG)
				->display_as('FECHA_REG', ADM_FECHA_REG)
				->display_as('USUARIO_MOD', ADM_USUARIO_MOD)
				->display_as('FECHA_MOD', ADM_FECHA_MOD);
			$crud->add_fields(
				'NOMBRE',
				'DESCRIPCION',
				'ESTADO',
				'HORA_INICIO_ATENCION',
				'HORA_CIERRE','CODIGO',
				'SECUENCIAL','PRIORIDAD', 'ICONO','FECHA_REG', 'USUARIO_REG');
			$crud->edit_fields(
				'NOMBRE',
				'DESCRIPCION',
				'ESTADO',
				'HORA_INICIO_ATENCION',
				'HORA_CIERRE','CODIGO',
				'SECUENCIAL','PRIORIDAD', 'ICONO', 'FECHA_MOD', 'USUARIO_MOD');
			$this->addFieldsHelper($crud, $this->session->userdata('username'));
			$crud->required_fields(
				'NOMBRE',
				'DESCRIPCION',
				'ESTADO',
				'HORA_INICIO_ATENCION',
				'HORA_CIERRE','CODIGO',
				'SECUENCIAL','PRIORIDAD', 'ICONO'
			);
			$crud->set_field_upload('ICONO','public/tomaturn/iconos');

			$output = $crud->render();

			$this->_visualizar_admin($output);

		}catch(Exception $e){
			show_error($e->getMessage().' --- '.$e->getTraceAsString());
		}
    }
    public function administrarPersona()
    {
    	try{
			$crud = new grocery_CRUD();
			$crud->set_table('tk_persona');
			$crud->set_subject('Persona');

			$crud->columns('NOMBRE','APELLIDOS','FECHA_NAC', 'ESTADO','USUARIO_REG','FECHA_REG','USUARIO_MOD','FECHA_MOD');
			$crud->display_as('NOMBRE', 'Nombre')
				->display_as('APELLIDOS', 'Apellidos')
				->display_as('FECHA_NAC', 'F.NAC.')
				->display_as('ESTADO', 'Estado')
				->display_as('USUARIO_REG',ADM_USUARIO_REG)
				->display_as('FECHA_REG',ADM_FECHA_REG)
				->display_as('USUARIO_MOD',ADM_USUARIO_MOD)
				->display_as('FECHA_MOD',ADM_FECHA_MOD);


			$crud->add_fields('NOMBRE','APELLIDOS','FECHA_NAC', 'ESTADO', 'USUARIO_REG', 'FECHA_REG');
			$crud->edit_fields('NOMBRE','APELLIDOS','FECHA_NAC', 'ESTADO', 'USUARIO_MOD', 'FECHA_MOD');
			$this->addFieldsHelper($crud, $this->session->userdata('username'));
			$crud->required_fields('NOMBRE','APELLIDOS','FECHA_NAC', 'ESTADO');

			$output = $crud->render();

			$this->_visualizar_admin($output);

		}catch(Exception $e){
			show_error($e->getMessage().' --- '.$e->getTraceAsString());
		}
    }
    public function administrarUsuario()
    {
    	try{
			$crud = new grocery_CRUD();
			$crud->set_table('tk_usuario');
			$crud->set_subject('Usuario');

			$crud->columns('NOMBRE_USUARIO','ROL','ESTADO', 'USUARIO_REG','FECHA_REG','USUARIO_MOD','FECHA_MOD');

			$crud->add_fields('ID_PERSONA','NOMBRE_USUARIO','PASSWORD','ROL','ESTADO', 'USUARIO_REG', 'FECHA_REG');
			$crud->edit_fields('ID_PERSONA','NOMBRE_USUARIO','PASSWORD','ROL','ESTADO', 'USUARIO_MOD', 'FECHA_MOD');

			$crud->display_as('NOMBRE_USUARIO', 'Nombre Usuario')
				 ->display_as('PASSWORD','Contraseña')
				 ->display_as('ESTADO','Estado')
				 ->display_as('USUARIO_REG',ADM_USUARIO_REG)
				 ->display_as('FECHA_REG',ADM_FECHA_REG)
				 ->display_as('USUARIO_MOD',ADM_USUARIO_MOD)
				 ->display_as('FECHA_MOD',ADM_FECHA_MOD)
				 ->display_as('ID_PERSONA','Persona');

			$this->addFieldsHelper($crud, $this->session->userdata('username'));
			$crud->callback_edit_field('PASSWORD',array($this,'set_password_input_to_empty'));
			$crud->callback_add_field('PASSWORD',array($this,'set_password_input_to_empty'));

			$crud->set_relation('ID_PERSONA','tk_persona','{NOMBRE} {APELLIDOS}');
			$crud->set_relation_n_n('ROL', 'tk_rol_usuario', 'tk_rol', 'ID_USUARIO', 'ID_ROL', 'ROL');
			$crud->required_fields('ID_PERSONA','NOMBRE_USUARIO','PASSWORD','FECHA_EXPIRACION','ESTADO');
			$crud->callback_before_insert(array($this,'encrypt_password_callback'));
			$crud->callback_before_update(array($this,'encrypt_password_callback'));
			//dd($_POST);exit;
			$output = $crud->render();


			$this->_visualizar_admin($output);

		}catch(Exception $e){
			show_error($e->getMessage().' --- '.$e->getTraceAsString());
		}
    }
	function encrypt_password_callback($post_array, $primary_key)
	{
	    if(!empty($post_array['PASSWORD']))
	    {
	        $post_array['PASSWORD'] = md5($post_array['PASSWORD']);
	    }
	    else
	    {
	        unset($post_array['PASSWORD']);
	    }

	  return $post_array;
	}
	function set_password_input_to_empty()
	{
	    return "<input type='password' name='PASSWORD' value='' class='form-control col-8'/>";
	}
    public function administrarZonaAtencion()
    {
    	try{
			$crud = new grocery_CRUD();
			$crud->set_table('tk_zona_atencion');
			$crud->set_subject('Zona de Atención');
			$crud->columns('NOMBRE','DESCRIPCION','CODIGO','ESTADO','USUARIO_REG','FECHA_REG','USUARIO_MOD','FECHA_MOD');
			$crud->display_as('NOMBRE', 'Zona')
				 ->display_as('DESCRIPCION','Descripción')
				 ->display_as('CODIGO','Código')
				 ->display_as('ESTADO','Estado')
				 ->display_as('USUARIO_REG',ADM_USUARIO_REG)
				 ->display_as('FECHA_REG',ADM_FECHA_REG)
				 ->display_as('USUARIO_MOD',ADM_USUARIO_MOD)
				 ->display_as('FECHA_MOD',ADM_FECHA_MOD);

			$crud->add_fields('NOMBRE','DESCRIPCION','CODIGO','ESTADO', 'USUARIO_REG', 'FECHA_REG');
			$crud->edit_fields('NOMBRE','DESCRIPCION','CODIGO','ESTADO', 'USUARIO_MOD', 'FECHA_MOD');
			$this->addFieldsHelper($crud, $this->session->userdata('username'));

			$crud->required_fields('NOMBRE','DESCRIPCION','CODIGO','ESTADO');
			$output = $crud->render();

			$this->_visualizar_admin($output);

		}catch(Exception $e){
			show_error($e->getMessage().' --- '.$e->getTraceAsString());
		}
    }
	public function administrarUsuarioZona()
    {
    	try{
			$crud = new grocery_CRUD();
			$crud->set_table('tk_usuario_zona');
			$crud->set_subject('Usuario - Zona');
			$crud->columns('ID_USUARIO','ID_ZONA','ESTADO','USUARIO_REG','FECHA_REG','USUARIO_MOD','FECHA_MOD');
			$crud->display_as('ID_USUARIO', 'Usuario')
				 ->display_as('ID_ZONA','Zona')
				 ->display_as('ESTADO','Estado')
				 ->display_as('USUARIO_REG',ADM_USUARIO_REG)
				 ->display_as('FECHA_REG',ADM_FECHA_REG)
				 ->display_as('USUARIO_MOD',ADM_USUARIO_MOD)
				 ->display_as('FECHA_MOD',ADM_FECHA_MOD)
				 ->display_as('ESTADO_REG','Estado Registro');

			$crud->add_fields('ID_USUARIO','ID_ZONA','ESTADO', 'FECHA_REG', 'USUARIO_REG');
			$crud->edit_fields('ID_USUARIO','ID_ZONA','ESTADO', 'FECHA_MOD', 'USUARIO_MOD');

			$this->addFieldsHelper($crud, $this->session->userdata('username'));

			$crud->set_relation('ID_USUARIO','tk_usuario','{NOMBRE_USUARIO}');
			$crud->set_relation('ID_ZONA','tk_zona_atencion','{NOMBRE}');
			$crud->required_fields('ID_USUARIO','ID_ZONA','ESTADO');

			$output = $crud->render();

			$this->_visualizar_admin($output);

		}catch(Exception $e){
			show_error($e->getMessage().' --- '.$e->getTraceAsString());
		}
    }
    public function administrarCategoriaZona()
    {
    	try{
			$crud = new grocery_CRUD();
			$crud->set_table('tk_categoria_zona');
			$crud->set_subject('Categoria - Zona');

			$crud->columns('ID_ZONA','ID_CATEGORIA','ESTADO','USUARIO_REG','FECHA_REG','USUARIO_MOD','FECHA_MOD');
			$crud->display_as('ID_CATEGORIA', 'Categoria')
				 ->display_as('ID_ZONA','Zona')
				 ->display_as('ESTADO','Estado')
				 ->display_as('USUARIO_REG',ADM_USUARIO_REG)
				 ->display_as('FECHA_REG',ADM_FECHA_REG)
				 ->display_as('USUARIO_MOD',ADM_USUARIO_MOD)
				 ->display_as('FECHA_MOD',ADM_FECHA_MOD);

			$crud->add_fields('ID_ZONA','ID_CATEGORIA','ESTADO', 'FECHA_REG', 'USUARIO_REG');
			$crud->edit_fields('ID_ZONA','ID_CATEGORIA', 'ESTADO', 'USUARIO_MOD', 'FECHA_MOD');

			$this->addFieldsHelper($crud, $this->session->userdata('username'));


			$crud->set_relation('ID_CATEGORIA','tk_categoria','{CODIGO} - {NOMBRE}');
			$crud->set_relation('ID_ZONA','tk_zona_atencion','{NOMBRE}');
			$crud->required_fields('ID_CATEGORIA','ID_ZONA','ESTADO');
			$output = $crud->render();

			$this->_visualizar_admin($output);

		}catch(Exception $e){
			show_error($e->getMessage().' --- '.$e->getTraceAsString());
		}
    }
    public function administrarEstacion()
    {
    	try{
			$crud = new grocery_CRUD();
			$crud->set_table('tk_estacion');
			$crud->set_subject('Estación');
			$crud->columns('ID_ZONA','CODIGO','DESCRIPCION','NOMBRE_DISPLAY','ESTADO','USUARIO_REG','FECHA_REG','USUARIO_MOD','FECHA_MOD');
			$crud->display_as('ID_ZONA', 'Zona')
				 ->display_as('CODIGO','Código')
				 ->display_as('DESCRIPCION','Descripción')
				 ->display_as('NOMBRE_DISPLAY','Pantalla')
				 ->display_as('ESTADO','Estado')
				 ->display_as('USUARIO_REG',ADM_USUARIO_REG)
				 ->display_as('FECHA_REG',ADM_FECHA_REG)
				 ->display_as('USUARIO_MOD',ADM_USUARIO_MOD)
				 ->display_as('FECHA_MOD',ADM_FECHA_MOD);

			$crud->add_fields('ID_ZONA','CODIGO','DESCRIPCION','NOMBRE_DISPLAY','ESTADO', 'FECHA_REG', 'USUARIO_REG');
			$crud->edit_fields('ID_ZONA','CODIGO','DESCRIPCION','NOMBRE_DISPLAY','ESTADO', 'FECHA_MOD', 'USUARIO_MOD');

			$crud->set_relation('ID_ZONA','tk_zona_atencion','{NOMBRE}');
			$this->addFieldsHelper($crud, $this->session->userdata('username'));

			$crud->required_fields('ID_ZONA','CODIGO','DESCRIPCION','NOMBRE_DISPLAY','ESTADO');

			$output = $crud->render();

			$this->_visualizar_admin($output);

		}catch(Exception $e){
			show_error($e->getMessage().' --- '.$e->getTraceAsString());
		}
    }
    public function administrarUsuarioEstacion()
    {
    	try{
			$crud = new grocery_CRUD();
			$crud->set_table('tk_usuario_estacion');
			$crud->set_subject('Usuario - Estación');
			$crud->columns('ID_USUARIO','ID_ZONA','ID_ESTACION','ESTADO','USUARIO_REG','FECHA_REG','USUARIO_MOD','FECHA_MOD');
			$crud->display_as('ID_USUARIO', 'Usuario')
				 ->display_as('ID_ZONA','Zona')
				 ->display_as('ID_ESTACION','Estación')
				 ->display_as('ESTADO','Estado')
				 ->display_as('USUARIO_REG',ADM_USUARIO_REG)
				 ->display_as('FECHA_REG',ADM_FECHA_REG)
				 ->display_as('USUARIO_MOD',ADM_USUARIO_MOD)
				 ->display_as('FECHA_MOD',ADM_FECHA_MOD);

			$crud->add_fields('ID_USUARIO','ID_ZONA','ID_ESTACION','ESTADO', 'FECHA_REG', 'USUARIO_REG');
			$crud->edit_fields('ID_USUARIO','ID_ZONA','ID_ESTACION','ESTADO', 'FECHA_MOD', 'USUARIO_MOD');

			$this->addFieldsHelper($crud, $this->session->userdata('username'));

			$crud->set_relation('ID_USUARIO','tk_usuario','{NOMBRE_USUARIO}');
			$crud->set_relation('ID_ZONA','tk_zona_atencion','{NOMBRE}');
			$crud->set_relation('ID_ESTACION','tk_estacion','{CODIGO}');

			$crud->required_fields('ID_USUARIO','ID_ZONA','ID_ESTACION','ESTADO');

			$output = $crud->render();

			$this->_visualizar_admin($output);

		}catch(Exception $e){
			show_error($e->getMessage().' --- '.$e->getTraceAsString());
		}
    }
    public function administrarMultimedia()
    {
    	try{
			$crud = new grocery_CRUD();
			$crud->set_table('tk_multimedia');
			$crud->set_subject('Multimedia Display');
			$crud->columns(
					'PATH',
					'DESCRIPCION',
					'DURACION',
					'ORDEN',
					'ESTADO',
					'USUARIO_REG',
					'FECHA_REG',
					'USUARIO_MOD',
					'FECHA_MOD');
			$crud->fields(
					'PATH',
					'DESCRIPCION',
					'DURACION',
					'ORDEN',
					'ESTADO');
			$crud->display_as('DESCRIPCION', 'Descripción')
				 ->display_as('PATH','Multimedia')
				 ->display_as('DURACION','Duración')
				 ->display_as('ORDEN','Orden')
				 ->display_as('ESTADO','Estado')
				 ->display_as('USUARIO_REG',ADM_USUARIO_REG)
				 ->display_as('FECHA_REG',ADM_FECHA_REG)
				 ->display_as('USUARIO_MOD',ADM_USUARIO_MOD)
				 ->display_as('FECHA_MOD',ADM_FECHA_MOD);

			$crud->set_field_upload('PATH',PATH_MULTIMEDIA_DISPLAY);

			$output = $crud->render();

			$this->_visualizar_admin($output);

		}catch(Exception $e){
			show_error($e->getMessage().' --- '.$e->getTraceAsString());
		}
    }
	public function administrarMotivo()
    {
    	try{
			$crud = new grocery_CRUD();
			$crud->set_table('tk_motivo');
			$crud->set_subject('Motivos de pausa');
			$crud->columns(
					'tipo',
					'MOTIVO',
					'NRO_PERMITIDO',
					'TIEMPO',
					'ESTADO', 'FECHA_REG', 'USUARIO_REG');
			$crud->fields(
					'tipo',
					'MOTIVO',
					'NRO_PERMITIDO',
					'TIEMPO',
					'ESTADO','USUARIO_REG', 'FECHA_REG');
			$crud->edit_fields('tipo','MOTIVO',
					'NRO_PERMITIDO',
					'TIEMPO',
					'ESTADO','USUARIO_MOD', 'FECHA_MOD');
		 	$this->addFieldsHelper($crud, $this->session->userdata('username'));
			$crud->display_as('tipo','Aplicado a')
			->display_as('MOTIVO', 'Motivo')
				 ->display_as('NRO_PERMITIDO','Repeticiones')
				 ->display_as('TIEMPO','Duración(Seg)')
				 ->display_as('ESTADO','Estado')
				 ->display_as('USUARIO_REG',ADM_USUARIO_REG)
				 ->display_as('FECHA_REG',ADM_FECHA_REG)
				 ->display_as('USUARIO_MOD',ADM_USUARIO_MOD)
				 ->display_as('FECHA_MOD',ADM_FECHA_MOD);

			$output = $crud->render();

			$this->_visualizar_admin($output);

		}catch(Exception $e){
			show_error($e->getMessage().' --- '.$e->getTraceAsString());
		}
    }

	/*
		SEGURIDAD
	*/
	public function administrarRol()
	{
		try{
			$crud = new grocery_CRUD();
			$crud->set_table('tk_rol');
			$crud->set_subject('ROL(es)');

			$crud->set_relation_n_n('ACCESOS', 'tk_privilegio_rol', 'tk_privilegio', 'ID_ROL', 'ID_PRIVILEGIO', 'PRIVILEGIO');


			$crud->columns(
				'ROL',
				'DESCRIPCION',
				'CODE',
				'ACCESOS',
				'ESTADO',
				'USUARIO_REG','FECHA_REG',
				'USUARIO_MOD','FECHA_MOD');

			$crud->display_as('ROL', 'Rol')
				->display_as('DESCRIPCION', 'Descripción')
				->display_as('CODE', 'Código')
				->display_as('ESTADO', 'Estado')
				->display_as('USUARIO_REG', ADM_USUARIO_REG)
				->display_as('FECHA_REG', ADM_FECHA_REG)
				->display_as('USUARIO_MOD', ADM_USUARIO_MOD)
				->display_as('FECHA_MOD', ADM_FECHA_MOD);

			$crud->add_fields(
				'ROL',
				'DESCRIPCION','ACCESOS','CODE',
				'ESTADO','FECHA_REG', 'USUARIO_REG');

			$crud->edit_fields(
				'ROL',
				'DESCRIPCION','ACCESOS','CODE',
				'ESTADO','FECHA_MOD', 'USUARIO_MOD');

			$this->addFieldsHelper($crud, $this->session->userdata('username'));

			$crud->required_fields(
				'ROL',
				'DESCRIPCION',
				'ESTADO','CODE'
			);
			$output = $crud->render();

			$this->_visualizar_admin($output);

		}catch(Exception $e){
			show_error($e->getMessage().' --- '.$e->getTraceAsString());
		}
	}
	public function administrarPrivilegios()
	{
		try{
			$crud = new grocery_CRUD();
			$crud->set_table('tk_privilegio');
			$crud->set_subject('Privilegio');

			$crud->columns(
				'PRIVILEGIO',
				'DESCRIPCION',
				'URI',
				'ID_MENU',
				'ORDEN',
				'ESTADO',
				'USUARIO_REG','FECHA_REG',
				'USUARIO_MOD','FECHA_MOD');

			$crud->display_as('PRIVILEGIO', 'Privilegio')
				->display_as('DESCRIPCION', 'Descripción')
				->display_as('URI', 'Direccion')
				->display_as('ID_MENU', 'Bloque')
				->display_as('ORDEN','Orden')
				->display_as('ESTADO', 'Estado')
				->display_as('USUARIO_REG', ADM_USUARIO_REG)
				->display_as('FECHA_REG', ADM_FECHA_REG)
				->display_as('USUARIO_MOD', ADM_USUARIO_MOD)
				->display_as('FECHA_MOD', ADM_FECHA_MOD);
			$crud->add_fields(
				'PRIVILEGIO',
				'URI',
				'ORDEN',
				'ID_MENU',
				'DESCRIPCION',
				'ESTADO','FECHA_REG', 'USUARIO_REG');

			$crud->edit_fields(
				'PRIVILEGIO','URI',
				'ORDEN',
				'ID_MENU',
				'DESCRIPCION',
				'ESTADO','FECHA_MOD', 'USUARIO_MOD');

			$this->addFieldsHelper($crud, $this->session->userdata('username'));
			$crud->set_relation('ID_MENU','tk_menu','{MENU}');
			$crud->required_fields(
				'PRIVILEGIO','URI',
				'ORDEN',
				'DESCRIPCION',
				'ESTADO'
			);
			$output = $crud->render();

			$this->_visualizar_admin($output);

		}catch(Exception $e){
			show_error($e->getMessage().' --- '.$e->getTraceAsString());
		}
	}
    protected function addFieldsHelper($crud, $username){
    	add_fields_reg($crud, $username);
		add_fields_edit($crud, $username);
    }
}
