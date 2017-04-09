<div class="card-content-bg blue-text">
		<div class="card-content <?php echo $numberOfEvents > 0 ? '' : 'hide' ?>">
			<ul class="collapsible popout" data-collapsible="accordion">
                <?php foreach($eventData as $dataRow) : ?>
					<li>
						<div class="collapsible-header">
                            <div class="<?php echo strlen($dataRow->description) >= 40 ? "row" :""?>">
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