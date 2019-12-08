<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	
	public function __construct()
	{
		parent::__construct();
		//Do your magic here
		$this->load->model('crud');
		
	}
	public function dateExplode($var)
	{
		$raw = explode(" ", $var);
		$rawDate = explode("-", $raw[0]);
		$res = array(
			'hour' => substr($raw[1], 0, 5),
			'date' => $rawDate[2],
			'month' => $rawDate[1],
			'year' => $rawDate[0]
		);
		return $res;
	}
	public function index()
	{
		$data['event'] = $this->crud->Get('event');
		$n = 0;
		foreach($data['event'] as $a){
			$data['event'][$n]['startDate'] = $this->dateExplode($a['startDate']);
			$data['event'][$n]['endDate'] = $this->dateExplode($a['endDate']);
			$n++;
		}
		$data['article'] = $this->crud->Get('article');
		$data['slider'] = $this->crud->Get('slider');
		$data['gallery'] = $this->crud->Get('gallery');
		$this->load->view('home', $data);
	}
}
