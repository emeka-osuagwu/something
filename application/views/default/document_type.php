<div class="row" id="maincontent" tabindex="-1">
	<h2><?php echo $browse_agency; ?></h2>
	<ul class="breadcrumbs">
		<li><?php echo anchor('index', 'Home'); ?></li>
		<li><?php echo anchor($url, $rule_type); ?></li>
		<li class="current"><?php echo anchor($this->security->xss_clean($_SERVER['REQUEST_URI']), $agency['short_name']); ?></li>
	</ul>
	<div class="large-12 columns">
		<?php $this->load->view('default/pagination'); ?>
		<div class="module">
			<?php
			echo "<h3>".$agency['short_name']." ".$rule_type."</h3>";
			$current_year = date("Y") + 1;
			if (!isset($document['results'])) {
				echo "<p class='api-not-found'>No Data Found</p>";
			} else {
				$results_size = count($document['results']) - 1;
				foreach ($document['results'] as $key => $string ) {
					$public_date = DateTime::createFromFormat('Y-m-d', $string['publication_date'])->format("Y");
					$published_date = DateTime::createFromFormat('Y-m-d', $string['publication_date'])->format("m-d-Y");
					if ($current_year != $public_date) {
						if ($key != 0) {
						    echo "</ul>" ;
					    }
						$current_year = $public_date;
						echo "<h4>{$current_year}</h4>";
						echo "<ul>" ;

					}
					echo "<li><a href=\"{$string['pdf_url']}\">{$published_date} - {$string['type']} - {$string['title']} </a></li>";
					if ($key == $results_size) {
					    echo "</ul>" ;
				    }
				}
			} ?>
		</div>
		<?php $this->load->view('default/pagination'); ?>
	</div>
</div>