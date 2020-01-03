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
		$this->load->library('pagination');
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
	public function pagination($table, $limit, $link)
	{
        $data['val'] = $this->crud->Get($table);
        $total = count($data['val']);
        $config = array();
        $config['use_page_numbers'] = TRUE; // Use pagination number for anchor URL.
        $config['num_links'] =  $total;//Set that how many number of pages you want to view.
        $config['cur_tag_open'] = '<a class="current">'; // Open tag for CURRENT link.
        $config['cur_tag_close'] = '</a>'; // Close tag for CURRENT link.
        $config['next_link'] = 'Next'; // By clicking on performing NEXT pagination.
        $config['prev_link'] = 'Previous'; // By clicking on performing PREVIOUS pagination.
        $config['base_url'] = base_url($link);
        $config['total_rows'] = $total;
        $config['per_page'] = $limit;
        $config['first_url'] = base_url($link.'/1'); 
        $from = $this->uri->segment(2);
        $this->pagination->initialize($config);
        if (empty($from)) {
            $from = 1;
        }
        $subData[$table] = $this->crud->dataSort($table, $config['per_page'], $from, 'id', 'DESC');
        $str_links = $this->pagination->create_links();
		$subData["links"] = explode('&nbsp;',$str_links );
		return $subData;
	}
	public function index()
	{
		$data['navbar'] = $this->load->view('components/comp-navbar', '', TRUE);
		$data['footer'] = $this->load->view('components/comp-footer', '', TRUE);
		$data['head'] = $this->load->view('components/comp-head', '', TRUE);
		$data['svg'] = $this->load->view('components/comp-svg', '', TRUE);
		
		$data['popup'] = $this->crud->GetWhere('article', array('popup'=>true));
		$data['event'] = $this->crud->GetOrderLimit('event', 'id', 'DESC', 5);
		$n = 0;
		foreach($data['event'] as $a){
			$data['event'][$n]['startDate'] = $this->dateExplode($a['startDate']);
			$data['event'][$n]['endDate'] = $this->dateExplode($a['endDate']);
			$n++;
		}
		$data['headmaster'] = $this->crud->GetWhere('structure', array('position'=>'kepala sekolah'));
		$data['speech'] = $this->crud->Get('speech');
		$data['testi'] = $this->crud->Get('testi');
		$data['article'] = $this->crud->GetOrderLimit('article', 'id', 'DESC', 5);
		$data['slider'] = $this->crud->GetOrderLimit('slider', 'id', 'DESC', 5);
		$data['gallery'] = $this->crud->Get('gallery');
		$this->load->view('home', $data);
	}

	public function homePage($link = null)
	{
		$this->load->library('pagination');
		$type = $this->uri->segment(1);
		$page = $this->uri->segment(1);

		// side-bar content
		$data['event'] = $this->crud->GetOrderLimit('event', 'id', 'DESC', 5);
		$data['article'] = $this->crud->GetOrderLimit('article', 'id', 'DESC', 5);

		// component
		$data['navbar'] = $this->load->view('components/comp-navbar', '', TRUE);
		$data['footer'] = $this->load->view('components/comp-footer', '', TRUE);
		$data['head'] = $this->load->view('components/comp-head', '', TRUE);
		$data['svg'] = $this->load->view('components/comp-svg', '', TRUE);

		$config = array();

		if(isset($link) && is_numeric($link) != 1){
			$subData['content'] = $this->crud->GetWhere($type, array('link'=>$link));
			$page = 'view-article';
		}else{

			// page article
			if($type == 'article'){
				$subData = $this->pagination('article', 15, 'article');
			}
			// page event
			elseif($type == 'event'){
				$subData = $this->pagination('event', 15, 'event');
				$n = 0;
				foreach($subData['event'] as $a){
					$subData['event'][$n]['startDate'] = $this->dateExplode($a['startDate']);
					$subData['event'][$n]['endDate'] = $this->dateExplode($a['endDate']);
					$n++;
				}
			}
			// page gallery
			elseif($type == 'gallery'){
				$subData = $this->pagination('gallery', 20, 'gallery');
			}
			elseif($type == 'ppdb'){
				$subData = 'null';
			}
			// page alumni
			elseif($type == 'alumni'){
				$subData = $this->pagination('testi', 5, 'alumni');
			}
		}
		$data['page'] = $this->load->view('page/'.$page, $subData, TRUE);
		$this->load->view('page', $data);
	}
}