<?php
	/*************************************************************************************************************************
	*
    * Free Reprintables Article Directory System
    * Copyright (C) 2014  Glenn Prialde

    * This program is free software: you can redistribute it and/or modify
    * it under the terms of the GNU General Public License as published by
    * the Free Software Foundation, either version 3 of the License, or
    * (at your option) any later version.

    * This program is distributed in the hope that it will be useful,
    * but WITHOUT ANY WARRANTY; without even the implied warranty of
    * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    * GNU General Public License for more details.

    * You should have received a copy of the GNU General Public License
    * along with this program.  If not, see <http://www.gnu.org/licenses/>.
	* 
	* Author: Glenn Prialde
	* Contact: admin@freecontentarticles.com
	* Mobile: +639473473247	
	*
	* Website: http://freereprintables.com 
	* Website: http://www.freecontentarticles.com 
	*
	*************************************************************************************************************************/	
	
	/**
	 * Unzip the source_file in the destination dir
	*
	* @param   string      The path to the ZIP-file.
	* @param   string      The path where the zipfile should be unpacked, if false the directory of the zip-file is used
	* @param   boolean     Indicates if the files will be unpacked in a directory with the name of the zip-file (true) or not (false) (only if the destination directory is set to false!)
	* @param   boolean     Overwrite existing files (true) or not (false)
	*
	* @return  boolean     Succesful or not
	*/
	function unzip($src_file, $dest_dir=false, $create_zip_name_dir=true, $overwrite=true)
	{
		mkdir($dest_dir . '/update/');
		file_put_contents($dest_dir . '/update/update.zip', fopen($src_file, 'r'));
		$src_file = $dest_dir . '/update/update.zip';
		
		if ($zip = zip_open($src_file))
		{
			if ($zip)
			{
				$splitter = ($create_zip_name_dir === true) ? "." : "/";
				if ($dest_dir === false) $dest_dir = substr($src_file, 0, strrpos($src_file, $splitter))."/";
	
				// Create the directories to the destination dir if they don't already exist
				create_dirs($dest_dir);
	
				// For every file in the zip-packet
				while ($zip_entry = zip_read($zip))
				{
					// Now we're going to create the directories in the destination directories
	
					// If the file is not in the root dir
					$pos_last_slash = strrpos(zip_entry_name($zip_entry), "/");
					if ($pos_last_slash !== false)
					{
						// Create the directory where the zip-entry should be saved (with a "/" at the end)
						create_dirs($dest_dir.substr(zip_entry_name($zip_entry), 0, $pos_last_slash+1));
					}
	
					// Open the entry
					if (zip_entry_open($zip,$zip_entry,"r"))
					{
	
						// The name of the file to save on the disk
						$file_name = $dest_dir.zip_entry_name($zip_entry);
	
						// Check if the files should be overwritten or not
						if ($overwrite === true || $overwrite === false && !is_file($file_name))
						{
							// Get the content of the zip entry
							$fstream = zip_entry_read($zip_entry, zip_entry_filesize($zip_entry));
	
							file_put_contents($file_name, $fstream );
							// Set the rights
							chmod($file_name, 0777);
							echo "save: ".$file_name."<br />";
						}
	
						// Close the entry
						zip_entry_close($zip_entry);
					}
				}
				// Close the zip-file
				zip_close($zip);
			}
		}
		else
		{
			return false;
		}
	
		return true;
	}

	/**
	 * This function creates recursive directories if it doesn't already exist
	 *
	 * @param String  The path that should be created
	 *
	 * @return  void
	 */
	function create_dirs($path)
	{
		if (!is_dir($path))
		{
			$directory_path = "";
			$directories = explode("/",$path);
			array_pop($directories);
	
			foreach($directories as $directory)
			{
				$directory_path .= $directory."/";
				if (!is_dir($directory_path))
				{
					mkdir($directory_path);
					chmod($directory_path, 0777);
				}
			}
		}
	}
	
	function get_online_count() {
		$visitors_online = new usersOnline();
		return apply_filters('the_online_users_count', $visitors_online->count_users());
	}

	function get_online_ips() {
		$visitors_online = new usersOnline();
		$_ips = $visitors_online->get_ip_addresses();
		$_res = null;
		foreach($_ips as $_ip) {
			$_res .= '"' . $_ip . '",';
		}
		$_res = trim($_res, ',');
		return $_res;
	}

	function display_penname_form($_conn, $_id = null) {
		
		if ($_id != null) {
			$_penname = apply_filters ( 'get_penname', $_id, $_conn );
			print '
			<form method="post" role="form">
											<div class="form-group">
												<label>Complete Name</label>
												<input type="text" name="name" class="form-control" placeholder="Complete Name ..." value="' . $_penname['name'] . '" />
											</div>
											<div class="form-group">
												<label>Gravatar Email</label>
												<input type="text" name="gravatar" class="form-control" placeholder="Gravatar Email ..." value="' . $_penname['gravatar'] . '" />
											</div>
											<div class="form-group">
												<label>Short Biography</label>
												<textarea name="biography" class="form-control" rows="4" placeholder="Short Biography ...">' . $_penname['biography'] . '</textarea>
											</div>
											<div class="box-footer">
												<button type="submit" name="submit" value="Edit" class="btn btn-primary"><b class="fa fa-font"></b> Edit</button>
												<button type="reset" name="reset" value="Reset" class="btn btn-danger">Reset</button>
											</div>
			</form>
			';		
		} else {
			print '
			<form method="post" role="form">
											<div class="form-group">
												<label>Complete Name</label>
												<input type="text" name="name" class="form-control" placeholder="Complete Name ..." value="" />
											</div>
											<div class="form-group">
												<label>Gravatar Email</label>
												<input type="text" name="gravatar" class="form-control" placeholder="Gravatar Email ..." value="" />
											</div>
											<div class="form-group">
												<label>Short Biography</label>
												<textarea name="biography" class="form-control" rows="4" placeholder="Short Biography ..."></textarea>
											</div>
											<div class="box-footer">
												<button type="submit" name="submit" value="Create" class="btn btn-primary"><b class="fa fa-font"></b> Create</button>
												<button type="reset" name="reset" value="Reset" class="btn btn-danger">Reset</button>
											</div>
			</form>
			';		
		}
			
	}

	function display_submit_form($_username, $_conn) {
		print '
											<form method="post" role="form" parsley-validate>
												<div class="form-group">
													<label>Title</label>
													<input type="text" name="title" class="form-control" placeholder="Title ..." parsley-trigger="change" required />
												</div>
		
												<div class="form-group">
													<label>Author</label>
													<select name="author" class="form-control" parsley-trigger="change" required>
			';
		?>
														<?php
		$_pennames = apply_filters ( 'my_pennames', $_username, $_conn );
		foreach ( $_pennames as $_name ) {
			print '<option value="' . $_name ['name'] . '">' . $_name ['name'] . '</option>';
		}
		?>
	<?

		print '	                                                                                       	                                                
													</select>
												</div>
												
												<div class="form-group">
													<label>Category</label>
													<select name="category" class="form-control" parsley-trigger="change" required>
			';
		?>			
														<?php
		$_categories = apply_filters ( 'the_categories', getCategories ( $_conn ) );
		foreach ( $_categories as $_category ) {
			print '<option value="' . $_category ['category'] . '">' . $_category ['category'] . '</option>';
		}
		?>     
	<?
		print '		                                            	                                       	                                                
													</select>
												</div>	                                        
					 
												<div class="form-group">
													<label>Summary</label>
													<textarea name="summary" class="form-control" rows="4" placeholder="Summary ..." parsley-trigger="change" required></textarea>
												</div>
																						
												<div class="form-group">
													<label>Content</label>
													<textarea id="content" name="content" class="input form-control" rows="10" placeholder="Content ..." parsley-trigger="change" required></textarea>
												</div>
												
												<div class="form-group">
													<label>By-Line</label>
													<textarea name="about" class="form-control" rows="4" placeholder="About the Author By-line ..." parsley-trigger="change" required></textarea>
												</div>	 
												
												<div class="box-footer">
													<div class="btn-group">
			                                            <button type="submit" name="submit" value="submit" class="btn btn-info"><b class="fa fa-pencil-square-o"></b> Submit</button>
			                                            <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown">
			                                                <span class="caret"></span>
			                                                <span class="sr-only">Toggle Dropdown</span>
			                                            </button>
			                                            <ul class="dropdown-menu" role="menu">
			                                                <li><a href="'.BASE_URL.'terms/" target="_new">Terms of Service</a></li>
			                                                <li><a href="'.BASE_URL.'dashboard/">Cancel</a></li>
			                                            </ul>														
			                                        </div>
												</div>	                                                                               
		
											</form>				
			';
	}
?>