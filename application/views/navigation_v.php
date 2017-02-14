<nav id="mainNav" class="navbar navbar-default">
	<div class="container-fluid">
		<!-- Brand and toggle get grouped for better mobile display -->
		<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="<?php echo base_url() ?>">Politics Made Simple</a>
		</div>
		<!-- Collect the nav links, forms, and other content for toggling -->
		<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
			<ul class="nav navbar-nav">
				<li><a href="<?php if($landingPage) : ?>
								<?php echo '#stateLegislators' ?>
							 <?php else : ?>
							    <?php echo base_url('#stateLegislators') ?>
							<?php endif; ?>">Legislature</a></li>
				<?php /*not currently used
				<li><a href="#state">State</a></li>
				<li><a href="#electedOfficial">Elected Official</a></li>
                */?>
			</ul>
			<ul class="nav navbar-nav navbar-right">
			</ul>
		</div><!-- /.navbar-collapse -->
	</div><!-- /.container-fluid -->
</nav>
