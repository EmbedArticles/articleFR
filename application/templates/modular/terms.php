<!DOCTYPE html>
<html lang="en">

<?php get_head($site->title, $site->description, $site->keywords, $site->get_canonical(), $site->base, $site->template); ?>
	
<body>

	<?php include('topbar.php'); ?>

	<div class="container-fluid">
	  
	  <?php include('left.php'); ?>
	  
	  <!--center--> 
	  <div class="col-sm-6">
		<div class="row">
		  <div class="col-xs-12">
		  
		  	<div class="crumbs-wrapper">
		  		<ul class="breadcrumb">
		  			<li><b class="glyphicon glyphicon-home icon"></b><a href="<?=$site->base?>">Home</a></li>
		  			<li><b class="glyphicon glyphicon-folder-open icon"></b><a href="<?=$site->base?>terms/">Terms of Service</a></li>
		  		</ul>
		  	</div>
		  	
			<h2>Site Terms of Service</h2>
			<div>
				<h5><b>
					1. Terms
				</b></h5>

				<hr>
				
				<p>
					By accessing this web site, you are agreeing to be bound by these 
					web site Terms and Conditions of Use, all applicable laws and regulations, 
					and agree that you are responsible for compliance with any applicable local 
					laws. If you do not agree with any of these terms, you are prohibited from 
					using or accessing this site. The materials contained in this web site are 
					protected by applicable copyright and trade mark law.
				</p>

				<hr>
				
				<h5><b>
					2. Use License
				</b></h5>

				<hr>
				
				<ol type="a">
					<li>
						Permission is granted to temporarily download one copy of the materials 
						(information or software) on ArticleFR's web site for personal, 
						non-commercial transitory viewing only. This is the grant of a license, 
						not a transfer of title, and under this license you may not:
						
						<ol type="i">
							<li>modify or copy the materials;</li>
							<li>use the materials for any commercial purpose, or for any non-public display (commercial or non-commercial);</li>
							<li>attempt to decompile or reverse engineer any software contained on ArticleFR's web site;</li>
							<li>remove any copyright or other proprietary notations from the materials; or</li>
						</ol>
					</li>
					<li>
						This license shall automatically terminate if you violate any of these restrictions and may be terminated by ArticleFR at any time. Upon terminating your viewing of these materials or upon the termination of this license, you must destroy any downloaded materials in your possession whether in electronic or printed format.
					</li>
				</ol>

				<hr>
				
				<h5><b>
					3. Disclaimer
				</b></h5>

				<hr>
				
				<ol type="a">
					<li>
						The materials on ArticleFR's web site are provided "as is". ArticleFR makes no warranties, expressed or implied, and hereby disclaims and negates all other warranties, including without limitation, implied warranties or conditions of merchantability, fitness for a particular purpose, or non-infringement of intellectual property or other violation of rights. Further, ArticleFR does not warrant or make any representations concerning the accuracy, likely results, or reliability of the use of the materials on its Internet web site or otherwise relating to such materials or on any sites linked to this site.
					</li>
				</ol>

				<hr>
				
				<h5><b>
					4. Limitations
				</b></h5>

				<hr>
				
				<p>
					In no event shall ArticleFR or its suppliers be liable for any damages (including, without limitation, damages for loss of data or profit, or due to business interruption,) arising out of the use or inability to use the materials on ArticleFR's Internet site, even if ArticleFR or a ArticleFR authorized representative has been notified orally or in writing of the possibility of such damage. Because some jurisdictions do not allow limitations on implied warranties, or limitations of liability for consequential or incidental damages, these limitations may not apply to you.
				</p>
							
				<hr>
				
				<h5><b>
					5. Revisions and Errata
				</b></h5>

				<hr>
				
				<p>
					The materials appearing on ArticleFR's web site could include technical, typographical, or photographic errors. ArticleFR does not warrant that any of the materials on its web site are accurate, complete, or current. ArticleFR may make changes to the materials contained on its web site at any time without notice. ArticleFR does not, however, make any commitment to update the materials.
				</p>

				<hr>
				
				<h5><b>
					6. Links
				</b></h5>

				<hr>
				
				<p>
					ArticleFR reviews all URLs added to its Article Directory. However, ArticleFR does not review the contents of all URLs added to its Web Directory and should therefor be not responsible for the contents of any such linked site. The inclusion of any link does not imply endorsement by ArticleFR of the site. Use of any such linked web site is at the user's own risk.
				</p>

				<hr>
				
				<h5><b>
					7. Site Terms of Use Modifications
				</b></h5>

				<hr>	
				
				<p>
					ArticleFR may revise these terms of use for its web site at any time without notice. By using this web site you are agreeing to be bound by the then current version of these Terms and Conditions of Use.
				</p>			
			</div>
			<div class="pull-right"><span class="label label-default">ArticleFr+</span></div>
		   </div>
		</div>
	  </div><!--/center-->

	  <?php include('right.php'); ?>
	  	  
	</div><!--/container-fluid-->

	<?php include('footer.php'); ?>	
</body>
</html>