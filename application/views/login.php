<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=UTF-8">
		<meta charset="utf-8">
		<title>Bootstrap Login Form</title>
		<meta name="generator" content="Bootply" />
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
		<link href="<?php echo base_url("libs/css/bootstrap.min.css"); ?>" rel="stylesheet">
		<!--[if lt IE 9]>
			<script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->
		<link href="<?php echo base_url("libs/css/styles.css"); ?>" rel="stylesheet">
    <style type="text/css">
      .alerta{
        margin-top: 400px;
      }
    </style>
	</head>
	<body>
	


	
<!--login modal-->
<div id="loginModal" class="modal show" tabindex="-1" role="dialog" aria-hidden="true">

  <div class="modal-dialog">
  <div class="modal-content">
      <div class="modal-header">
          <!--<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>-->
          <h1 class="text-center">Login</h1>
      </div>
      <div class="modal-body">
          <!--<form class="form col-md-12 center-block">-->
          <?php echo form_open('Login',array('class'=>'form col-md-12 center-block')); ?>
            <div class="form-group">
              <input type="text" class="form-control input-lg" placeholder="Usuario" name="username" required="">
            </div>
            <div class="form-group">
              <input type="password" class="form-control input-lg" placeholder="Password" name="password" required="">
            </div>
            <div class="form-group">
              <button class="btn btn-primary btn-lg btn-block">Entrar</button>
              <!--<span class="pull-right"><a href="#">Register</a></span><span><a href="#">Need help?</a></span>-->
            </div>
          </form>
      </div>
      <div class="modal-footer">
          <div class="col-md-12">
          <!--<button class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>-->
		  </div>	
      </div>
  </div>
  </div>
</div>

<div class="container">
  <div class="row alerta">
    <div class="col-md-6 col-md-offset-3 col-sm-12">
      <div class="alert alert-warning">
        <b><?php echo validation_errors(); ?></b>
        <b><?php echo $this->session->flashdata('message'); ?></b>
      </div>
      
    </div>
  </div>
</div>


	<!-- script references -->
		<script src="<?php echo base_url("libs/js/jquery-3.1.0.min.js"); ?>"></script>
		<script src="<?php echo base_url("libs/js/bootstrap.min.js"); ?>"></script>
	</body>
</html>