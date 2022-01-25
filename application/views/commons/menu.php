<nav class="navbar navbar-expand-md navbar-dark bg-dark mb-4  font-weight-bold">
      <a href="" class="navbar-brand" href="#">
        <img src="<?php echo base_url()?>public/image/main.png" width="50" height="50" class="d-inline-block align-middle" alt="">
        <?php echo NOMBRE_SIS; ?>
      </a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarCollapse">
        <ul class="navbar-nav justify-content-center w-100  font-weight-bold">
          <?php
            $menuList = $this->session->userdata('menu');
            foreach ($menuList as $key => $menu):
          ?>
          <li class="nav-item dropdown">
            <a class="nav-link btn btn-dark dropdown-toggle" href="#" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <?php echo $key;?>
            </a>
            <div class="dropdown-menu bg-success" aria-labelledby="dropdown01">
              <?php foreach ($menu as $opcion): ?>
              <a class="dropdown-item" href="<?php echo base_url().$opcion->URI;?>">
                <?php echo $opcion->nombre; ?>
              </a>
            <?php endforeach; ?>
            </div>
          </li>
          <?php endforeach; ?>
           <li class="nav-item dropdown">
            <a class="nav-link btn btn-dark dropdown-toggle" href="#" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php echo $this->session->userdata('username'); ?></a>
            <div class="dropdown-menu bg-success" aria-labelledby="dropdown01">
              <a class="dropdown-item" href="<?php echo base_url();?>Login/relogin">Reload</a>
              <a class="dropdown-item" href="<?php echo base_url();?>Login/logout">Salir</a>
            </div>
          </li>
        </ul>
      </div>
      <div id="reloj" class="mb-2 btn btn-info"></div>
      <img class="mb-2" src="<?php echo base_url(); ?>public/image/LOGO_ENDE_TECNOLOGIAS_FO.png" alt="" width="100" height="45">
    </nav>

