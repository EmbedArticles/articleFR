<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		Users <small>Control panel</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
		<li><a href="#"><i class="fa fa-group"></i> Users</a></li>
		<li class="active"><i class="fa fa-envelope"></i> Message</li>
	</ol>
</section>
<!-- Main content -->
<section class="content">
	<!-- Main row -->
	<div class="row">
		<section class="col-lg-6">
			<div class="box box-success">
				<div class="box-header">
					<h3 class="box-title">Message Users</h3>
				</div>
				<div class="box-body">
					<form method="post" action="<?=BASE_URL?>dashboard/sendmessage.php" target="progressFrame">						
						<div class="form-group">
							<label>Title</label> <input type="text" class="form-control"
								name="title" placeholder="Title ..." parsley-trigger="change"
								required />
						</div>
						<div class="form-group">
							<label>Content</label>
							<textarea id="content" name="content" class="input form-control"
								rows="20" placeholder="Content ..." parsley-trigger="change"
								required></textarea>
						</div>
						<div class="box-footer" style="margin-top: 30px;">
							<button type="submit" name="submit" value="Message"
								class="btn btn-primary">
								<b class="fa fa-envelope"></b> Send Message
							</button>
						</div>
					</form>
				</div>
				<!-- /.box-body -->
			</div>
		</section>
		<section class="col-lg-6">
			<div class="box box-info">
				<div class="box-header">
					<h3 class="box-title">Process Status</h3>
				</div>
				<div class="box-body">				                    
					<iframe name="progressFrame" style="width: 100%; height: 60px; background: none transparent; overflow: hidden;" frameborder="0" allowtransparency="true"></iframe>
				</div>
				<!-- /.box-body -->
			</div>
		</section>
	</div>
	<!-- /.row (main row) -->
</section>
<!-- /.content -->