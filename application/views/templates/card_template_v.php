<script>
    $(document).ready(function(){
        $('.collapsible').collapsible();
    });
</script>
<div id="cardTemplate" class="card">
	<?php //add color variable?>
	<div class="card-header <? echo $cardColour ?>">
		<div class="card-title">
			<h3 id="cardTitle"><? echo $cardTitle ?></h3>
			<p id="cardSubtitle"><? echo $cardSubtitle ?></p>
		</div>
	</div>
	<div class="card-content-bg blue-text">
		<div class="card-content">
			<ul class="collapsible popout" data-collapsible="accordion">
				<?php $i=0 ?>
				<?php while ($i <= $numberOfEvents && $i < 5) : ?>
					<?php $i++?>
					<li>
						<div class="collapsible-header"><i class="material-icons">info_outline</i>First</div>
						<div class="collapsible-body"><span>Lorem ipsum dolor sit amet.</span></div>
					</li>
				<?php endwhile; ?>
			</ul>
		</div>
	</div>
</div>