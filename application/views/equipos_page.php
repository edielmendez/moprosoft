<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>ADMINISTRADOR</title>
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
	<meta name="viewport" content="width=device-width" />

	<!-- Se importo los estilos adecuados-->
	<link rel="apple-touch-icon" sizes="76x76" href="<?php echo base_url(); ?>/img/apple-icon.png">
	<link rel="icon" type="image/png" sizes="96x96" href="<?php echo base_url(); ?>/img/favicon.png">

  <link href="<?php echo base_url(); ?>public/css/bootstrap.min.css" rel="stylesheet" />
  <link href="<?php echo base_url(); ?>public/css/animate.min.css" rel="stylesheet"/>
  <link href="<?php echo base_url(); ?>public/css/paper-dashboard.css" rel="stylesheet"/>
  <link href="<?php echo base_url(); ?>public/css/demo.css" rel="stylesheet" />
	<link href="<?php echo base_url(); ?>public/css/themify-icons.css" rel="stylesheet">
	<link href="<?php echo base_url("libs/css/datatables.min.css"); ?>" rel="stylesheet">
	<link href="<?php echo base_url("libs/css/toastr.min.css"); ?>" rel="stylesheet">

  <link href="http://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
  <link href='https://fonts.googleapis.com/css?family=Muli:400,300' rel='stylesheet' type='text/css'>

	<!--link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>public/css/style.css">
	<script type='text/javascript' src="<?php echo base_url(); ?>public/js/jquery.min.js"></script-->
	<!-- -->

	<style type="text/css">
		.radio-modal{
			width: 20px;
			height: 20px;
			background: red;
		}
	</style>
