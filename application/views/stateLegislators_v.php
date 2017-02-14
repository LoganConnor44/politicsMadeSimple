<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Vote Smart API</title>
	<link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Roboto:300,400,500,700">
	<link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/icon?family=Material+Icons">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('vendor/twbs/bootstrap/dist/css/bootstrap.min.css') ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/bootstrap-material-design-master/dist/css/bootstrap-material-design.min.css') ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/bootstrap-material-design-master/dist/css/ripples.min.css') ?>">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.js"></script>
	<script src="<?php echo base_url('vendor/twbs/bootstrap/dist/js/bootstrap.js') ?>"></script>
	<script src="<?php echo base_url('assets/bootstrap-material-design-master/dist/js/material.min.js') ?>"></script>
	<script src="<?php echo base_url('assets/bootstrap-material-design-master/dist/js/ripples.min.js') ?>"></script>
	<link rel="stylesheet" href="<?php echo base_url('assets/stately-master/assets/css/stately.css') ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/custom/custom.css') ?>">
	<script>
		$(function() {
			$.material.init();
		});
	</script>
</head>
<body>
<?php $this->load->view('navigation_v', $landingPage) ?>
<div class="container">
	<div class="jumbotron">
		<h1><?php echo $stateDetail->legislature_name ?></h1>
		<p>
			<?php echo $stateDetail->legislature_name ?> members introduce bills, and approve or revoke the
			legislation presented depending on it's affect on the population of the state.
		</p>
		<?php echo $htmlChamberResponse ?>
		<p>
			Their official webpage can be found <a href="<?php echo $stateDetail->legislature_url ?>">here</a>.
		</p>
		<h2>Events</h2>
		<?php if(!$upcomingEvents) : ?>
			<p>There are no upcoming events.</p>
		<?php endif; ?>
		<?php if(is_object($upcomingEvents)) : ?>
			<p>There are upcoming events!</p>
		<?php endif; ?>
	</div>
</div>
<div class="container">
	<h2 class="hor-line text-center"><span id="horLine">Party Distribution</span></h2>
	<div class="row">
		<div class="col-sm-4">
			<canvas id="legisDonut"></canvas>
			<script>
				var legisD = document.getElementById("legisDonut");
				var legisDonut = new Chart(legisD, {
					type: 'doughnut',
					data:{
						labels: [<?php foreach($parties as $key => $party) : ?>
							'<?php echo $key ?>',
							<?php endforeach; ?>],
						datasets: [{
							label: '# of Votes',
							data:   [<?php foreach($parties as $key => $party) : ?>
								<?php echo count($party) ?>,
								<?php endforeach; ?>],
							backgroundColor: [
								'rgba(66,139,202, 0.5)',
								'rgba(217,83,79, 0.5)',
								'rgba(92,184,92, 0.5)',
								'rgba(75, 192, 192, 0.5)',
								'rgba(153, 102, 255, 0.5)',
								'rgba(255, 159, 64, 0.5)'
							],
							borderColor: [
								'rgba(66,139,202, 1)',
								'rgba(217,83,79, 1)',
								'rgba(92,184,92, 1)',
								'rgba(75, 192, 192, 1)',
								'rgba(153, 102, 255, 1)',
								'rgba(255, 159, 64, 1)'
							],
							borderWidth: 1
						}]
					},
					options:{
						title: {
							display: true,
							text: '<?php echo $stateDetail->legislature_name ?>',
							fontColor: '#000',
							fontSize: 20
						}
					}
				});
			</script>
		</div>
		<div class="col-sm-4">
			<canvas id="upperChamberDonut"></canvas>
			<script>
				var upperD = document.getElementById("upperChamberDonut");
				var upperChamberDonut = new Chart(upperD, {
					type: 'doughnut',
					data:{
						labels: [<?php foreach($partyAndChamber as $party => $chamber['upper']) : ?>
							'<?php echo $party ?>',
							<?php endforeach; ?>],
						datasets: [{
							label: '# of Votes',
							data:   [<?php foreach($partyAndChamber as $party => $chamber) : ?>
								<?php echo isset($chamber['upper']) ? count($chamber['upper']) : 0 ?>,
								<?php endforeach; ?>],
							backgroundColor: [
								'rgba(66,139,202, 0.5)',
								'rgba(217,83,79, 0.5)',
								'rgba(92,184,92, 0.5)',
								'rgba(75, 192, 192, 0.5)',
								'rgba(153, 102, 255, 0.5)',
								'rgba(255, 159, 64, 0.5)'
							],
							borderColor: [
								'rgba(66,139,202, 1)',
								'rgba(217,83,79, 1)',
								'rgba(92,184,92, 1)',
								'rgba(75, 192, 192, 1)',
								'rgba(153, 102, 255, 1)',
								'rgba(255, 159, 64, 1)'
							],
							borderWidth: 1
						}]
					},
					options:{
						title: {
							display: true,
							text: '<?php echo $stateDetail->chambers->upper->name ?>',
							fontColor: '#000',
							fontSize: 20
						}
					}
				});
			</script>
		</div>
		<div class="col-sm-4">
			<canvas id="lowerChamberDonut"></canvas>
			<script>
				var lowerD = document.getElementById("lowerChamberDonut");
				var lowerChamberDonut = new Chart(lowerD, {
					type: 'doughnut',
					data:{
						labels: [<?php foreach($partyAndChamber as $party => $chamber['lower']) : ?>
							'<?php echo $party ?>',
							<?php endforeach; ?>],
						datasets: [{
							label: '# of Votes',
							data:   [<?php foreach($partyAndChamber as $party => $chamber) : ?>
								<?php echo isset($chamber['lower']) ? count($chamber['lower']) : 0 ?>,
								<?php endforeach; ?>],
							backgroundColor: [
								'rgba(66,139,202, 0.5)',
								'rgba(217,83,79, 0.5)',
								'rgba(92,184,92, 0.5)',
								'rgba(75, 192, 192, 0.5)',
								'rgba(153, 102, 255, 0.5)',
								'rgba(255, 159, 64, 0.5)'
							],
							borderColor: [
								'rgba(66,139,202, 1)',
								'rgba(217,83,79, 1)',
								'rgba(92,184,92, 1)',
								'rgba(75, 192, 192, 1)',
								'rgba(153, 102, 255, 1)',
								'rgba(255, 159, 64, 1)'
							],
							borderWidth: 1
						}]
					},
					options:{
						title: {
							display: true,
							text: '<?php echo $stateDetail->chambers->lower->name ?>',
							fontColor: '#000',
							fontSize: 20
						}
					}
				});
			</script>
		</div>
	</div>
</div>
<hr>
<!--<footer>
		<?php /*$this->load->view('footer_v', $civicDataBy); */?>
	</footer>-->
</body>
