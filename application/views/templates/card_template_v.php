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
	<div class="card-content-bg blue-text">
		<div class="card-content">
			<ul class="collapsible popout" data-collapsible="accordion">
                <?php foreach($eventData as $dataRow) : ?>
					<li>
						<div class="collapsible-header">
                            <div class="<?php echo strlen($dataRow->description) >= 40 ? "row" :""?>" id="addRowHereIfSizeApplies">
                                <i class="material-icons">info_outline</i>
	                            <?php echo $dataRow->description ?>
                                <span class="new badge disappearOnSmallMobile" data-badge-caption="<?php echo $dataRow->dateDifference ?>"></span>
                            </div>
                        </div>
						<div class="collapsible-body">
                            <span><?php echo $dataRow->when ?></span>
                        </div>
					</li>
				<?php endforeach; ?>
			</ul>
		</div>
	</div>
</div>