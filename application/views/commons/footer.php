<footer class="p-2 my-md-5 pt-md-5 border-top">
<div class="row ">
  <div class="col-12 col-md text-center">
    <small class="d-block mb-3 text-muted font-weight-bold"><?php echo COPYRIGHT; ?></small>
  </div>
</div>
</footer>
<div class="toast" id="myToast">
    <div class="toast-header">
        <strong class="mr-auto"><i class="fa fa-grav"></i> We miss you!</strong>
        <small>11 mins ago</small>
        <button type="button" class="ml-2 mb-1 close" data-dismiss="toast">&times;</button>
    </div>
    <div class="toast-body">
        It's been a long time since you visited us. We've something special for you. <a href="#">Click here!</a>
    </div>
</div>
<?php $this->load->view('commons/scripts'); ?>
<?php $this->load->view('commons/modal_mensaje'); ?>