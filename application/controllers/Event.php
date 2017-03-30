<?php defined('BASEPATH') OR exit('No direct script access allowed');

use PoliticsMadeSimple;

class Event extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->helper('url');
		$this->load->model('Simple_m');
	}

	public function index(){
		$this->load->view('stateEvents_v');
		$Events = new PoliticsMadeSimple\Events();
		$data = array(
			'events' =>  $Events
		);
	}
}