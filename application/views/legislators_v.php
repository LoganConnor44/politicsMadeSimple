<div class="teal white-text extraBottomPadding">
	<div class="container">
		<div class="row">
			<div class="col s12 m12">
				<h1 class="center-align">State Legislature</h1>
				<div class="divider"></div>
				<p class="flow-text">
					State Legislators create and approve laws for their state. Every legislator is an elected official from
					their state. State Legislatures are made up of two chambers: the Senate and the House.<sup>*</sup>
					The	composition of each chamber varies and is determined by the state.
				</p>
			</div>
		</div>
		<div class="row">
			<div class="col s12 m6">
				<div class="card blue">
					<div class="card-content white-text">
						<span class="card-title"><h2 class="center-align">Senate</h2></span>
						<div class="divider"></div>
						<p class="flow-text">
							The State Senate is the smaller of the two chambers and has the ability to approve impeachment of an
							official. The term length for a state senator is usually 4 years.
						</p>
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
