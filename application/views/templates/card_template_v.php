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
			<p id="cardSubtitle">
                <? echo $cardSubtitle ?>
            </p>
		</div>
	</div>
	<?php $this->load->view($cardContent) ?>
</div>