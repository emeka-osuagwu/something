<div class="row">
	<h2><?php echo $browse_agency; ?></h2>
	<ul class="breadcrumbs">
	  <li><?php echo anchor('index', 'Home'); ?></li> 
	  <li class="current"><?php echo anchor('index/agency', 'Agency'); ?></li>
	</ul>
		<div id="maincontent" tabindex="-1" class="large-12 columns" >
			<div class="module">
				<?php
				usort($agency_list, function($a,$b) {
					return strcasecmp($a['name'],$b['name']);
				});

				echo "<h3>All Federal Register documents from the Labor Department<h3/>";

				echo "<p>";
				echo anchor("index/document_list/271/1?agency=DOL", "U.S. Department of Labor (including multiple agencies)");
				echo "</p>";
				
				foreach ($agency_list as $string)
				{
					$long_name = $string['name'];
					if ($string['parent_id'] == "271")
					{
						$short_name = $string['short_name'];
						// Data owner will be informed of agency misspelling. 
						if($short_name == 'LMSO'){
						  $short_name = 'OLMS';
						}
						elseif ($string['id'] == "134") {
							$short_name = 'ESA';
						}
						echo "<h4>";
						echo anchor("index/document_list/{$string['id']}?agency=$short_name&page=1", "{$long_name}  ({$short_name})"); "</h4>";
						echo '<p>';
						if ($short_name == 'EBSA')
							echo 'The Employee Benefits Security Administration (EBSA) is responsible for administering and enforcing the provisions of Title I of the Employee Retirement Income Security Act of 1974 (ERISA). Until February 2003, EBSA was known as the Pension and Welfare Benefits Administration (PWBA)';
						else
							echo $string['description'];
						echo '</p>';
					}
				}
				?>
			</div>	
		</div>
<!-- End End Blog -->
</div>
<!-- End First row's content  --> 
