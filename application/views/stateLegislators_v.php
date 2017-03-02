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
			<div class="row">
				<div class="col s12 m6">
					<div class="card teal darken-2">
						<div class="card-content white-text">
							<span class="card-title"><h2 class="center-align">Party Distribution</h2></span>
							<div class="divider"></div>
							<canvas id="legisDonut"></canvas>
						</div>
					</div>
				</div>
				<div class="col s12 m6">
					<div class="card blue" id="testing">
						<div class="card-content white-text">
							<span class="card-title"><h2 class="center-align">House</h2></span>
							<div class="divider"></div>
							<p class="flow-text">
								The House of Representatives is the larger of the two chambers and has the ability to initiate tax
								legislation and the impeachment process of an official. The term length for a House Representative is
								usually two years.
							</p>
							<p class="flow-text">
								The leadership title within the House is called The Speaker of the House.
							</p>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col s12 m6">
					<div class="card blue">
						<div class="card-image">
							<ul class="stately" data-toggle="collapse" href="#byStateLegislators" aria-expanded="false" aria-controls="byBill">
								<li data-state="al" class="al">A</li>
								<li data-state="ak" class="ak">B</li>
								<li data-state="ar" class="ar">C</li>
								<li data-state="az" class="az">D</li>
								<li data-state="ca" class="ca">E</li>
								<li data-state="co" class="co">F</li>
								<li data-state="ct" class="ct">G</li>
								<li data-state="de" class="de">H</li>
								<li data-state="dc" class="dc">I</li>
								<li data-state="fl" class="fl">J</li>
								<li data-state="ga" class="ga">K</li>
								<li data-state="hi" class="hi">L</li>
								<li data-state="id" class="id">M</li>
								<li data-state="il" class="il">N</li>
								<li data-state="in" class="in">O</li>
								<li data-state="ia" class="ia">P</li>
								<li data-state="ks" class="ks">Q</li>
								<li data-state="ky" class="ky">R</li>
								<li data-state="la" class="la">S</li>
								<li data-state="me" class="me">T</li>
								<li data-state="md" class="md">U</li>
								<li data-state="ma" class="ma">V</li>
								<li data-state="mi" class="mi">W</li>
								<li data-state="mn" class="mn">X</li>
								<li data-state="ms" class="ms">Y</li>
								<li data-state="mo" class="mo">Z</li>
								<li data-state="mt" class="mt">a</li>
								<li data-state="ne" class="ne">b</li>
								<li data-state="nv" class="nv">c</li>
								<li data-state="nh" class="nh">d</li>
								<li data-state="nj" class="nj">e</li>
								<li data-state="nm" class="nm">f</li>
								<li data-state="ny" class="ny">g</li>
								<li data-state="nc" class="nc">h</li>
								<li data-state="nd" class="nd">i</li>
								<li data-state="oh" class="oh">j</li>
								<li data-state="ok" class="ok">k</li>
								<li data-state="or" class="or">l</li>
								<li data-state="pa" class="pa">m</li>
								<li data-state="ri" class="ri">n</li>
								<li data-state="sc" class="sc">o</li>
								<li data-state="sd" class="sd">p</li>
								<li data-state="tn" class="tn">q</li>
								<li data-state="tx" class="tx">r</li>
								<li data-state="ut" class="ut">s</li>
								<li data-state="va" class="va">t</li>
								<li data-state="vt" class="vt">u</li>
								<li data-state="wa" class="wa">v</li>
								<li data-state="wv" class="wv">w</li>
								<li data-state="wi" class="wi">x</li>
								<li data-state="wy" class="wy">y</li>
							</ul>
							<span class="card-title" style="background:rgba(0,0,0,0.5); padding: 0 3px; border-radius: 1px">Search For Legislators</span>
							<a class="btn-floating halfway-fab waves-effect waves-light teal" id="repurposeAnchor">
								<i class="material-icons scale-transition scale-in" onClick="getStatesFromPHP()" id="stateSearchIcon">search</i>
							</a>
						</div>
						<form method="post" id="<?php echo $methodNames['legislators'] ?>" action="<?php echo base_url(index_page() . 'Legislature') ?>">
							<div id="appendSelectHere"></div>
							<button hidden onclick="document.getElementById('legislators').submit()"></button>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
</html>










<!DOCTYPE html>
<html lang="en">
<head>

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