</head>
<body>


	
	<div class="wrapper">
	    <div class="sidebar" data-background-color="white" data-active-color="danger">

	    <!--
			Tip 1: you can change the color of the sidebar's background using: data-background-color="white | black"
			Tip 2: you can change the color of the active button using the data-active-color="primary | info | success | warning | danger"
		-->

	    	<div class="sidebar-wrapper">
	            <div class="logo">
	                <a  class="simple-text">
	                    EQUIPOS
	                </a>
	            </div>

	            <ul class="nav">
	            	<li >
	                    <a href="<?php echo base_url() ?>index.php/Home/">
	                        <i class="ti-user"></i>
	                        <p>Estudiantes</p>
	                    </a>
	                </li>
	                <li class="active">
	                    <a href="">
	                        <i class="ti-eye"></i>
	                        <p>Equipos</p>
	                    </a>
	                </li>
	                <li >
	                    <a href="<?php echo base_url() ?>index.php/Evaluacion/">
	                        <i class="ti-settings"></i>
	                        <p>Evaluación</p>
	                    </a>
	                </li>
	                
	                
	            </ul>
	    	</div>
	    </div>

	    <div class="main-panel" >
	        <nav class="navbar navbar-default">
	            <div class="container-fluid">

	                <div class="navbar-header">
	                    <button type="button" class="navbar-toggle">
	                        <span class="sr-only">Toggle navigation</span>
	                        <span class="icon-bar bar1"></span>
	                        <span class="icon-bar bar2"></span>
	                        <span class="icon-bar bar3"></span>
	                    </button>
	                    <a class="navbar-brand" href="#">EQUIPOS</a>
	                </div>
	                <div class="collapse navbar-collapse">
	                    <ul class="nav navbar-nav navbar-right">
	                        <li class="dropdown">
	                              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
	                                    <i class="ti-user"></i>
	                                    <!--p class="notification">5</p-->
																			<p><?php print_r($this->session->userdata('logged_in')['username'] );?></p>
																			<b class="caret"></b>
	                              </a>
	                              <ul class="dropdown-menu">
	                                <li><a href="#">Perfil</a></li>
	                                <li><a href="<?php echo base_url() ?>index.php/Home/logout">Logout</a></li>
	                              </ul>
	                        </li>
	                    </ul>

	                </div>
	            </div>
	        </nav>

	        <div class="row">
	    		<div class="col-md-6 col-md-offset-3">
	    			<?php 
	    			
	    			echo $this->session->flashdata('message');
	    			 ?>
	    			
	                
	    		</div>
	    	</div>

	        <div class="content container" >
	        	<a href="<?php echo base_url() ?>index.php/Equipos/nuevo" class='btn btn-info btn-fill btn-wd'>Nuevo Equipo</a><br><br>
	            <div class="content table-responsive table-full-width">
	            	

                    <?php// print_r($equipos); ?>
                    <div class="row">
                    	<?php foreach ($equipos as $equipo) {
                    		# code...
                    		
                    	?>
                    	<div class="col-lg-10 col-sm-12">
	                        <div class="card">
	                            <div class="content">
	                                <div class="row">
	                                  <div class="col-xs-5">
	                                    <img src="<?php echo base_url(); ?>/public/img/equipo.jpg" style="width:100px; height:80px" alt="Procesos" /><br><br><br>
	                                  </div>
	                                  <div class="col-xs-9">
	                                  	<div class='numbers'>
	                                  		<?php echo $equipo['name']?>
	                                  	</div>
	                                    
	                                  </div>
	                                  <div class="col-xs-12" style="text-align: right;">
	                                    
	                                  </div>
	                                </div>
	                                <div class="footer">
	                                    <hr />
	                                    <div class="stats">
	                                        
	                                        <button class='btn btn-danger btn_elim_equipo' id='<?php echo $equipo['id']?>'><i class="ti-trash"></i> Eliminar</button>
	                                        <button class='btn btn-primary btn_act_name_equipo' id='<?php echo $equipo['id']?>'> Actualizar</button>
	                                        <?php
	                                        if(strcmp($equipo['estadistica'],"con") == 0){
	                                        	echo "<a href='".base_url()."index.php/Evaluacion/detalles/".$equipo['id']."' id='".$equipo['id']."'  ><i class='ti-settings'></i>Estadisticas de evaluación</a>";
	                                        }else{
												echo "<a  id=''><i class='ti-settings'></i>sin estadisticas</a>";
	                                        }
	                                        ?>
	                                        <!--<a href="#" id='<?php echo $equipo['id']?>'><i class="ti-settings"></i>Estadisticas de evaluación</a>-->
	                                        <?php
	                                        $b=1;
	                                        foreach ($equipo['integrantes'] as $integrante) {
	                                        	if($integrante['rol_id'] == 2){
	                                        		$b=0;
	                                        		break;
	                                        	}
	                                        }
	                                        if(($b == 1) && (count($equipo['integrantes'])!=0)){
	                                        	echo "<div class='lert alert-warning'>";
			                                    
				                                    echo "<span>! Equipo sin jefe ¡<b><a href='#' class='btn_select_jefe' id='".$equipo['id']."'>  Seleccionar</a></b></span>";
				                                echo "</div>";
	                                        }
	                                        ?>
	                                        
	                                        <?php if(count($equipo['integrantes'])==0){
										    	//echo "<a class='btn btn-waring' href='".base_url()."index.php/Equipos/agregar_miembros/".$equipo['id']."' > Agregar integrantes</a>";
										    }?>
	                                    </div>
	                                </div>
	                            </div>

	                          <div class="panel panel-default">
							    <div class="panel-heading" role="tab" id="headingOne">
							      <h4 class="panel-title">
							        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne<?php echo $equipo['id']?>" aria-expanded="true" aria-controls="collapseOne">
							        	<?php if(count($equipo['integrantes'])==0){
										    	echo "Sin Integrantes";
										}else{
											echo "<i class='ti-eye'></i>Integrantes";
										}
										?>
							            
							        </a>
							      </h4>
							    </div>

							    <div id="collapseOne<?php echo $equipo['id']?>" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
							      <div class="panel-body">
							        <div class="content">
		                                <ul class="list-unstyled team-members">
		                                	<?php
		                                	foreach ($equipo['integrantes'] as $miembro) {
		                                		# code...
		                                	
		                                	?>
		                                		
		                                	
		                                    <li>
		                                        <div class="row">
		                                            <div class="col-xs-2">
		                                                <div class="avatar">
		                                                    <img src="<?php echo base_url()?>/public/img/usuario.png" alt="Circle Image" class="img-circle img-no-padding img-responsive">
		                                                </div>
		                                            </div>
		                                            <div class="col-xs-4">
		                                                <?php echo $miembro['name']?>
		                                                <br />
		                                                <?php if ($miembro['rol']['type'] == "JEFE") {
		                                                	echo "<span class='text-success'>Jefe de equipo</span>";
		                                                	echo "<br><span class='text-danger'><a href='#' class='btn_cambiar_res text-danger' id='".$equipo['id']."'>Cambiar</a></span>";
		                                                }	
		                                                ?>
		                                                
		                                            </div>

		                                            <?php
		                                                	echo "<div class='col-xs-2' >";
				                                                echo "<a class='btn btn-sm btn-info btn-icon' href='".base_url()."index.php/Estudiantes/cambiarEquipo/".$miembro['id']."'>Cambiar de equipo</a>";
				                                            echo "</div>";
		                                                
		                                            ?>

		                                            
		                                            
		                                            <div class="col-xs-2 ">
		                                                <btn class="btn btn-sm btn-danger btn-icon"><i class="fa fa-envelope"></i> Enviar correo</btn>
		                                            </div>
		                                        </div>
		                                    </li>
		                                    
		                                    <?php
		                                	}
		                                	?>
		                                </ul>
		                            </div>
							      </div>
							    </div>
							  </div>


	                        </div>
                    	</div>
                    	<?php } ?>
                    </div>

                </div>
	        </div>

	        


	        <footer class="footer">
	            <!--<div class="container-fluid">
	                <nav class="pull-left">
	                    <ul>

	                        <li>
	                            <a href="http://www.creative-tim.com">
	                                Creative Tim
	                            </a>
	                        </li>
	                        <li>
	                            <a href="http://blog.creative-tim.com">
	                               Blog
	                            </a>
	                        </li>
	                        <li>
	                            <a href="http://www.creative-tim.com/license">
	                                Licenses
	                            </a>
	                        </li>
	                    </ul>
	                </nav>
	                <div class="copyright pull-right">
	                    &copy; <script>document.write(new Date().getFullYear())</script>, made with <i class="fa fa-heart heart"></i> by <a href="http://www.creative-tim.com">Creative Tim</a>
	                </div>
	            </div>-->
	        </footer>

	    </div>

	    

	   

	</div>

	<!--Modales-->
	<div class="modal fade" tabindex="-1" style="margin-top: 100px;" id="modal_act_equipo">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	    	<?php echo form_open('Equipos/actualizar',array('id' => 'form_modal_act_equipo' )); ?>
	        <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <h4 class="modal-title">Nuevo nombre del equipo</h4>
	        </div>
	      <div class="modal-body">
	        <div class="row">
	        	<div class="col-md-12">
	        		
                    <div class="form-group">
                        <label>Nombre del equipo</label>
						<input type="hidden" name="id" id="id_equipo_act" value="">

                        <input type="text" class="form-control border-input" id="nombre_equipo" placeholder="nombre equipo" name="nombre"  >
                    </div>
                </div>
	        </div>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
	        <input type="submit" class="btn btn-info" name="" value="Cambiar nombre">
	        
	      </div>
	      </form>
	    </div><!-- /.modal-content -->
	  </div><!-- /.modal-dialog -->
	</div><!-- /.modal -->

	<!--Modal eliminar equipo-->


	<div class="modal fade" tabindex="-1" role="dialog" id="modal_elim_equipo" style="margin-top: 100px">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	        <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <h4 class="modal-title">Eliminar Equipo</h4>
	        </div>
	      <div class="modal-body">
	        <p>Esta seguro de eliminar el equipo ?</p>
	        <input type="hidden" name="" id="id_equipo_elim" value="">
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
	        <button type="button" class="btn btn-danger" data-dismiss="modal" id="btn_acept_elim_equipo">Eliminar</button>
	      </div>
	    </div><!-- /.modal-content -->
	  </div><!-- /.modal-dialog -->
	</div><!-- /.modal -->

	<!--Modal cambiar responsable-->

	<div class="modal fade" tabindex="-1" style="margin-top: 100px;" id="modal_act_resp">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	    	<?php echo form_open('Equipos/actualizar_jefe',array('id' => 'aaaa' )); ?>
	        <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <h4 class="modal-title">Elija el nuevo responsable de equipo</h4>
	        </div>
	      <div class="modal-body">
	        <div class="row">
	        	<input  type='hidden' name='id_jefe_ant'  value=""  id="id_jefe_ant" />
	        	<div class="col-md-12" id="area_modal_est">
	        		
                    <!--<div class="form-group">
                        <div class="radio">
					    	<input  type='hidden' name='id_equipo'  value="" />
						  <label><input type="radio" required="" name="id_usuario">Ediel Mendez</label>
						</div>
                    </div>-->
                </div>
	        </div>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
	        <input type="submit" class="btn btn-info" name="" value="Cambiar responsable">
	        
	      </div>
	      </form>
	    </div><!-- /.modal-content -->
	  </div><!-- /.modal-dialog -->
	</div><!-- /.modal -->

	<!--Modal seleccionar responsable-->

	<div class="modal fade" tabindex="-1" style="margin-top: 100px;" id="modal_select_resp">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	    	<?php echo form_open('Equipos/set_jefe',array('id' => 'aaaa' )); ?>
	        <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <h4 class="modal-title">Elija jefe para el  equipo</h4>
	        </div>
	      <div class="modal-body">
	        <div class="row">
	        	
	        	<div class="col-md-12" id="area_modal_select_jefe_equipo">
	        		
                    <!--<div class="form-group">
                        <div class="radio">
					    	<input  type='hidden' name='id_equipo'  value="" />
						  <label><input type="radio" required="" name="id_usuario">Ediel Mendez</label>
						</div>
                    </div>-->
                </div>
	        </div>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
	        <input type="submit" class="btn btn-info" name="" value="Aceptar">
	        
	      </div>
	      </form>
	    </div><!-- /.modal-content -->
	  </div><!-- /.modal-dialog -->
	</div><!-- /.modal -->

