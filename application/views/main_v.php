<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Politics Made Simple</title>
	<!--Import Google Icon Font-->
	<link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<!--Import materialize.css-->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.98.0/css/materialize.min.css" media="screen,projection"/>
	<!--Let browser know website is optimized for mobile-->
	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
	<!--Import jQuery before materialize.js-->
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.98.0/js/materialize.min.js"></script>
	<!--Import Stately library-->
	<link rel="stylesheet" href="<?php echo base_url('assets/stately-master/assets/css/stately.css') ?>">
	<!-- Import Custom CSS and JS files -->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/custom/custom.css') ?>">
	<script src="<?php echo base_url('assets/custom/custom.js') ?>"></script>
	<script src="<?php echo base_url('assets/custom/custom.php') ?>"></script>
	<script>
		$(document).ready(function() {
			$('select').material_select();
		});
		$(document).ready(function(){
			$('.collapsible').collapsible();
		});
		$(document).ready(function(){
			$('#scaleInLegislatorSearch').click(function(){
				$('#stateSelectForm').addClass('scale-transition');
			});
		});
	</script>
</head>
<body>
	<?php $this->load->view('navigation_v') ?>
	<?php $this->load->view('legislators_v') ?>
</body>
