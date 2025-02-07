<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Transactions extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Datatable_Model');
		$this->load->model('General_Model');
		cekLogin();
	}

	public function index()
	{

		$data = [
			'title' => 'Riwayat Servis',
		];

		$this->template->load('templates/cms', 'cms/transactions/index',$data, FALSE);
	}


	function getData()
	{
		if ($this->input->is_ajax_request()) {
			$this->load->library('datetime');
			$userData = $this->session->userdata('userData');
			$column_order = [null, 'customers.name', 'workshops.name', 'concern','service_date', 'work_estimate', 'start_time', 'finish_time', 'transactions.status'];
			$column_search = ['customers.name', 'workshops.name', 'concern','service_date', 'work_estimate', 'start_time', 'finish_time', 'transactions.status'];
			$where = ['transactions.deleted_at' => null, 'transactions.status' => 'Finished'];
			if (isset($userData['customer_id'])) {
				$where['customer_id'] = $userData['customer_id'];
			}
			$date = $this->input->post('date');
			if ($date) {
				$where['service_date'] = $date;
			}
			$order = ['id' => 'ASC'];
			$query = [
				'table' => 'transactions',
				'select' => 'transactions.*, customers.name as customer, workshops.name as workshop',
				'where' => $where,
				'join' => [
					['customers', 'customers.id = transactions.customer_id', 'inner'],
					['workshops', 'workshops.id = transactions.workshop_id', 'inner'],
				]
			];
			// var_dump($this->input->post('tipe'));
			$transactions = $this->Datatable_Model->getDataTables($query, $column_order, $column_search, $order);
			// var_dump($this->db->last_query());die;
			$data = [];
			$no = @$_POST['start'];
			foreach ($transactions as $trans) {
				$no++;
				$row = [];
				$row[] = $no . ".";
				$row[] = $trans->customer;
				$row[] = $trans->workshop;
				$row[] = $trans->concern;
				$row[] = date('D, d-m-Y', strtotime($trans->service_date)).' <br> '.date('H:i', strtotime($trans->service_time));
				$row[] = $trans->work_estimate ? $trans->work_estimate.' Menit' : '';
				$row[] = $trans->start_time;
				$row[] = $trans->finish_time;
				$actual_work = '';
				if ($trans->start_time && $trans->finish_time) {
					$start_time = new DateTime($trans->start_time);
					$finish_time = new DateTime($trans->finish_time);
					$interval = $start_time->diff($finish_time);
					$actual_work = $interval->format('%H:%I:%S');
				}
				$row[] = $actual_work;
				$row[] = '<button type="badge" class="badge badge-success badge-sm" title="Ubah Data">'.$trans->status.'</button>';

				$action = '<a href="'.base_url('cms/data-history/detail/').encrypt_decrypt('encrypt', $trans->id).'" title="Detail Transaksi"  class="btn btn-info shadow btn-sm sharp"><span class="fa fa-eye"></span></a>';
				// if (!isset($this->session->userdata('userData')['customer_id'])) {
				// 	if ($trans->start_time == '') {
				// 		$action .= '<a href="'.base_url('cms/data-booking/start/').encrypt_decrypt('encrypt', $trans->id).'"  class="btn btn-info shadow btn-sm sharp"><span class="fa fa-play"></span></a>';
				// 	}else if ($trans->finish_time == '') {
				// 		$action .= '<a href="'.base_url('cms/data-booking/stop/').encrypt_decrypt('encrypt', $trans->id).'"  class="btn btn-info shadow btn-sm sharp"><span class="fa fa-stop"></span></a>';
				// 	}
				// }

	            //    $action .= '<a href="#" type="button" id="btn-delete-' . $trans->id . '" title="Hapus Data" onclick="ButtonDelete(' . "'" . encrypt_decrypt('encrypt',$trans->id) . "'" . ')" class="btn btn-danger shadow btn-sm sharp"><span class="fa fa-trash"></span></a>';
				$row[] = $action;
				$data[] = $row;
			}
			$output = [
				'draw' => @$_POST['draw'],
				'recordsTotal' => $this->Datatable_Model->countAll($query),
				'recordsFiltered' => $this->Datatable_Model->countFilters($query, $column_order, $column_search, $order),
				'data' => $data,
			];


			$this->output->set_output(json_encode($output));
		} else {
			exit('Proses Tidak Dapat Dilanjutkan');
		}
	}


	function detail($id)
	{
		$id = encrypt_decrypt('decrypt', $id);
		$transaction = $this->db->get_where('transactions', ['id' => $id])->row();
		$customer = $this->db->get_where('customers', ['id' => $transaction->customer_id])->row();
		$workshop = $this->db->get_where('workshops', ['id' => $transaction->workshop_id])->row();
		$vespa = $this->db->get_where('vespa', ['id' => $transaction->vespa_id])->row();
		$detail = $this->db->select('detail_transaction.*, spareparts.name')->join('spareparts', 'spareparts.id = detail_transaction.sparepart_id')->get_where('detail_transaction', ['transaction_id' => $transaction->id])->result();
		$data = [
			'title' => 'Detail Servis',
			'transaction' => $transaction,
			'customer' => $customer,
			'workshop' => $workshop,
			'vespa' => $vespa,
			'detail' => $detail,
		];

		$this->template->load('templates/cms', 'cms/transactions/detail',$data, FALSE);
	}
	function cetak($id)
	{
		$id = encrypt_decrypt('decrypt', $id);
		$transaction = $this->db->get_where('transactions', ['id' => $id])->row();
		$customer = $this->db->get_where('customers', ['id' => $transaction->customer_id])->row();
		$workshop = $this->db->get_where('workshops', ['id' => $transaction->workshop_id])->row();
		$vespa = $this->db->get_where('vespa', ['id' => $transaction->vespa_id])->row();
		$detail = $this->db->select('detail_transaction.*, spareparts.name')->join('spareparts', 'spareparts.id = detail_transaction.sparepart_id')->get_where('detail_transaction', ['transaction_id' => $transaction->id])->result();
		$data = [
			'title' => $transaction->transaction_code,
			'transaction' => $transaction,
			'customer' => $customer,
			'workshop' => $workshop,
			'vespa' => $vespa,
			'detail' => $detail,
			'web' => $this->db->get('setting')->row()
			
		];

		$this->load->library('Pdf');
		$html = $this->load->view('templates/transaction-pdf', $data, true);
		$this->pdf->createPDF($html, $data['title'], FALSE, 'A4', 'potrait');
	}
}


/* End of file Transactions.php */
/* Location: ./application/controllers/cms/Transactions.php */ ?>