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
			<li><a href="<?=$site->base?>"><b class="glyphicon glyphicon-home icon"></b>Home</a></li>
			<? if (!$_SESSION['isloggedin']) { ?>
			<li><a href="<?=$site->base?>login/"><b class="glyphicon glyphicon-log-in icon"></b>Login</a></li>
			<li><a href="<?=$site->base?>register/"><b class="glyphicon glyphicon-registration-mark icon"></b>Register</a></li>
			<? } else { ?>
			<li><a href="<?=$site->base?>dashboard/"><b class="glyphicon glyphicon-dashboard icon"></b>Dashboard</a></li>			
			<? } ?>
			<!-- 
			<li class="dropdown">
			  <a href="#" class="dropdown-toggle" data-toggle="dropdown">More <b class="caret"></b></a>
			  <ul class="dropdown-menu">
				<li><a href="#">Action</a></li>
				<li><a href="#">Another action</a></li>
				<li class="divider"></li>
				<li><a href="#">Separated link</a></li>
				<li class="divider"></li>
				<li><a href="#">One more separated link</a></li>
			  </ul>
			</li>
			 -->
		</ul>
		<div class="col-sm-3 col-md-3 pull-right">
		  <form class="navbar-form" role="search">
			<div class="input-group">
				<input type="text" class="form-control" placeholder="Search" name="srch-term" id="srch-term">
				<div class="input-group-btn">
					<button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
				</div>
			</div>
		  </form>
		</div>
	</div>
</nav>