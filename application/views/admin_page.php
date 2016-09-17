<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Administrador</title>
</head>
<body>
	<h1>Administrador</h1>
	<?php print_r($this->session->userdata('logged_in'));?>
	<br>
	<h1>Usuarios</h1>
	<?php print_r($usuarios); ?>
	<br>
	<br>
	<h1>Equipos</h1>
	<?php print_r($equipos); ?>
	<br>
	<br>
<b id="logout"><a href="<?php echo base_url() ?>index.php/Home/logout">Logout</a></b>
<br>
<br>
<a href="<?php echo base_url() ?>index.php/Estudiantes/nuevo" class='btn btn-default'>Nuevo Estudiante</a>
</body>
</html>