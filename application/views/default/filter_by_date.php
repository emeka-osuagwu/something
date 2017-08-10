<?php 
  $attributes = array('id' => 'mysearch','method' => 'GET'); // we need GET 
  echo form_open('index/filter_by_date_paginated', $attributes); 
?>  
    <div class="row" id="maincontent" tabindex="-1">
        <h2>Search By Date</h2>
        <ul class="breadcrumbs">
          <li><?php echo anchor('/index','Home'); ?></li> 
          <li><?php echo ('Search by Date'); ?></li> 
        </ul>
        <div data-alert class="alert-box alert" tabindex="0" aria-live="assertive" role="alertdialog" name="alert_box" id="alert_box" style="display:none">
            <p><span class="columns left" id="date_val" name="date_val"></span></p>
            <a href="#" class="close" aria-label="Close Alert">&times;</a>
        </div>
        <div class="small-6 large-3 columns">
            <label for="date_from" class="left">Start Date (mm/dd/yyyy)</label><br/>
            <input name="date_from" class="left" type="text" autocomplete="off" id="date_from">
        </div>
        <div class="small-6 large-3 columns end">
            <label for="date_to" class="left">End Date (mm/dd/yyyy)</label>
            <input name="date_to" type="text" autocomplete="off" id="date_to">
        </div>
        <div class="small-4 large-2 columns end">
            <label for="results_per_page" class="left">Results per page</label>
            <select name="results_per_page" id="results_per_page">
                <option value="25">25</option>
                <option value="50">50</option>
                <option value="75">75</option>
                <option value="100">100</option>
            </select>
        </div>
        <div class="small-4 large-2 columns end">
            <label for="sorting" class="left">Sorting</label>
            <select name="sorting" id="sorting">
                <option value="newest">Newest</option>
                <option value="oldest">Oldest</option>
            </select>
        </div>

        <input type="hidden" name="page" value="1">
        <input type="hidden" id="date_from_i" name="date_from_i" value="">
        <input type="hidden" id="date_to_i"   name="date_to_i"   value="">

  </div>
  <div class="row">
    <div class="small-6 large-3 columns">
        <button id="submit_data" class="small button" type="submit">Submit</button>
    </div>
  </div>
<?php echo form_close(); ?>

<script src="<?php echo base_url("assets/js/datefilter.js"); ?>"></script>