</body>

<!--   Core JS Files   -->
<script src="<?php echo base_url(); ?>public/js/jquery-1.10.2.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>public/js/bootstrap.min.js" type="text/javascript"></script>

<!--  Checkbox, Radio & Switch Plugins -->
<script src="<?php echo base_url(); ?>public/js/bootstrap-checkbox-radio.js"></script>

<!--  Charts Plugin -->
<script src="<?php echo base_url(); ?>public/js/chartist.min.js"></script>

<!--  Notifications Plugin    -->
<script src="<?php echo base_url(); ?>public/js/bootstrap-notify.js"></script>

<!--  Google Maps Plugin    -->
<!--script type="text/javascript" src="https://maps.googleapis.com/maps/api/js"></script-->

<!-- Paper Dashboard Core javascript and methods for Demo purpose -->
<script src="<?php echo base_url(); ?>public/js/paper-dashboard.js"></script>

<!-- Paper Dashboard DEMO methods, don't include it in your project! -->
<script src="<?php echo base_url(); ?>public/js/demo.js"></script>

<script src="<?php echo base_url("libs/js/datatables.min.js"); ?>"></script>
<script src="<?php echo base_url("libs/js/toastr.min.js"); ?>"></script>
<script src="<?php echo base_url("libs/js/script.js"); ?>" type="text/javascript"></script>

<script type="text/javascript">
	$(document).ready(function(){
			$('#tabla_estudiantes').DataTable();
			$('.collapse').collapse()
			
	});
</script>


</html>
