<div class="row" id="maincontent" tabindex="-1">
    <h2><?php echo $browse_agency; ?></h2>
    <ul class="breadcrumbs">
      <li><?php echo anchor('/index','Home'); ?></li> 
      <li><?php echo anchor('index/filter_by_date', 'Search by Date'); ?></li> 
    </ul>
    <div class="row">
        <div class="large-12 columns">
            <div class="byagency module">
                <?php
                if  (empty($error)) {
                    
                    $this->load->view('default/pagination');

                    $current_year = date("Y") + 1;  
                    $results_size = count($document['results']) - 1;
                    
                    echo "<h3>Search by Date</h3>";

                    foreach ($document['results'] as $key => $string ) {                

                        $public_date = DateTime::createFromFormat('Y-m-d', $string['publication_date'])->format("Y");
                        $published_date = DateTime::createFromFormat('Y-m-d', $string['publication_date'])->format("m-d-Y");
                        if ($current_year != $public_date) {
                            if ($key != 0) {
                                echo "</ul>" ;
                            }
                        
                            $current_year = $public_date;
                            echo "<h4>{$current_year}</h4>";
                            echo "<ul>";
                        }   
                    
                        echo "<li><a href=\"{$string['pdf_url']}\">{$published_date} - {$string['type']} - {$string['title']}</a></li>";
                    
                        if ($key == $results_size) {
                            echo "</ul>" ;
                        }               
                 }

            }else{
                echo('<h4 style="color:red">Invalid Search Parameters</h4>');
            }

                $this->load->view('default/pagination'); ?>
            
            </div>
        </div>
    </div>
</div>