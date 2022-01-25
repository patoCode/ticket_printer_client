<script src="<?php echo base_url() ?>public/vista/js/jquery/jquery-3.2.1.slim.min.js"></script>
<script src="<?php echo base_url() ?>public/vista/js/bootstrap.min.js"></script>
<script src="<?php echo base_url() ?>public/vista/plugins/datepicker/js/bootstrap-datepicker.min.js"></script>
<script src="<?php echo base_url() ?>public/vista/plugins/datepicker/locales/bootstrap-datepicker.es.min.js"></script>
<script src="<?php echo base_url() ?>public/vista/plugins/select2/js/select2.min.js"></script>
<script src="<?php echo base_url() ?>public/vista/js/serializeJSON.js"></script>
<script src="<?php echo base_url() ?>public/vista/plugins/DataTables/datatables.min.js"></script>
<script src="<?php echo base_url() ?>public/vista/plugins/SweetAlert/sweetalert2.min.js"></script>
<script src="<?php echo base_url() ?>public/vista/plugins/countdown360/jquery.countdown360.js"></script>
<!-- <script src="<?php echo base_url() ?>public/vista/plugins/toast/jquery.toast.min.js"></script> -->
<script type="text/javascript" src="<?php echo base_url() ?>public/vista/plugins/pnotify/src/pnotify.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>public/vista/plugins/pnotify/src/pnotify.nonblock.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>public/vista/plugins/pnotify/src/pnotify.mobile.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>public/vista/plugins/pnotify/src/pnotify.desktop.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>public/vista/plugins/pnotify/src/pnotify.history.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>public/vista/plugins/pnotify/src/pnotify.confirm.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>public/vista/plugins/pnotify/src/pnotify.callbacks.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>public/vista/plugins/pnotify/src/pnotify.reference.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>public/vista/plugins/pnotify/src/pnotify.animate.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>public/vista/plugins/pnotify/src/pnotify.buttons.js"></script>
<script>
	function DesktopNotification(title, text, value){
		var stack_bar_bottom = {"dir1": "up", "dir2": "right", "spacing1": 2, "spacing2": 2};
		var _condition = $('.ui-pnotify-closer, .ui-pnotify-sticker, .ui-pnotify-closer *, .ui-pnotify-sticker *')
		const notice = new PNotify({
			type: "notice",
			title: title,
			text: text,
			hide:false,
			mouse_reset: true,
			stack: stack_bar_bottom,
			desktop: {
				desktop: true,
				fallback:true,
				icon: '<?php echo base_url() ?>public/image/main.png'
			},
		}).get().click(function(e){
			if (_condition.is(e.target)){
	            return;
			}
			var _input = {'id': value}
			var uri    = '<?php echo base_url(); ?>Ticket/update'
			console.log(e,_input)
			ajaxPOST(uri, _input)
				.done(function(data){
					console.log(data)
	        		if(data.response == 0){
	        			desktopNotification = setInterval(getAlertas, 1000)
	        		}
	        	}).fail(function(jqXHR, textStatus){
					console.log("FALLO "+ uri)
				})

		})
	}
	//event: success, error, warning
	function SAMessage(event, message, duration) {
		Swal.fire({
		  position: 'center',
		  icon: event,
		  title: message,
		  showConfirmButton: false,
		  timer: duration != null?duration:2500
		})
	}
	function ajaxPOST(uri, data) {
		var req = $.ajax({
		        url: uri,
		        type:'POST',
		        data: data,
		        dataType:'json'
		    });
		return req;
	}
	// timer function
	var myVar = setInterval(myTimer, 1000);
	function myTimer() {
	    var d = new Date();
	    var t = d.toLocaleTimeString();
	    $("#reloj").html(t);
	}
	// GET LAZY TICKETS
	<?php if($this->session->userdata('notificable')): ?>
		var desktopNotification = setInterval(getAlertas, 1000)
		function getAlertas() {
			PNotify.desktop.permission()
			var uri = "<?php echo base_url(); ?>Ticket/alertList"
			ajaxPOST(uri, null)
				.done(function(data){
		        	if(data.response == 0){
			        	clearInterval(desktopNotification)
			        	$.each(data.data, function(i, value){
							DesktopNotification('TICKET DEMORADO!', value.codigo+'.\nEn la estación: '+value.estacion+' de la zona '+value.zona, value.idTicket)
			        	})
					}
				}).fail(function(jqXHR, textStatus){
					console.log("FALLO "+ uri)
				})

		}
	<?php endif; ?>
</script>
