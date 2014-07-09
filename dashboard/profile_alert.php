<!-- User Account: style can be found in dropdown.less -->
<li class="dropdown user user-menu"><a href="#"
	class="dropdown-toggle" data-toggle="dropdown"> <i
		class="glyphicon glyphicon-user"></i> <span><?=$_profile['name']?> <i
			class="caret"></i></span>
</a>
	<ul class="dropdown-menu">
		<!-- User image -->
		<li class="user-header bg-light-blue"><img src="<?=get_gravatar($_profile['email'], 60)?>"
			class="img-circle" alt="Avatar" />
			<p>
				<?=$_profile['name']?> - <?=ucfirst($_SESSION['role'])?> <small>Member since <?=getTime($_profile['date'])?></small>
			</p></li>
		<!-- Menu Body -->
		<li class="user-body">
			<div class="center-block text-center">
				<a href="#">Followers</a>
			</div>
		</li>
		<!-- Menu Footer-->
		<li class="user-footer">
			<div class="pull-left">
				<a href="<?=BASE_URL?>dashboard/settings/accounts/" class="btn btn-default btn-flat">Profile</a>
			</div>
			<div class="pull-right">
				<a href="<?=BASE_URL?>dashboard/system/logout/" class="btn btn-default btn-flat">Sign out</a>
			</div>
		</li>
	</ul></li>