<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Index extends CI_Controller
{

	var $data = array();
	var $agency_ids = array('131','404');

	public function __construct() {

		parent::__construct();
		$this->load->helpers(['pagination', 'security']);
		$this->output->cache($this->config->item('cache_timeout'));
		$this->output->set_header('X-FRAME-OPTIONS: DENY');  
		$this->output->set_header('Last-Modified: ' . gmdate('D, j M Y H:i:s') . ' GMT');
		$this->output->set_header('Expires: ' . gmdate('D, j M Y H:i:s', time()) . ' GMT');
		$this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate');
		$this->output->set_header('Cache-Control: post-check=0, pre-check=0');
		$this->output->set_header('Pragma: no-cache');
		$this->output->set_header('Cache-Control: no-cache=Set-Cookie');

		$this->data['title'] = 'U.S. Department of Labor';
		$this->data['subtitle'] = 'Federal Register Documents';
		$this->data['browse_doc'] = 'Browse all documents by:';
		$this->data['browse_agency'] = 'Federal Register Documents';
		$this->data['doc_by_date'] = 'Federal Register Documents by Date';
		$this->data['dol_home'] = $this->config->item('dol_home');
	}

	public function get_articles($id, $type, $page) {
	 	$url = REST_SERVER ."articles?conditions[agency_ids][]={$id}&order=newest&page={$page}";
		return $this->curl_call($url);
  	}

	public function index() {
		$this->load->template('index', $this->data);
	}

	public function agency() {

		$this->data['agency_list'] = $this->get_agencies();

		if(empty($this->data['agency_list'])) {
			return $this->data_error();
		}

		$this->load->template('agency', $this->data);
	}

	public function doc_by_agency($type) {

		$this->data['agency_list'] = $this->get_agencies();

		if(empty($this->data['agency_list'])) {
			return $this->data_error();
		}

		$this->data['doc_type'] = $this->rule_type($type);
		$this->data['rule_type'] = $type;
		$this->load->template('doc_agency', $this->data);
	}

	public function document_list($id) {

		$agency = $this->input->get('agency');
		$page = $this->input->get('page');
		$extra_info = "agency={$agency}&page=";
		
		$this->data['document'] = $this->get_articles();
		
		if(empty($this->data['document'])) {
			return $this->data_error();
		}

		$this->data['pagination'] = $this->get_pagination($page, $this->data['document'], $extra_info);
		$this->data['agency'] = $this->get_agencies($id);
		$this->data['agency_name'] = $agency;
		$this->load->template('document_view', $this->data);
	}

	public function document_type($id, $type) {
		$page = $this->input->get('page');
		$extra_info = 'page=';

		$this->data['document'] = $this->get_articles($id,$type,$page);

		if(empty($this->data['document'])) {
			return $this->data_error();
		}

		$this->data['pagination'] = $this->get_pagination($page, $this->data['document'], $extra_info);
		$this->data['type'] = $type;
		$this->data['agency'] = $this->get_agencies($id);
		$this->data['url'] = $this->doc_type_url($type);
		$this->data['rule_type'] = $this->rule_type($type, true);
		$this->load->template('document_type', $this->data);
	}

	public function filter_by_date() {
		$this->load->template('filter_by_date', $this->data);
	}

	public function filter_by_date_paginated() {
		$date_from = $this->input->get('date_from_i');
		$date_to = $this->input->get('date_to_i');
		$results_per_page = $this->input->get('results_per_page');
		$sorting = $this->input->get('sorting');
		$page = $this->input->get('page');
		$extra_info = "date_from_i={$date_from}&date_to_i={$date_to}&results_per_page={$results_per_page}&sorting={$sorting}&page=";
		$custom_pagination_info = '/' . implode('/' , [$date_from, $date_to, $results_per_page, $sorting]);   
		
		$this->data['document'] = $this->get_articles();
		if(empty($this->data['document'])) {
			return $this->data_error();
		}

		$this->data['custom_pagination_info'] = $custom_pagination_info;
		$this->data['pagination'] = $this->get_pagination($page, $this->data['document'], $extra_info);
		$this->load->template('document_view_paginated', $this->data);
	}

	public function document_by_month() {
		$this->load->template('document_by_month', $this->data);
	}

	public function get_document_year($year) {
		$date_regex = '/^(19|20)\d\d$/';

		if (!preg_match($date_regex, $year)) 
		{
			$this->data['invalid_date'] = 'Invalid year specified';
		} 
		else 
		{
			$this->data['document'] = $this->get_articles();
		}
		
		$this->load->template('get_document_year', $this->data);
	}

	public function get_agencies($id = '') {
		$url = REST_SERVER . 'agencies/' . $id;
		return $this->curl_call($url);
	}

	private function doc_type_url($type) {
		if(empty($type)) {
			show_404();
		}
		return '/index/doc_by_agency/' . $type;
	}

	private function rule_type($type) {
		$types = ['NOTICE' => 'Notices', 'PRORULE' => 'Proposed Rules', 'RULE' => 'Rules'];
		$rule_type = $types[$type];

		if (empty($rule_type)) {
			return show_404();
		}
		return $rule_type;
	}

	private function get_pagination($page, $response, $extra_info = NULL) {
		$pagination = [
			'previous_page' => isset($response['previous_page_url']),
			'next_page' => isset($response['next_page_url']),
			'current_page' => $page,
			'total_pages' => $response['total_pages'],
			'extra_info' => $extra_info,
			'current_url' => $this->uri->uri_string()
		];
		return $pagination;
	}

	private function curl_call($url) {
		try {
			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
			$response = curl_exec($ch);
			curl_close($ch);
		} catch (Exception $e) {
			return false;
		}
		return $this->format_data($response);
	}

	private function format_data($data) {
		return json_decode($data, TRUE);
	}

	private function data_error() {
		echo 'Failed to retrieve data';
		return false;
	}
}
