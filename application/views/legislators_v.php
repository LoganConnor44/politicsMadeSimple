<div id="stateLegislators">
	<div class="container">
		<div class="jumbotron">
			<h1>State Legislature</h1>
			<p>
				State Legislators create and approve laws for their state. Every legislator is an elected official from
				their state. State Legislatures are made up of two chambers: the Senate and the House.<sup>*</sup>
				The	composition of each chamber varies and is determined by the state.
			</p>
			<h2>Senate</h2>
			<p>
				The State Senate is the smaller of the two chambers and has the ability to approve impeachment of an
				official. The term length for a state senator is usually 4 years.
			</p>
			<p>
				Leadership within the Senate is based on political party, resulting in a Majority and Minority Leader.
				These leadership roles are put in place to make a unified, informed decision for the people they
				represent.
			</p>
			<h2>House</h2>
			<p>
				The House of Representatives is the larger of the two chambers and has the ability to initiate tax
				legislation and the impeachment process of an official. The term length for a House Representative is
				usually two years.
			</p>
			<p>
				The leadership title within the House is called The Speaker of the House.
			</p>
			<p><a class="btn btn-primary btn-raised btn-lg" href="#" role="button">Learn more</a></p>
		</div>
		<div class="row">
			<div class="col-xs-12 col-sm-6 col-md-6">
				<div class="thumbnail">
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
					<div class="caption">
						<h3 data-toggle="collapse" href="#byStateLegislators" aria-expanded="false" aria-controls="byBill">
							Search For Legislators
						</h3>
						<div class="collapse" id="byStateLegislators">
							<div class="form-group">
								<form method="post" id="<?php echo $methodNames['legislators'] ?>" action="
									<?php echo base_url(index_page() . 'Legislature') ?>">
									<label for="stateSelect">Select State</label>
									<select name='stateSelect' form="<?php echo $methodNames['legislators'] ?>"
									        id='stateSelect' class="form-control">
										<?php foreach($states as $stateAbbreviation => $stateFullName) : ?>
											<option value='<?php echo $stateAbbreviation ?>'><?php echo $stateFullName ?></option>
										<?php endforeach;?>
									</select>
									<button type="submit" class="btn btn-primary btn-raised">Search</button>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
			<?php /*not currently used
			<div class="col-xs-12 col-sm-6 col-md-6">
				<div class="thumbnail" data-toggle="collapse" href="#byBill" aria-expanded="false" aria-controls="byBill">
					<!-- Placeholder Image-->
					<img src="https://d30y9cdsu7xlg0.cloudfront.net/png/1033-200.png" alt="...">
					<div class="caption">
						<h3>Search For Bills</h3>
						<div class="collapse" id="byBill">
							<div class="form-group">
								<form method="post" id="<?php echo $methodNames['bills'] ?>" action="
									<?php echo base_url(index_page() . 'VoteSmart/' . $methodNames['bills']) ?>">
									<label for="stateSelect">Define Search By</label>
									<br>
									<button type="button" class="btn btn-default">Keyword</button>
									<button type="button" class="btn btn-default">Date Range</button>
									<button type="button" class="btn btn-default">Sponsored By A Legislator</button>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
			*/ ?>
		</div>
	</div>
</div>
