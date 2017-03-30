<div id="cardTemplate" class="card">
	<?php //add color variable?>
	<div class="card-header <? echo $cardColour ?>">
		<div class="card-title">
			<?php //add title variable?>
			<h3 id="cardTitle"><? echo $cardTitle ?></h3>
			<?php //add subtitle variable?>
			<p id="cardSubtitle"><? echo $cardSubtitle ?></p>
		</div>
	</div>
	<div class="card-content-bg white-text">
		<div class="card-content">
			<?php //add content view here?>
		</div>
	</div>
</div>