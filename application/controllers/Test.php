<?php defined('BASEPATH') OR exit('No direct script access allowed');
	class Simple extends CI_Controller
	{
		private $apiKey = '';

		public function __construct()
		{
			parent::__construct();
			$this->load->model('Simple_m', 'simple');
			$this->load->helper('url');
			$this->load->library(array(
				'officials' => 'offs',
				'legislators' => 'legis',
				'states' => 'states',
				'events' => 'events'
			));
			$this->apiKey = $this->config->item('open_states_api_key');
		}

		public function test() {
			echo "hi";
		}
	}
