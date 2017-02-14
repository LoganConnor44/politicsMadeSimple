<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Vote Smart API</title>
	<!-- Material Design fonts -->
	<link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Roboto:300,400,500,700">
	<link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/icon?family=Material+Icons">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('vendor/twbs/bootstrap/dist/css/bootstrap.min.css') ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/bootstrap-material-design-master/dist/css/bootstrap-material-design.min.css') ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/bootstrap-material-design-master/dist/css/ripples.min.css') ?>">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
	<script src="<?php echo base_url('vendor/twbs/bootstrap/dist/js/bootstrap.js') ?>"></script>
	<script src="<?php echo base_url('assets/bootstrap-material-design-master/dist/js/material.min.js') ?>"></script>
	<script src="<?php echo base_url('assets/bootstrap-material-design-master/dist/js/ripples.min.js') ?>"></script>
	<link rel="stylesheet" href="<?php echo base_url('assets/stately-master/assets/css/stately.css') ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/custom/custom.css') ?>">
	<script src="<?php echo base_url('assets/custom/custom.js') ?>"></script>
	<script>
		$(function() {
			$.material.init();
		});
	</script>
</head>
<body>
	<?php $this->load->view('navigation_v') ?>
	<?php $this->load->view('legislators_v') ?>
</body>
