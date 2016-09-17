<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>JEFE</title>
</head>
<body>
	<h1>JEFE</h1>
	<?php print_r($this->session->userdata('logged_in'));?>
	<br>
<b id="logout"><a href="<?php echo base_url() ?>index.php/Home/logout">Logout</a></b>
</body>
</html>