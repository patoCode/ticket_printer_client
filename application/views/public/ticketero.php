<?php $this->load->view('commons/header');	?>
<?php if (ENVIRONMENT=='development'):?>
	<div class="bg-secondary border-0 p-5 text-center">
		<h1 class="display-4 font-weight-bold">CATEGORIAS DE ZONA</h1>
	</div>
<?php endif; ?>
<div class="container">
	<?php if(count($categorias) > 0): ?>
      <div class="row align-items-center">
      	<?php foreach ($categorias as $categoria):?>
        <div class="col-lg-6 col-md-12 mb-2">
        	<div class="card border-0 mb-2 box-shadow">
				<div class="card-body">
					<button type="button"
							class="py-5 rounded-0 text-uppercase btn btn-lg btn-dark btn-block w-100 imprimir"
							data-id="<?php echo $categoria->ID_CATEGORIA_ZONA; ?>"
					>
						<img class="rounded-circle"
							style="width: 75px; height: 75px;"
							 src="<?php echo SERVER.'public/tomaturn/iconos/'.$categoria->ICONO; ?>" alt="<?php echo $categoria->NOMBRE; ?>">
						<h2 class="font-weight-bold "><?php echo $categoria->NOMBRE; ?></h2>
					</button>
				</div>
	        </div>
        </div>
				<?php endforeach; ?>
      </div>
<?php $this->load->view('commons/footer'); ?>
<?php $this->load->view('commons/modal_ticket'); ?>
<script>
	$('.imprimir').click(function(){
		var _self = $(this);
		var id_categoria = _self.attr("data-id");
		$.ajax({
				url: '<?php echo base_url(); ?>Ticket/create/'+id_categoria,
				type:'POST',
				dataType:'json',
				success: function(respuesta) {
					if(respuesta.response === 1){
						console.log("IMPRESO EL TICKET " + respuesta.ticket);
						modalTicketReset();
						modalPreviewTicket(respuesta);
						$('#ticket').modal('show');
						// setInterval(function(){
						// 	window.location.href = "<?php echo base_url().'Ticketero' ?>";
						// }, 5000);
					}else{
						console.log("ERROR " + respuesta);
					}
				},
				error: function(xhr, status) {
			        console.log("No se ha podido obtener la información");
			    }
			});
	});
	function modalTicketReset(){
		$('#ticket').find('#categoriaName').html("");
		$('#ticket').find('#ticketNro').html("");
	}
	function modalPreviewTicket(data){
		$('#ticket').find('#categoriaName').html("Categoria: " + data.categoria);
		$('#ticket').find('#ticketNro').html(" "+ data.ticket.codigo);
		$('#ticket').find('#fechaTK').html("Fecha: "+ data.ticket.fecha_impresion_view);
		$('#ticket').find('#horaTK').html("Hora: "+ data.ticket.hora_impresion);

	}
	function formatFecha(argument) {
		// body...
	}
</script>
<?php else:?>
	<?php echo "SIN CATEGORIAS";?>
<?php endif;?>
</div>
