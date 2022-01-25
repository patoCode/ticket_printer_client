<!-- Modal -->
<div class="modal fade" id="motivoPausa" tabindex="-1" role="dialog" aria-hidden="false" data-backdrop="static">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="pausaTitulo"></h4>
      </div>
      <div class="modal-body">
        <form action="" id="form-pausa" method="POST">
          <select name="motivo" id="selectMotivos" class="form-control"></select>
          <input type="hidden" name="tipoPausa" id="tipoPausaValue">
          <input type="hidden" name="ticket" value="" readonly>
          <input type="hidden" name="zona" value="" readonly>
          <hr>
          <input class="btn btn-success btn-lg btn-block" type="submit" value="APLICAR">
          <!-- <input class="btn btn-secondary btn-lg " type="reset" value="LIMPIAR"> -->
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-warning " data-dismiss="modal">CERRAR</button>
      </div>
    </div>
  </div>
</div>
