<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Detalles de evaluación</title>
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
	<meta name="viewport" content="width=device-width" />

	
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link href="<?php echo base_url(); ?>libs/css/materialize.min.css" rel="stylesheet" />



	

	<style type="text/css">
	
	

	</style>

</head>
<body>
	<div>
	    <h6 class="center-align">DETALLES DE LA EVALUACIÓN DEL EQUIPO <?php echo $equipo['name'] ?></h6>
	</div>
	<?php //print_r($cuestionarios); ?>
	<div class="container">
		<div class="row">
          <div class="col s12 m10">
            <h4 class="light"><?php echo $equipo['name'] ?></h4>
            <div class="card mediun">
              <div class="card-image">
                <img src="<?php echo base_url(); ?>libs/images/team.jpg" style="height:100px; width: 200px;">
               
              </div>
              <div class="card-content">
                <!--<p>Es el equipo del 301</p>-->
              </div>
              <div class="card-action">
               
                <ul class="tabs">
			        <li class="tab col s3"><a class="active" href="#test1" >Cuestionarios asignados</a></li>
			        <li class="tab col s3"><a href="#test2">Cuestionarios terminados</a></li>
			        
			    </ul>
              </div>
            </div>
          </div>
          
        </div>
    
	</div>

	<div class="container">
		
			<div class="row" id="test1">
				<?php foreach ($cuestionarios as $cuestionario): ?>
		      <div class="col s12 m12">
		        <div class="card-panel " >
		          	<ul class="collapsible" data-collapsible="accordion">

					    <li>
					      <div class="collapsible-header"><i class="material-icons">assignment</i><h5><?php echo $cuestionario['name']; ?></h5></div>
					      <div class="collapsible-body">

					      		<p>Avance del cuestionario por eqipo :</p>	
								<progress max="100" value="<?php echo $cuestionario['avance_por_equipo'];?>" ></progress>
								<label><?php echo $cuestionario['avance_por_equipo']; ?>  %</label>
								<p>Integrantes  :</p>
								<div class="container">
								<table>
							        <thead>
							          <tr>
							              <th data-field="id">Nombre</th>
							              <th data-field="name">Preguntas contestadas</th>
							              <th data-field="price">Avance</th>
							          </tr>
							        </thead>

							        <tbody>
							        	<?php foreach ($cuestionario['integrantes'] as $integrante): ?>
							        		<tr>
									            <td><?php echo $integrante['name'] ?></td>
									            <td><?php echo $integrante['preguntas_contestadas'] ?> / <?php echo $cuestionario['total_preguntas'] ?> </td>
									            <td><progress max="100" value="<?php echo $integrante['porcentaje'] ?>" ></progress><label><?php echo $integrante['porcentaje'] ?> %</label></td>
									          </tr>
							        	<?php endforeach ?>
							          
							          
							        </tbody>
							    </table>
							    </div>
					      </div>
					    </li>
					    
					</ul>
		        </div>
		      </div>
		      <?php endforeach ?>
	    	</div>
	
		
		
    	<div class="row" id="test2">
	      <div class="col s12 m12">
	        <div class="card-panel " >
	          	<ul class="collapsible" data-collapsible="accordion">
				    <li>
				        <div class="collapsible-header"><i class="material-icons">assignment</i><h5>Cuestionario x</h5></div>
				        <div class="collapsible-body">
							
							
				        </div>
				    </li>
				    <li>
				      <div class="collapsible-header"><i class="material-icons">assignment</i><h5>Cuestionario y</h5></div>
				      <div class="collapsible-body"><p>Lorem ipsum dolor sit amet.</p></div>
				    </li>
				    <li>
				      <div class="collapsible-header"><i class="material-icons">assignment</i><h5>Cuestionario z</h5></div>
				      <div class="collapsible-body"><p>Lorem ipsum dolor sit amet.</p></div>
				    </li>
				</ul>
	        </div>
	      </div>
    	</div>

	</div>



	<div class="fixed-action-btn" style="top: 45px; right: 100px;">
		<a href="<?php echo base_url() ?>index.php/Equipos/" class="waves-effect waves-light btn-large"><i class="material-icons left">arrow_back</i>Regresar</a>
	   
	    
  	</div>

	
    
</body>

<!--   Core JS Files   -->
<script src="<?php echo base_url("libs/js/jquery-3.1.0.min.js"); ?>" type="text/javascript"></script>
<script src="<?php echo base_url("libs/js/materialize.min.js"); ?>" type="text/javascript"></script>

<!--<script src="<?php echo base_url("libs/js/script.js"); ?>" type="text/javascript"></script>-->






</html>
