<?php 

if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$config['protocol'] = 'smtp';
$config['smtp_host'] = 'smtp.googlemail.com';
$config['smtp_port'] = 465;
$config['smtp_user'] = 'mendezjunior2015@gmail.com'; // correo sin espacio
$config['smtp_pass'] = 'ediel123456789';
$config['smtp_timeout'] = '7';
$config['charset'] = 'utf-8';
$config['newline'] = "\r\n";
$config['mailtype'] = 'text'; // or html
$config['validation'] = TRUE; // bool whether to validate email or not
 ?>