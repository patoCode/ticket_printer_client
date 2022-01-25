<!-- Modal -->
<div class="modal fade" id="llamarTicket" tabindex="-1" role="dialog" aria-hidden="false" data-backdrop="static">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="categoriaName">
          <i class="fa fa-ticket-alt"></i> TICKET
          <span id="ticketNro" class="badge badge-primary"></span>
        </h4>
        <h4>
          <i class="fa fa-bell"></i>
          <span id="nroLlamada" class="badge badge-success"></span>
        </h4>

      </div>
      <div class="modal-body" id="detalleTicket">
          <h4 id="accionTicket"></h4>
          <div class="row">
            <div class="col-md-3">
              <button class="btn btn-info btn-md btn-block llamarModal" data-id="">
                <i class="fa fa-bell"></i>
                LLAMAR
              </button>

            </div>
            <div class="col-md-3">
              <button class="btn btn-primary btn-md btn-block atenderModal" data-id="">
                <i class="fas fa-play-circle"></i>
                ATENDER
              </button>
            </div>
            <div class="col-md-3">
              <button class="btn btn-success btn-md btn-block finalizarModal" data-id="">
                <i class="fas fa-check-circle"></i> FINALIZAR
              </button>
            </div>
            <div class="col-md-3">
              <div class="btn-group btn-block" role="group" aria-label="...">
                <button class="btn btn-warning btn-md pausarTicket" data-id="">
                  <i class="fas fa-pause-circle"></i> PAUSAR
                </button>
                <button class="btn btn-primary btn-md continuarTicket" data-id="">
                  <i class="fas fa-history"></i> CONTINUAR
                </button>
              </div>
            </div>

          </div>
      </div>
    </div>
  </div>
</div>
