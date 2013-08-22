<!doctype html>
<!--[if IE 7 ]>    <html lang="en" class="no-js ie7"> <![endif]-->
<!--[if IE 8 ]>    <html lang="en" class="no-js ie8"> <![endif]-->
<!--[if IE 9 ]>    <html lang="en" class="no-js ie9"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--> <html lang="en" class="no-js"> <!--<![endif]-->
<head>
	<title><?php echo TITULO_WEB?></title>
	<meta charset="UTF-8">
	<meta name="description" content="">
	<meta name="author" content="">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	
	<link rel="shortcut icon" href="<?php echo base_url();?>favicon.ico">
	<link rel="apple-touch-icon" href="<?php echo base_url();?>apple-touch-icon.png">
	
	<!-- CSS Styles -->
	<link rel="stylesheet" href="<?php echo base_url();?>css/style.css">
	<link rel="stylesheet" href="<?php echo base_url();?>css/colors.css">
	<link rel="stylesheet" href="<?php echo base_url();?>css/jquery.tipsy.css">
	<link rel="stylesheet" href="<?php echo base_url();?>css/jquery.wysiwyg.css">
	<link rel="stylesheet" href="<?php echo base_url();?>css/jquery.datatables.css">
	<link rel="stylesheet" href="<?php echo base_url();?>css/jquery.nyromodal.css">
	<link rel="stylesheet" href="<?php echo base_url();?>css/jquery.datepicker.css">
	<link rel="stylesheet" href="<?php echo base_url();?>css/jquery.fileinput.css">
	<link rel="stylesheet" href="<?php echo base_url();?>css/jquery.fullcalendar.css">
	<link rel="stylesheet" href="<?php echo base_url();?>css/jquery.visualize.css">

	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js"></script>
	<script>!window.jQuery && document.write(unescape('%3Cscript src="<?php echo base_url();?>js/jquery/jquery-1.5.1.min.js"%3E%3C/script%3E'))</script>
    <?php
    if(isset($extraheader)){echo $extraheader;}
    ?>
    
	<!-- Google WebFonts -->
	<link href='http://fonts.googleapis.com/css?family=PT+Sans:regular,italic,bold,bolditalic' rel='stylesheet' type='text/css'>

	<script src="<?php echo base_url();?>js/libs/modernizr-1.7.min.js"></script>
</head>

