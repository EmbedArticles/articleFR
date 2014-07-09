<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		Messages <small>Control panel</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
		<li class="active"><i class="fa fa-inbox"></i> Inbox</li>
	</ol>
</section>

<!-- Main content -->
<section class="content">
	
	<!-- Main row -->
	<div class="row">
		<div class="col-xs-12">
			
		<?php

		if (isset($_REQUEST['dos'])) {
			if ($_REQUEST['action'] == 'Read') {
				foreach($_REQUEST['dos'] as $_dos) {
					updateMessage($_dos, 'status', 2, $_conn);
				}
				print '
					<div class="alert alert-success alert-dismissable">
					<i class="fa fa-check"></i>
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<b>Alert!</b> Success: Your message(s) has been marked as read.
					</div>
				';				
			} else if ($_REQUEST['action'] == 'Unread') {
				foreach($_REQUEST['dos'] as $_dos) {
					updateMessage($_dos, 'status', 1, $_conn);
				}
				print '
					<div class="alert alert-success alert-dismissable">
					<i class="fa fa-check"></i>
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<b>Alert!</b> Success: Your message(s) has been marked as unread.
					</div>
				';				
			} else if ($_REQUEST['action'] == 'Delete') {
				foreach($_REQUEST['dos'] as $_dos) {
					updateMessage($_dos, 'status', 3, $_conn);
				}
				print '
					<div class="alert alert-info alert-dismissable">
					<i class="fa fa-info"></i>
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<b>Alert!</b> Success: Your message(s) has been marked as deleted.
					</div>
				';				
			}
		}
		
		if (isset($_REQUEST['pa']) && $_REQUEST['pa'] == 'delete') {
			updateMessage($_REQUEST['id'], 'status', 3, $_conn);
			print '
				<div class="alert alert-info alert-dismissable">
					<i class="fa fa-info"></i>
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<b>Alert!</b> Information: Your message has been deleted.
				</div>
			';
		}
				
		if (isset($_REQUEST['pa']) && $_REQUEST['pa'] == 'read') {
			updateMessage($_REQUEST['id'], 'status', 2, $_conn);
			$_message = getMessage($_REQUEST['id'], $_conn);
			print '
				<div class="box box-solid">
					<div class="box-header">
						<h3 class="box-title">' . $_message['subject'] . '</h3>
					</div>
					
					<div class="box-body table-responsive">
						<dl class="dl-horizontal">
							<dt>To:</dt>
							<dd>' . $_message['to'] . '</dd>
							<dt>From:</dt>
							<dd>' . $_message['from'] . '</dd>
							<dt>Content:</dt>
							<dd>' . htmlspecialchars_decode($_message['message']) . '</dd>
						</dl>								
					</div>
					<div class="box-footer text-center">
						<a class="btn btn-app" href="' . BASE_URL . 'dashboard/messages/inbox/?pa=reply&id=' . $_message ['id'] . '"><i class="fa fa-reply"></i> Reply</a>
						<a class="btn btn-app" href="' . BASE_URL . 'dashboard/messages/inbox/?pa=delete&id=' . $_message ['id'] . '"><i class="fa fa-trash-o"></i> Trash</a>
					</div>
					<!-- /.box-body -->
				</div>
			';
		}
		
		if (isset($_REQUEST['pa']) && $_REQUEST['pa'] == 'reply') {
			if (isset($_REQUEST['submit']) && $_REQUEST['submit'] == 'submit') {
				$_sent = sendMessage($_REQUEST['to'], $_REQUEST['from'], $_REQUEST['content'], $_REQUEST['subject'], $_conn);
				if ($_sent == 1) {
					print '
						<div class="alert alert-success alert-dismissable">
							<i class="fa fa-check"></i>
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
							<b>Alert!</b> Success: Your message has been sent.
						</div>
					';					
				} else if ($_sent == 0) {
					print '
						<div class="alert alert-danger alert-dismissable">
							<i class="fa fa-ban"></i>
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
							<b>Alert!</b> Error: Your message sending failed because of an unknown error.
						</div>
					';					
				}
			}
			$_message = getMessage($_REQUEST['id'], $_conn);
			print '
				<div class="box box-solid">
					<form method="post" parsley-validate>
					<div class="box-header">
						<h3 class="box-title">RE: ' . $_message['subject'] . '</h3>
					</div>
			
					<div class="box-body">						
						<dl class="dl-horizontal">
							<div class="form-group">
								<dt>To:</dt>
								<dd><input type="text" name="to" value="' . $_message['from'] . '" class="form-control" parsley-trigger="change" required readonly></dd>
							</div>
							<div class="form-group">
								<dt>From:</dt>
								<dd><input type="text" name="from" value="' . $_profile['username'] . '" class="form-control" parsley-trigger="change" required readonly></dd>
							</div>
							<div class="form-group">	
								<dt>Content:</dt>
								<dd><textarea id="content" name="content" class="form-control" rows="10" placeholder="You Message..." parsley-trigger="change" required><br><br><br>Last ' . $_message['date'] . ' ' . $_message['from'] . ' Wrote:<br>------------------------------------<br>' . $_message['message'] . '</textarea></dd>
							</div>			
						</dl>						
					</div>
					<div class="box-footer">
						<div class="btn-group">
							<input type="hidden" name="subject" value="RE: ' . htmlspecialchars($_message['subject']) . '">
							<button type="submit" name="submit" value="submit" class="btn btn-info"><b class="fa fa-reply"></b> Send Reply</button>
							<button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown">
								<span class="caret"></span>
								<span class="sr-only">Toggle Dropdown</span>
							</button>
							<ul class="dropdown-menu text-left" role="menu">
								<li><a href="' . BASE_URL . 'dashboard/messages/inbox/?pa=read&id=' . $_message ['id'] . '"><i class="fa fa-arrow-left"></i> Back to Message</a></li>
								<li><a href="' . BASE_URL . 'dashboard/messages/inbox/?pa=delete&id=' . $_message ['id'] . '"><i class="fa fa-trash-o"></i> Trash</a></li>							
							</ul>
						</div>							
					</div>
					<!-- /.box-body -->
					</form>
				</div>
			';
		}		
		
		?>
		
			<div class="box box-info">
				<div class="box-header">
					<h3 class="box-title">Inbox</h3>
				</div>
				
				<div class="box-body table-responsive">
					<form method="post">					
					<table id="inbox" class="table table-condensed table-hover table-striped">
						<thead>
							<tr>
								<th style="padding-left: 10px !important;"><input type="checkbox" id="checkall"></th>
								<th>ID</th>
								<th>Subject</th>
								<th>From</th>
								<th>Date</th>
								<th>Action</th>
							</tr>
						</thead>						
						<tbody>
	            		<?php	            			
							$_messages = apply_filters ( 'get_inbox', $_profile['username'], $_conn );
							foreach ( $_messages as $_message ) {
								if ($_message['status'] == 1) {
									$_message ['subject'] = '<b><a href="' . BASE_URL . 'dashboard/messages/inbox/?pa=read&id=' . $_message ['id'] . '" title="' . htmlspecialchars($_message ['subject']) . '">' . $_message ['subject'] . '</a></b>';
									$_id = '<b>' . $_message ['id'] . '</b>';
								} else {
									$_message ['subject'] = '<i><a href="' . BASE_URL . 'dashboard/messages/inbox/?pa=read&id=' . $_message ['id'] . '" title="' . htmlspecialchars($_message ['subject']) . '">' . $_message ['subject'] . '</a></i>';
									$_id = $_message ['id'];
								}
								print '
									<tr class="checkall">
										<td><input type="checkbox" name="dos[]" value="' . $_message ['id'] . '"></td>
										<td>' . $_id . '</td>
										<td>' . $_message ['subject'] . '</td>
										<td>' . $_message ['from'] . '</td>
										<td>' . getTime ( $_message ['date'] ) . '</td>
										<td><a href="' . BASE_URL . 'dashboard/messages/inbox/?pa=reply&id=' . $_message ['id'] . '" title="Reply"><i class="fa fa-mail-reply"></i></a> / <a href="' . BASE_URL . 'dashboard/messages/inbox/?pa=delete&id=' . $_message ['id'] . '" title="Delete"><i class="fa fa-trash-o"></i></a></td>
									</tr>
								';
							}
						?>
	            		</tbody>
					</table>	
            		<table>
            			<tr><td><select name="action"><option value="Read">Read</option><option value="Unread">Unread</option><option value="Delete">Delete</option></select></td><td><input type="submit" value="Submit" class="btn btn-info btn-xs"></td></tr>
					</table>
            		</form>									
				</div>
				<!-- /.box-body -->
			</div>
			
		</div>
	</div>
	<!-- /.row (main row) -->

</section>
<!-- /.content -->