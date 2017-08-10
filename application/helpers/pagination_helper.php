<?php

function page_range($current_page, $total_pages) {
	$range = 3;
	$page_range = [$current_page - $range, $current_page + $range];
	if ($page_range[0] < 1) $page_range[0] = 1;
	if ($page_range[1] > $total_pages) $page_range[1] = $total_pages;
	return range($page_range[0], $page_range[1]);
}

function get_segments($url) {
	$uri = new CI_URI($url);
	return $uri->segment_array();
}

function get_base_url($url) {
	$segs = get_segments($url);
	if (is_numeric(end($segs))) array_pop($segs);
	return implode('/', $segs);
}

function get_paginated_url($url, $page, $extra_info) {
  $base_url = get_base_url($url);      
  return site_url($url . '?' . $extra_info . $page);        
}    
