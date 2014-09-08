<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
<div class="navbar-header">
		<div class="brand"><a rel="home" href="<?=$site->base?>"><? print $site->brand; ?></a></div>
		<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
		<span class="sr-only">Toggle navigation</span>
		<span class="icon-bar"></span>
		<span class="icon-bar"></span>
		<span class="icon-bar"></span>
		</button>
	</div>
	<div class="collapse navbar-collapse">
		<ul class="nav navbar-nav">
			<?=$site->module_links?>
		</ul>
		<div class="col-sm-3 col-md-3 pull-right">
		  <form class="navbar-form" method="get" action="<?=$site->base.'search/v/'?>" role="search">
			<div class="input-group">
				<input type="text" class="form-control" placeholder="Search" name="q" value="<? print htmlentities($_REQUEST['q']); ?>" id="srch-term">
				<div class="input-group-btn">
					<button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
				</div>
			</div>
		  </form>
		</div>
	</div>
</nav>