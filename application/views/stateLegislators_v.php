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
	<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.98.0/js/materialize.min.js"></script>
	<!--Import Stately library-->
	<link rel="stylesheet" href="<?php echo base_url('assets/stately-master/assets/css/stately.css') ?>">
	<!--Import Charts.js library-->
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.js"></script>
	<!-- Import Custom CSS and JS files -->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/custom/custom.css') ?>">
	<script src="<?php echo base_url('assets/custom/custom.js') ?>"></script>
</head>
<body>
	<?php $this->load->view('navigation_v', $landingPage) ?>
	<div class="teal white-text extraBottomPadding">
		<div class="container">
			<div class="row">
				<div class="col s12 m12">
					<h1 class="center-align"><?php echo $stateDetail->legislature_name ?></h1>
					<div class="divider"></div>
					<p>
						<?php echo $stateDetail->legislature_name ?> members introduce bills, and approve or revoke the
						legislation presented depending on it's affect on the population of the state.
					</p>
					<?php echo $htmlChamberResponse ?>
					<p>
						Their official webpage can be found <a id="customLinkColour" href="<?php echo $stateDetail->legislature_url ?>">here</a>.
					</p>
					<h2>Events</h2>
					<?php if(!$isThereAnUpcomingEvent) : ?>
						<p>There are no upcoming events.</p>
					<?php else : ?>
						<p>There are <?php echo $numberOfEvents ?> upcoming events!</p>
					<?php endif; ?>
				</div>
			</div>
			<div class="row">
				<div class="col s12 m6">
					<div class="card teal darken-2">
						<div class="card-content">
							<span class="card-title"><h3 class="center-align">Party Distribution</h3></span>
							<div class="divider"></div>
							<canvas id="legisDonut"></canvas>
							<span class="activator card-title extraTopMargin">View Details<i class="material-icons right">info_outline</i></span>
						</div>
						<div class="card-reveal">
							<span class="card-title grey-text text-darken-4">Party Distribution<i class="material-icons right">close</i></span>
							<div class="grey-text text-darken-4">
								<p>
									There is a total of
										<?php $numItems = count($parties); ?>
										<?php $i = 0; ?>
										<?php foreach($parties as $key => $party) : ?>
											<?php if(++$i === $numItems) : ?>
												<?php echo 'and ' . count($party) .' ' . $key . 's.' ?>
											<?php else : ?>
												<?php echo count($party) .' ' . $key . 's,' ?>
											<?php endif; ?>
										<?php endforeach; ?>
								</p>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col s12 m6">
					<div class="card teal darken-2">
						<div class="card-content white-text">
							<span class="card-title"><h2 class="center-align">Senate</h2></span>
							<div class="divider"></div>
							<canvas id="upperChamberDonut"></canvas>
							<span class="activator card-title extraTopMargin">View Details<i class="material-icons right">info_outline</i></span>
						</div>
						<div class="card-reveal">
							<span class="card-title grey-text text-darken-4">Party Distribution<i class="material-icons right">close</i></span>
							<div class="grey-text text-darken-4">
								<p>
									There is a total of
									<?php $numItems = count($partyAndChamber); ?>
									<?php $i = 0; ?>
									<?php foreach($partyAndChamber as $party => $officialsData) : ?>
										<?php if(++$i === $numItems) : ?>
											<?php echo 'and ' . count($officialsData['upper']) ." $party." ?>
										<?php else : ?>
											<?php echo count($officialsData['upper']) ." $party," ?>
										<?php endif; ?>
									<?php endforeach; ?>
								</p>
							</div>
						</div>
					</div>
				</div>
				<div class="col s12 m6">
					<div class="card teal darken-2">
						<div class="card-content white-text">
							<span class="card-title"><h2 class="center-align">House</h2></span>
							<div class="divider"></div>
							<canvas id="lowerChamberDonut"></canvas>
							<span class="activator card-title extraTopMargin">View Details<i class="material-icons right">info_outline</i></span>
						</div>
						<div class="card-reveal">
							<span class="card-title grey-text text-darken-4">Party Distribution<i class="material-icons right">close</i></span>
							<div class="grey-text text-darken-4">
								<p>
									There is a total of

									<?php foreach($partyAndChamber as $party => $officialsData) : ?>
										<?php $numItems = count($officialsData['lower']); ?>
										<?php var_dump($officialsData) ?>
										<?php $i = 0; ?>
										<?php if(!$officialsData['lower']) : ?>
											<?php unset($officialsData) ?>
										<?php endif; ?>
									<?php endforeach; ?>

									<?php $partyAndChamber->party ?>

									<?php foreach($partyAndChamber as $party => $officialsData) : ?>

											<?php if(++$i === $numItems) : ?>

												<?php echo 'and ' . count($officialsData['lower']) ." $party." ?>

											<?php else : ?>

												<?php echo count($officialsData['lower']) ." $party," ?>

											<?php endif; ?>

									<?php endforeach; ?>
								</p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php $this->load->view('footer_v') ?>
</body>
</html>







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
					'rgba(68,138,255,0.75)',
					'rgba(255,82,82,0.75)',
					'rgba(0,230,118,0.75)',
					'rgba(75, 192, 192, 0.5)',
					'rgba(153, 102, 255, 0.5)',
					'rgba(255, 159, 64, 0.5)'
				],
				borderColor: [
					'rgb(41,121,255,1)',
					'rgba(255,23,68,1)',
					'rgba(0,200,83,1)',
					'rgba(75, 192, 192, 1)',
					'rgba(153, 102, 255, 1)',
					'rgba(255, 159, 64, 1)'
				],
				borderWidth: 1
			}]
		},
		options: {
			legend: {
				labels: {
					fontColor:"white"
				}
			}
		}
	});
</script>

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
					'rgba(68,138,255,0.75)',
					'rgba(255,82,82,0.75)',
					'rgba(0,230,118,0.75)',
					'rgba(75, 192, 192, 0.5)',
					'rgba(153, 102, 255, 0.5)',
					'rgba(255, 159, 64, 0.5)'
				],
				borderColor: [
					'rgb(41,121,255,1)',
					'rgba(255,23,68,1)',
					'rgba(0,200,83,1)',
					'rgba(75, 192, 192, 1)',
					'rgba(153, 102, 255, 1)',
					'rgba(255, 159, 64, 1)'
				],
				borderWidth: 1
			}]
		},
		options: {
			legend: {
				labels: {
					fontColor:"white"
				}
			}
		}
	});
</script>

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
					'rgba(68,138,255,0.75)',
					'rgba(255,82,82,0.75)',
					'rgba(0,230,118,0.75)',
					'rgba(75, 192, 192, 0.5)',
					'rgba(153, 102, 255, 0.5)',
					'rgba(255, 159, 64, 0.5)'
				],
				borderColor: [
					'rgb(41,121,255,1)',
					'rgba(255,23,68,1)',
					'rgba(0,200,83,1)',
					'rgba(75, 192, 192, 1)',
					'rgba(153, 102, 255, 1)',
					'rgba(255, 159, 64, 1)'
				],
				borderWidth: 1
			}]
		},
		options: {
			legend: {
				labels: {
					fontColor:"white"
				}
			}
		}
	});
</script>

