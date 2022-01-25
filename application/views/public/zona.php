<?php $this->load->view('commons/header');	?>
<?php if (ENVIRONMENT=='development'):?>
	<div class="bg-secondary border-0 p-5 text-center">
		<h1 class="display-4 font-weight-bold">ZONAS DE ATENCIÓN</h1>
	</div>
<?php endif; ?>
<div class="container">
      <div class="row align-items-center">
				<?php foreach ($zonas as $zona):?>
					<div class="col-lg-6 col-md-12 mb-2">
						<div class="card border-0">
							<div class="card-body">
								<a href="<?php echo base_url(); ?>zonas/<?php echo $zona->ID_ZONA ?>"
									type="button"
									class="py-5 rounded-0 text-uppercase font-weight-bold btn btn-dark btn-block btn-lg font-large"
									data-id="<?php echo $zona->ID_ZONA ?>">
									<i class="fa fa-print"></i> &nbsp;
									<?php echo $zona->NOMBRE; ?>
								</a>
							</div>
						</div>
					</div>
				<?php endforeach; ?>
      </div>
<?php $this->load->view('commons/footer'); ?>
<?php $this->load->view('commons/modal_ticket'); ?>

</div>
