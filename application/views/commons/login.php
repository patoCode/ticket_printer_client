<?php $this->load->view('commons/header'); ?>
<body>
  <div class="container">
    <div class="row">
      <div class="col-md-6 offset-md-3">
        <div class="card bg-secondary mt-5">
          <div class="card-header bg-success  text-white">
            <h1 class="text-center ">Administrador</h1>
            <?php if($msg != null): ?>
              <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?php echo $msg ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
            <?php endif; ?>

          </div>
          <div class="card-body">
            <form class="form" action="<?php echo base_url()?>Login/checkLogin" method="POST">
                <label for="inputEmail" class="sr-only">Usuario</label>
                <input type="text" name="username" class="form-control" placeholder="Usuario" required="" autofocus="">
                <br>
                <label for="inputPassword" class="sr-only">Contraseña</label>
                <input type="password" name="password" class="form-control" placeholder="Contraseña" required="">
                <br>
                <button class="btn btn-lg btn-success btn-block" type="submit">
                <i class="fas fa-sign-in-alt"></i>
                  Iniciar sesión
                </button>
            </form>
          </div>
        </div>

      </div>
    </div>
  </div>

<?php $this->load->view('commons/footer'); ?>

</body>



