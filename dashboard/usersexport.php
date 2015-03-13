<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		Users <small>Control panel</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
		<li><a href="#"><i class="fa fa-group"></i> Users</a></li>
		<li class="active"><i class="fa fa-cloud-download"></i> Export</li>
	</ol>
</section>
<!-- Main content -->
<section class="content">
<?php 
	if (isset($_REQUEST['submit']) && $_REQUEST['submit'] == 'Export') {
		if (!is_writable(dirname(__FILE__) . '/export/users/')) {
			print '
			<div class="alert alert-danger alert-dismissable">
				<i class="fa fa-ban"></i>
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
				<b>Alert!</b> Error: Directory ' . dirname(__FILE__) . '/export/users/' . ' is not writable.
			</div>
			';			
		} else {		
			$_users = getUsers($_conn);
			$_data = null;
			$_first = true;
			$_records = array();
			$_record = array();		
			foreach($_users as $_user) {			
				if ($_REQUEST['type'] == 'xml') {				
					if ($_first) {
						$_data = "<articlefr><users>";
						$_first = false;
					} else {
						$_data .= '<user>';
						if ($_REQUEST['username'] == 'u') {
							$_data .= '<username>' . $_user['username'] . '</username>';
						} 
						if ($_REQUEST['name'] == 'n') {
							$_data .= '<name>' . $_user['name'] . '</name>';
						}  
						if ($_REQUEST['email'] == 'e') {
							$_data .= '<email>' . $_user['email'] . '</email>';
						}					
						$_data .= '</user>';
					}				 			
				} else if ($_REQUEST['type'] == 'csv') {
					if ($_REQUEST['username'] == 'u') {
						array_push($_record, $_user['username']);
					}
					if ($_REQUEST['name'] == 'n') {
						array_push($_record, $_user['name']);
					}
					if ($_REQUEST['email'] == 'e') {
						array_push($_record, $_user['email']);
					}
					array_push($_records, $_record);
					$_record = array();
				}
			}
			if ($_REQUEST['type'] == 'xml') {
				$_file = dirname(__FILE__) . '/export/users/' . md5('ArticleFRSalt-GwapoKo12345' . time()) . '.xml';
				$_data .= '</users></articlefr>';
				file_put_contents($_file, $_data, FILE_APPEND | LOCK_EX);
			} else if ($_REQUEST['type'] == 'csv') {
				$_file = dirname(__FILE__) . '/export/users/' . md5('ArticleFRSalt-GwapoKo12345' . time()) . '.csv';
				$fp = fopen($_file, 'w');
				foreach ($_records as $_record) {
					fputcsv($fp, $_record);
				}
				fclose($fp);			
			}
		}
	}
?>
	<!-- Main row -->
	<div class="row">
	    <section class="col-lg-6">                
			<div class="box box-default">			
				<div class="box-header">
					<h3 class="box-title">Export Users</h3>
				</div>		        
				<div class="box-body">
					<form method="post" role="form">
						<div class="form-group">						
							<label>Type</label>
							<p>					
								<input type="radio" name="type" value="xml" class="minimal" /> XML
								<input type="radio" name="type" value="csv" class="minimal" checked/> CSV
							</p>
							<hr>
							<label>Fields</label>
							<p>	
								<input type="checkbox" class="flat-red" name="username" value="u" checked/> Username							
								<input type="checkbox" class="flat-red" name="name" value="n" checked/> Name
								<input type="checkbox" class="flat-red" name="email" value="e" checked/> Email
							</p>							
						</div>			
						<div class="box-footer" style="margin-top: 30px;">
							<button type="submit" name="submit" value="Export"
								class="btn btn-primary"><b class="fa fa-cloud-download"></b> Export</button>
						</div>
					</form>
				</div><!-- /.box-body -->
			</div>
      	</section>
    	<section class="col-lg-6">
			<div class="box box-primary">
				<div class="box-header">
					<h3 class="box-title">File List</h3>
				</div>
				<div class="box-body">
					<table id="articles" class="table table-hover">
						<thead>
							<tr>
								<th>Filename</th>
								<th>Last Modified</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
	            		<?php
	            			$_recordset = getUserExports();
							foreach ( $_recordset as $_record ) {							
								$_date = date ("F d Y H:i:s.", filemtime(dirname(__FILE__) . '/export/users/' . $_record));
								print '
									<tr>
										<td>' . $_record . '</td>
										<td>'  . $_date . '</td>
										<td><a href="' . BASE_URL . 'dashboard/download.php?f=' . $_record . '&e=users" title="Download"><i class="fa fa-download"></i></a></td>
									</tr>
								';
							}
						?>
	            	</tbody>
					</table>
				</div>
				<!-- /.box-body -->
			</div>
		</section>                    
	</div>
	<!-- /.row (main row) -->
</section>
<!-- /.content -->