<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	private $where = ['status' => "Aktif", 'deleted_at' => null];
	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		// __sendWa('a','a');
		$data['title'] = "Home";
		loadView('templates/landing', 'landing/home', $data);
	}

	function booking()
	{
		$id = $this->input->get('id');
		// var_dump($id);die;
		$this->session->userdata('redirect', base_url('booking-now').$id);
		if ($this->session->userdata('userData')) {
			redirect($this->session->userdata('redirect'));
		}
		$data = ['title' => 'Halaman Pendaftaran'];
		loadView('templates/landing', 'landing/booking', $data);
	}

	function  getWorkshop()
	{
		$worhshop = $this->db->get_where('workshops', ['deleted_at' => null])->result();
		echo json_encode($worhshop);
	}

}

/* End of file Home.php */
/* Location: ./application/controllers/Home.php */