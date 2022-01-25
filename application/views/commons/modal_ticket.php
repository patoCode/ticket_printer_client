<!-- Modal -->
<div class="modal fade" id="ticket" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="categoriaName"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="detalleTicket">
          <h5 class="text-center"><?php echo ENCABEZADO_TK." ".NOMBRE_EMP ?>
            <br>
            <?php echo WEB_EMPRESA; ?>
            <br>
            <?php echo SUCURSAL_TK; ?>
          </h5>
      		<h1 id="ticketNro" class="text-center font-weight-bold" ></h1>
          <ul class="list-inline font-weight-bold">
            <li id="fechaTK" class="list-inline-item"></li>
            <li id="horaTK" class="list-inline-item"></li>
          </ul>
          <ul class="list-inline">
            <li class="list-inline-item"><?php echo LEYENDA_TK_1; ?></li>
            <li class="list-inline-item"><?php echo LEYENDA_TK_2; ?> </li>
          </ul>
      </div>
    </div>
  </div>
</div>
