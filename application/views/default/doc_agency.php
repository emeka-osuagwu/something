<!-- Start First rows content  -->
<!-- Start Blog -->
<div class="row" id ="maincontent" tabindex="-1">
	<h2>
		<?php echo $browse_agency ." - ". $doc_type; ?>
	</h2>
		<ul class="breadcrumbs">
            <li><?php echo anchor('index', 'Home'); ?></li> 
            <li class="current"><?php echo anchor('index/doc_by_agency/NOTICE', $doc_type); ?></li>
		</ul>
		<div class="large-12 columns">
			<div class="module">

			<?php
				echo "<h3>".anchor("index/document_type/271/{$rule_type}", "U.S. Department of Labor (including multiple agencies)") . "</h3>";
				echo "<ul id='ulAgencyList'>";
				
				usort($agency_list, function($a,$b) {
					return strcasecmp($a['name'],$b['name']);
				});
				
				foreach ($agency_list as $string)
				{
					if ($string['parent_id'] == "271")
					{
						$short_name = $string['short_name'];
						$name= $string ['name'];

						// Data owner will be informed of agency misspelling. 
						if($short_name == 'LMSO'){
						  $short_name = 'OLMS';
						}
						elseif ($string['id'] == "134") {
							$short_name = 'ESA';
						}
						echo "<li>".anchor("index/document_type/{$string['id']}/{$rule_type}?page=1", "{$name} ({$short_name})"). "</li>";
						
					}

				}
				echo "</ul></p>";

				?>
				
			</div>	
		</div>
<!-- End End Blog -->
</div>
<!-- End First row's content  --> 
