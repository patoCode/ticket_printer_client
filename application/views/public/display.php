<?php $this->load->view('commons/header');	?>
<body>
<div class="container" id="titulo">
    <div class="row">
        <div class="col-md-12 fixed-top bg-ticket-transparent text-center">
        	<h1 class="display-4 font-weight-bold"><?php echo BIENVENIDO_DISPLAY; ?></h1>
          	<h3 class="display-6">
          		ZONA DE ESPERA
        	</h3>
        </div>
    </div>
<?php if($multimedia != null): ?>
<div class="row" id="video">
    <video muted autoplay='autoplay' loop='loop' id="myVideo">
        <source src="<?php echo base_url().PATH_MULTIMEDIA_DISPLAY.$multimedia->PATH;?>">
    </video>
</div>
<?php endif; ?>
<div class="row fixed-bottom bg-ticket-transparent p-4" id="llamadas">
        <?php foreach ($tickets as $tk):?>
        <div class="col text-center">
            <div class="card mb-2 box-shadow alert
                <?php if($tk->blink == ON_DISPLAY_BLINK): ?>
                    alert-danger blink_me
                <?php elseif($tk->blink == ON_DISPLAY_TRUE): ?>
                    alert-success
                <?php endif; ?>
                    ">
                <div class="card-body">
                    <ul class="list-unstyled mt-3 mb-4">
                        <li>
                            <h1 class="display-4 font-weight-bold" id="siguiente"><?php echo $tk->ticket_codigo ?></h1>
                        </li>
                        <li>
                            <?php if($tk->blink == ON_DISPLAY_TRUE): ?>
                                <h3>Esta siendo atendido en: <span id="estacionAtencion" class="font-weight-bold"><?php echo $tk->estacion ?></span></h3>
                            <?php else: ?>
                                <h3>Pase a <span id="estacionAtencion"><?php echo $tk->estacion ?></span></h3>
                            <?php endif; ?>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
</div>

<?php $this->load->view('commons/scripts'); ?>
<script>


	setInterval(function() {
		$("#llamadas").load(" #llamadas > *","");
	}, 3000);
	function blinker() {
	    $('.blink_me').fadeOut(400);
	    $('.blink_me').fadeIn(400);
	}
	setInterval(blinker, 1000);
</script>

<style>
/* Style the video: 100% width and height to cover the entire window */
#myVideo {
    position: fixed;
    top: 10;
    right: 0;
    bottom: 0;
    min-width: 100%;
    min-height: 100%;
    z-index: 0;
}

/* Add some content at the bottom of the video/page */
.content {
    position: fixed;
    bottom: 0;
    background: rgba(0, 0, 0, 1);
    color: #f1f1f1;
    width: 100%;
    padding: 20px;
}

/* Style the button used to pause/play the video */
#myBtn {
    width: 200px;
    font-size: 18px;
    padding: 10px;
    border: none;
    background: #000;
    color: #fff;
    cursor: pointer;
}

#myBtn:hover {
    background: #ddd;
    color: black;
}
</style>
</div>
</body>