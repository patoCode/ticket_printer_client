<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="">
	<meta name="author" content="ET - ENDE TECNOLOGIAS">
	<title> <?php echo NOMBRE_SIS; ?></title>
	<link rel="icon" type="image/png" href="<?php echo base_url()?>public/image/main.png"/>

	<link href="<?php echo base_url()?>public/vista/css/bootstrap/bootstrap.min.css" rel="stylesheet">
	<!-- <link href="<?php echo base_url()?>public/vista/css/bootstrap/theme/lux_theme.css" rel="stylesheet"> -->
	<link href="<?php echo base_url()?>public/vista/css/fontawesome/css/all.css" rel="stylesheet">
	<link rel="stylesheet" href="<?php echo base_url()?>public/vista/plugins/datepicker/css/bootstrap-datepicker.standalone.css">
	  <link href="<?php echo base_url() ?>public/vista/plugins/select2/css/select2.min.css" rel="stylesheet" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>public/vista/plugins/DataTables/datatables.min.css"/>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>public/vista/plugins/SweetAlert/sweetalert2.min.css"/>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>public/vista/plugins/progress-countdown/circle.css">
	<link href="<?php echo base_url()?>public/vista/plugins/toast/jquery.toast.min.css" rel="stylesheet">
	 <!-- PNotify -->
  <link href="<?php echo base_url() ?>public/vista/plugins/pnotify/src/pnotify.css" rel="stylesheet" type="text/css" />
  <link href="<?php echo base_url() ?>public/vista/plugins/pnotify/src/pnotify.brighttheme.css" rel="stylesheet" type="text/css" />
  <link href="<?php echo base_url() ?>public/vista/plugins/pnotify/src/pnotify.buttons.css" rel="stylesheet" type="text/css" />
  <link href="<?php echo base_url() ?>public/vista/plugins/pnotify/src/pnotify.nonblock.css" rel="stylesheet" type="text/css" />
  <link href="<?php echo base_url() ?>public/vista/plugins/pnotify/src/pnotify.mobile.css" rel="stylesheet" type="text/css" />
  <link href="<?php echo base_url() ?>public/vista/plugins/pnotify/src/pnotify.history.css" rel="stylesheet" type="text/css" />


	<link href="<?php echo base_url()?>public/vista/css/ticket.css" rel="stylesheet">
	<?php if(isset($output)): ?>
	    <?php foreach($css_files as $file): ?>
	        <link type="text/css" rel="stylesheet" href="<?php echo $file; ?>" />
	    <?php endforeach; ?>
	<?php endif; ?>
</head>