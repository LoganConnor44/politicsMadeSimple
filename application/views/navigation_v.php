<nav class="red">
	<div class="nav-wrapper">
		<a href="<?php echo base_url() ?>" class="brand-logo">Politics Made Simple</a>
		<a href="#" data-activates="mobileNavigation" class="button-collapse">
			<i class="material-icons">menu</i>
		</a>
		<ul id="nav-mobile" class="right hide-on-med-and-down">
			<li><a href="<?php if($landingPage) : ?>
								<?php echo '#stateLegislators' ?>
							 <?php else : ?>
							    <?php echo base_url('#stateLegislators') ?>
							<?php endif; ?>">Legislature</a></li>
		</ul>
		<ul class="side-nav" id="mobileNavigation">
			<li><a href="<?php if($landingPage) : ?>
								<?php echo '#stateLegislators' ?>
							 <?php else : ?>
							    <?php echo base_url('#stateLegislators') ?>
							<?php endif; ?>">Legislature</a></li>
		</ul>
	</div>
</nav>
