<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {


	public function __construct()
	{
		parent::__construct();
		$this->load->model('General_Model');
		cekLogin();
	}

	public function index()
	{

		$userData = $this->session->userdata('userData');
		$role = $userData['role_id'];
		$id = $userData['id_user'];
		$data = [
			'title' => 'Dashboard',
		];
		if ($role == 0 || $role == '0') {
			$customer_id = $userData['customer_id'];
			$data['booking'] = $this->db
			->select('transactions.*, customers.name as customer, vespa.name as vespa, workshops.name as workshop')
			->join('vespa', 'vespa.id = transactions.vespa_id')
			->join('customers', 'customers.id = transactions.customer_id')
			->join('workshops', 'workshops.id = transactions.workshop_id')
			->get_where('transactions', ['transactions.deleted_at' => null, 'service_date >=' => date("Y-m-d"), 'customer_id' => $customer_id])->result();
			$this->template->load('templates/cms','cms/dashboard-customer', $data,FALSE);
		}else{
			$this->template->load('templates/cms','cms/dashboard', $data,FALSE);
		}
		
		

		// $test = $this->db->select('COUNT(articles.created_by) as jml, fullname')->join('users', 'users.id_user = articles.created_by')->group_by("id_user")->get_where('articles', ['DAY(created_date)' => date("d")])->result();	
		// $this->template->load('templates/cms', 'cms/dashboard');		
	}


	function getData()
	{
		$year = $this->input->get('y');
		$month = $this->input->get('m');
		// $orderCharts = $this->orderChart();
		$userData = $this->session->userdata('userData');

		$customer = $this->db->get_where('customers', ['deleted_at' => null])->num_rows();
		$booking = $this->db->get_where('transactions', ['deleted_at' => null, 'status' => 'Booked'])->num_rows();
		$ongoing = $this->db->get_where('transactions', ['deleted_at' => null, 'status' => 'In Progress'])->num_rows();
		$cancel = $this->db->get_where('transactions', ['deleted_at' => null, 'status' => 'Canceled'])->num_rows();
		$finish = $this->db->get_where('transactions', ['deleted_at' => null, 'status' => 'Finished'])->num_rows();
		$workshop = $this->db->get_where('workshops', ['deleted_at' => null])->num_rows();
		$vespa = $this->db->get_where('vespa', ['deleted_at' => null])->num_rows();
		$chart = $this->chart();
		$response = [
			'status' => true,
			'data' => [
				'chart' => $chart,
				'customer' => $customer,
				'booking' => $booking,
				'ongoing' => $ongoing,
				'cancel' => $cancel,
				'finish' => $finish,
				'workshop' => $workshop,
				'vespa' => $vespa,
			]
		];

		$this->output->set_output(json_encode($response));
	}


	private function chart()
	{	
		$year = $this->input->get('y');
		$month = $this->input->get('m');
		$jumlah = [];
		$bulan = [];
		$isDate = '';
		$where['YEAR(service_date)'] = $year ? $year : date("Y") ;
		$where['deleted_at'] = null;
		$where['status'] = 'Finished';
		if ($month) {
			$group = "DAY(service_date)"; 
			$day = date("t", strtotime($year.'-'.$month));
			$where['MONTH(service_date)'] = $month;
			for ($i=1; $i <= $day ; $i++) { 
				$where['DAY(service_date)'] = $i;
				$data = $this->db->select('sum(total) as jumlah, sum(repair_service) as repair')->group_by($group)->get_where('transactions', $where)->row_array();
				$jumlah[] = $data ? $data['jumlah']+$data['repair'] : 0 ;
				$bulan[] = $i;
			}
			$isDate = true;
		}else{
			$month = $month ? $month : date("m");
			$group = "MONTH(service_date)"; 
			for ($i=1; $i <= $month ; $i++) { 
				$where['MONTH(service_date)'] = $i;
				$data = $this->db->select('sum(total) as jumlah, sum(repair_service) as repair')->group_by($group)->get_where('transactions', $where)->row_array();
				// var_dump($data);
				$jumlah[] = $data ? $data['jumlah']+$data['repair'] : 0 ;
				$bulan[] = bulan($i);
			}
				// die;
			$isDate = false;
		}

		return $chart = ['jumlah' => $jumlah, 'bulan' => $bulan, 'isDate' => $isDate];


	}

}

/* End of file Dashboard.php */
/* Location: ./application/controllers/cms/Dashboard.php */
