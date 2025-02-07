<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Booking extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Datatable_Model');
		$this->load->model('General_Model');
		cekLogin();
	}

	public function index()
	{

		if ($this->uri->segment(1) == 'booking-now') {
			redirect('cms/data-booking/create','refresh');
		}
		$data = [
			'title' => 'Data Pemesanan',
		];

		// var_dump(encrypt_decrypt('encrypt', 'toQmADHYFrW3Qugj2Nw7JUzwV42Dci'));die;

		$this->template->load('templates/cms', 'cms/booking/index',$data, FALSE);
	}


	function getData()
	{
		if ($this->input->is_ajax_request()) {
			$color = [
			    'Booked' => 'info',
			    'In Progress' => 'primary',
			    'Finished' => 'success',
			    'Canceled' => 'danger'
			];
			$userData = $this->session->userdata('userData');
			$column_order = [null, 'transaction_code' ,'customers.name', 'workshops.name', 'concern','service_date', 'work_estimate', 'start_time', 'finish_time', 'transactions.status'];
			$column_search = ['transaction_code','customers.name', 'workshops.name', 'concern','service_date', 'work_estimate', 'start_time', 'finish_time', 'transactions.status'];
			$where = ['transactions.deleted_at' => null, 'transactions.status !=' => 'Finished', 'service_date >=' => date('Y-m-d')];
			if (isset($userData['customer_id'])) {
				$where['customer_id'] = $userData['customer_id'];
			}

			$date = $this->input->post('date');
			if ($date) {
				$where['service_date'] = $date;
			}

			$order = ['service_date' => 'ASC', 'service_time' => 'ASC'];
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
			$where = ['transactions.deleted_at' => null, 'transactions.status !=' => 'Finished', 'service_date <' => date('Y-m-d')];
			if (isset($userData['customer_id'])) {
				$where['customer_id'] = $userData['customer_id'];
			}
			$order = ['service_date' => 'ASC', 'service_time' => 'ASC'];
			$query1 = [
				'table' => 'transactions',
				'select' => 'transactions.*, customers.name as customer, workshops.name as workshop',
				'where' => $where,
				'join' => [
					['customers', 'customers.id = transactions.customer_id', 'inner'],
					['workshops', 'workshops.id = transactions.workshop_id', 'inner'],
				]
			];
			$transactionsExp = $this->Datatable_Model->getDataTables($query1, $column_order, $column_search, $order);
			$transactions = array_merge($transactions, $transactionsExp);
			// var_dump($transactions);die;
			// var_dump($this->db->last_query());die;
			$data = [];
			$no = @$_POST['start'];
			foreach ($transactions as $trans) {
				$no++;
				$row = [];
				$row[] = $no . ".";
				$row[] = $trans->transaction_code;
				$row[] = $trans->customer;
				$row[] = $trans->workshop;
				 $keluhan = '';
				    if($trans->is_general_check && $trans->concern)
				    {
				        $keluhan = '<b>General Check,</b> <br>'.$trans->concern; 
				    }else{
				        $keluhan .= $trans->is_general_check ? "<b>General Check</b>" : '';
				        $keluhan .= $trans->concern ? $trans->concern : '';
				        
				    }
				    $row[] = $keluhan;
				$row[] = date('D, d-m-Y', strtotime($trans->service_date)).' <br> '.date('H:i', strtotime($trans->service_time));
				$row[] = $trans->work_estimate ? $trans->work_estimate.' Menit' : '';
				$row[] = $trans->start_time;
				$notes = '';
				if ($trans->service_date < date('Y-m-d')) {
					$notes = '<br> <button type="badge" class="badge badge-warning badge-sm" title="Expired Booking">Sudah Melewati Waktu Booking</button>';
				}
				// $row[] = $trans->finish_time;
				$row[] = '<button type="badge" class="badge badge-'.$color[$trans->status].' badge-sm" title="Ubah Data">'.$trans->status.'</button>'.$notes;

				$action = '<a href="'.base_url('cms/data-booking/edit/').encrypt_decrypt('encrypt', $trans->id).'" title="Ubah Data"  class="btn btn-warning shadow btn-sm sharp"><span class="fa fa-edit"></span></a>';
				if (!isset($this->session->userdata('userData')['customer_id'])) {
					if ($trans->start_time == '') {
						$action .= '<a type="button" title="Mulai Pengerjaan" data-type="start" onclick="startStop(this)" id="'.encrypt_decrypt('encrypt', $trans->id).'"  class="btn btn-info shadow btn-sm sharp"><span class="fa fa-play"></span></a>';
						// $action .= '<a href="'.base_url('cms/data-booking/start/').encrypt_decrypt('encrypt', $trans->id).'" title="Mulai Pengerjaan"  class="btn btn-info shadow btn-sm sharp"><span class="fa fa-play"></span></a>';
					}else if ($trans->finish_time == '') {
						$action .= '<a type="button" title="Selesai Pengerjaan" data-type="stop" onclick="startStop(this)" id="'.encrypt_decrypt('encrypt', $trans->id).'"  class="btn btn-info shadow btn-sm sharp"><span class="fa fa-stop"></span></a>';
						// $action .= '<a href="'.base_url('cms/data-booking/stop/').encrypt_decrypt('encrypt', $trans->id).'" title="Selesai Pengerjaan" class="btn btn-info shadow btn-sm sharp"><span class="fa fa-stop"></span></a>';
					}
				}

	               $action .= '<a href="#" type="button" id="btn-delete-' . $trans->id . '" title="Hapus Data" onclick="ButtonDelete(' . "'" . encrypt_decrypt('encrypt',$trans->id) . "'" . ')" class="btn btn-danger shadow btn-sm sharp"><span class="fa fa-trash"></span></a>';
				$row[] = $action;
				$data[] = $row;
			}
			$output = [
				'draw' => @$_POST['draw'],
				'recordsTotal' => $this->Datatable_Model->countAll($query)+$this->Datatable_Model->countAll($query1),
				'recordsFiltered' => $this->Datatable_Model->countFilters($query, $column_order, $column_search, $order)+$this->Datatable_Model->countFilters($query1, $column_order, $column_search, $order),
				'data' => $data,
			];


			$this->output->set_output(json_encode($output));
		} else {
			exit('Proses Tidak Dapat Dilanjutkan');
		}
	}



	function create()
	{
		$data = [
			'title' => 'Buat Pemesanan',
		];
		$workshop_id = $this->session->userdata('workshop_id');
		$where = [];
		// $data['workshops']
		$data['workshop'] = $this->db->get_where('workshops', ['id' => $workshop_id])->row();

		$data['workshops'] =  $this->db->get_where('workshops', ['deleted_at' => null])->result();
		$data['vespa'] =  $this->db->get_where('vespa', ['deleted_at' => null])->result();

		if ($this->session->userdata('userData')['role_id'] != 0) {
			$data['customers'] = $this->db->get_where('customers', ['deleted_at' => null])->result();
		}

		$this->template->load('templates/cms', 'cms/booking/create',$data, FALSE);
	}


	function store()
	{
		$request = $this->input->post();
		$role_id = $this->session->userdata('userData')['role_id'];
		if ($role_id != 0) {
			$this->form_validation->set_rules('customer_id', 'pelanggan', 'trim|required');
		}else{
			$customer_id = $this->session->userdata('userData')['customer_id'];
		}
		// $this->form_validation->set_rules('service_date', 'tanggal servis', 'trim|required');
		// $this->form_validation->set_rules('service_time', 'waktu servis', 'trim|required');
		$this->form_validation->set_rules('service_date', 'tanggal servis', 'trim|required');
		$this->form_validation->set_rules('service_time', 'waktu servis', 'trim|required');
		isset($request['is_general_check']) ? '' : $this->form_validation->set_rules('concern', 'keluhan', 'trim|required');
		$this->form_validation->set_rules('workshop', 'bengkel', 'trim|required');
		$this->form_validation->set_error_delimiters('', '');

		if ($this->form_validation->run()) {
			$transaction = $this->db->order_by('service_time', 'desc')->get_where('transactions', ['service_date' => $request['service_date']])->row();
	        if ($transaction) {
	            $transaction_code = buatkode($transaction->transaction_code, date("Ymd") . '-', 5);
	            $addTime = $transaction->work_estimate ? $transaction->work_estimate : '60';
				$service_time = date('H:i:s', strtotime('+'.$addTime.' minutes', strtotime($transaction->service_time)));
	        } else {
	            $transaction_code = buatkode('', date("Ymd") . '-', 5);
				$service_time = $request['service_time'];
	        }


			$data = [
				'customer_id' 		=> $role_id == 0 ? $customer_id : $request['customer_id'],
				'transaction_code' 	=> $transaction_code, 
				'workshop_id' 		=> $request['workshop_id'], 
				'vespa_id' 			=> $request['vespa_id'], 
				'service_date' 		=> $request['service_date'], 
				'service_time' 		=> $service_time, 
				'user_lat' 			=> $request['user_lat'], 
				'user_long' 		=> $request['user_long'], 
				'concern' 			=> $request['concern'], 
				'is_general_check' 	=> isset($request['is_general_check']) ? 1 : 0, 

			];
			$this->db->insert('transactions', $data);

			$this->session->unset_userdata('workshop_id');
			$this->session->unset_userdata('redirect');
			$response['status'] = true;
			$response['alert'] = 'berhasil membuat jadwal booking pada '.$request['service_date'].' '.$service_time;
		} else {
			$response['status'] = false;
			$response['alert'] = 'gagal membuat jadwal booking';
		}
		$response['error'] = getErrorValidation();

		echo json_encode($response);
	}

	function edit($id)
	{
		$id = encrypt_decrypt('decrypt', $id);
		$data = [
			'title' => 'Ubah Data Pemesanan',
		];
		$transaction = $this->db->get_where('transactions', ['id' => $id])->row();
		$data['workshop'] = $this->db->get_where('workshops', ['id' => $transaction->workshop_id])->row();

		$data['workshops'] =  $this->db->get_where('workshops', ['deleted_at' => null])->result();
		$data['transaction'] =  $transaction;
		$data['vespa'] =  $this->db->get_where('vespa', ['deleted_at' => null])->result();


		if ($this->session->userdata('userData')['role_id'] != 0) {
			$data['customers'] = $this->db->get_where('customers', ['deleted_at' => null])->result();
			$data['spareparts'] = $this->db->get_where('spareparts', ['deleted_at' => null])->result();
			$data['detail'] = json_encode($this->db->get_where('detail_transaction', ['transaction_id' => $id])->result());

		}

		$this->template->load('templates/cms', 'cms/booking/edit',$data, FALSE);
	}

	function update()
	{
		$request = $this->input->post();
		// var_dump($request);die;
		$role_id = $this->session->userdata('userData')['role_id'];
		if ($role_id != 0) {
			$this->form_validation->set_rules('customer_id', 'pelanggan', 'trim|required');
			$this->form_validation->set_rules('work_estimate', 'Estimasi Pengerjaan', 'trim|required|numeric');
		}else{
			$customer_id = $this->session->userdata('userData')['customer_id'];
		}
		$this->form_validation->set_rules('service_date', 'tanggal servis', 'trim|required');
		$this->form_validation->set_rules('service_time', 'waktu servis', 'trim|required');
		isset($request['is_general_check']) ? '' : $this->form_validation->set_rules('concern', 'keluhan', 'trim|required')  ;
		$this->form_validation->set_rules('workshop', 'bengkel', 'trim|required');
		$this->form_validation->set_error_delimiters('', '');

		if ($this->form_validation->run()) {
			$id = encrypt_decrypt('decrypt',$request['id']);
			$customer = $this->db->join('customers', 'customers.id = transactions.customer_id')->get_where('transactions', ['transactions.id' => $id])->row();
			$transaction = $this->db->order_by('service_time', 'desc')->get_where('transactions', ['service_date' => $request['service_date'], 'id !=' => $id ])->row();
			// var_dump($transaction);die;
	        if ($transaction) {
	        	if ($transaction->service_time != $request['service_time']) {
		            $addTime = $transaction->work_estimate ? $transaction->work_estimate : '60';
					$service_time = date('H:i:s', strtotime('+'.$addTime.' minutes', strtotime($transaction->service_time)));
	        	}else{
	        		$service_time = $transaction->service_time;
	        	}
	        } else {
				$service_time = $request['service_time'];
	        }

	        $this->db->trans_begin();
	        $data = [
	        	'customer_id' 		=> $role_id == 0 ? $customer_id : $request['customer_id'],
	        	'workshop_id' 		=> $request['workshop_id'], 
	        	'service_date' 		=> $request['service_date'], 
	        	'service_time' 		=> $service_time, 
	        	'concern' 			=> $request['concern'], 
				'is_general_check' 	=> isset($request['is_general_check']) ? 1 : 0, 
	        	'vespa_id' 			=> $request['vespa_id'], 
	        ];
	        if ($role_id != 0) {
	        	$data['work_estimate'] = $request['work_estimate'];
	        	$data['repair_service'] = $request['repair_service'];
	        	$workshop = $this->db->get_where('workshops', ['id' => $request['workshop_id']])->row_array();

	        	$msg = 'Halo '.$customer->name.', booking Bengkel Bintang Vespa Anda sudah dikonfirmasi untuk 
	        	*Tanggal*	: '.dateIndonesia($request['service_date']).'
	        	*Pukul*		: '.$service_time.'.
	        	*Bengkel*	: '.$workshop['name'].'
	        	*Maps*		: '.$workshop['link'].'
Terima kasih telah mempercayai layanan kami. Silakan datang tepat waktu dan jangan ragu untuk menghubungi kami jika ada pertanyaan. Terima kasih.

Salam,
Bengkel Bintang Vespa';
// var_dump($msg);die;	
				if ($request['send_notif'] == 0) {
		        	$res = __sendWa($customer->phone,$msg);
		        	// var_dump($res);die;
					if ($res['status']) {
						$data['send_notif'] = 1;
					}
				}

	        	// var_dump($res);
	        	$datadetail = [];

	        	if (isset($request['sparepart_id'])) {
	        		$total = 0;
	        		for ($i = 0; $i < count($request['sparepart_id']) ; ++$i) {
	        			$total += $request['qty'][$i]*$request['price'][$i];
	        			$datadetail = [
	        				'transaction_id' => $id,
	        				'sparepart_id' => $request['sparepart_id'][$i],
	        				'qty' => $request['qty'][$i],
	        				'price' => $request['price'][$i],
	        			];
	        			$cek = $this->db->get_where('detail_transaction', [
	        				'transaction_id'	=> $id,
	        				'sparepart_id' 		=> $request['sparepart_id'][$i],
	        			])->row();
	        			if (!$cek) {
		        			$this->db->insert('detail_transaction', $datadetail);
							$this->db->set('stock', 'stock - '.$request['qty'][$i], FALSE)->where('id', $request['sparepart_id'][$i])->update('spareparts');
	        			}

	        		}

	        		$data['total'] = $total;
	        	}
	        }
	        $this->db->update('transactions', $data, ['id' => $id]);

	        $this->session->unset_userdata('workshop_id');
	        $this->session->unset_userdata('redirect');
	        if ($this->db->trans_status() === FALSE)
	        {
	                $this->db->trans_rollback();
	        }
	        else
	        {
	                $this->db->trans_commit();
	        }
			
			$response['status'] = true;
			$response['alert'] = 'berhasil mengubah jadwal booking';
		} else {
			$response['status'] = false;
			$response['alert'] = 'gagal mengubah jadwal booking';
		}
		$response['error'] = getErrorValidation();
		// var_dump($response);die;
		echo json_encode($response);
	}

	function destroy($id)
	{
		if ($this->input->is_ajax_request()) {
			$this->db->update('transactions', ['deleted_at' => date('Y-m-d H:i:s'), 'transaction_code' => ''], ['id' => encrypt_decrypt("decrypt",$id)]);
			// softDelete('transactions', ['id' => encrypt_decrypt("decrypt",$id)]);
			$response = [
				'status' => true,
				'alert' => 'Successfully deleted data'
			];
			$this->output->set_output(json_encode($response));

		}else{
			exit('access denied');
		}
	}

	function start($id)
	{
		$id = encrypt_decrypt('decrypt', $id);
		$cek = $this->db->get_where('transactions', ['id' => $id])->row();
		$customer = $this->db->get_where('customers', ['id' => $cek->customer_id])->row();

		if (!$cek->work_estimate) {
			$response = ['status' => false, 'msg' => 'Silahkan Isi Estimasi Pengerjaan Terlebih Dahulu'];
		}else{
			$this->db->update('transactions', ['start_time' => date('Y-m-d H:i:s'), 'status' => 'In Progress'], ['id' => $id]);	
			$msg = 'Halo '.$customer->name.', Kendaraan anda sedang dalam pengerjaan, estimasi pengerjaan *'.$cek->work_estimate.'* Menit.

Salam,
Bengkel Bintang Vespa';
			__sendWa($customer->phone,$msg);
			$response = ['status' => true, 'msg' => 'Pengerjaan Dimulai pada '. date('Y-m-d H:i:s')];
		}
		echo json_encode($response);
	}

	function stop($id)
	{
		$id = encrypt_decrypt('decrypt', $id);
		$transaction = $this->db->get_where('transactions', ['id' => $id])->row();
		$customer = $this->db->get_where('customers', ['id' => $transaction->customer_id])->row();
		$detail = $this->db->select('detail_transaction.*, spareparts.name')->join('spareparts', 'spareparts.id = detail_transaction.sparepart_id')->get_where('detail_transaction', ['transaction_id' => $id])->result();
		$this->db->update('transactions', ['finish_time' => date('Y-m-d H:i:s'), 'status' => 'Finished'], ['id' => $id]);	
		$msg = 'Halo '.$customer->name.', Kendaraan anda telah selesai perbaikan.

		';
		foreach ($detail as $value) {
		// var_dump($value->price);die;
$msg .= '
*'.$value->name.'*	:		x'.$value->qty.'		Rp. '.number_format($value->price,0,',','.');
		}
$msg .= '
*Jasa*	:											Rp. '.number_format($transaction->repair_service,0,',','.');
$msg .= '
==============================================================';
$msg .= '
*Total*	:											Rp. '.number_format($transaction->total+$transaction->repair_service,0,',','.');



$msg .= '
Salam,
Bengkel Bintang Vespa';
// var_dump($msg);die;
		__sendWa($customer->phone,$msg);
		$response = ['status' => true, 'msg' => 'Pengerjaan Selesai pada '. date('Y-m-d H:i:s')];
		echo json_encode($response);
	}


	function check_date_time()
	{
		$request = $this->input->post();
		$date = $request['service_date'];
		$time = $request['service_time'];
		$date_now = date("Y-m-d");
		$time_now = date("H:i:s");
		$is_valid = true;
		if ($date > $date_now) {
			$is_valid = false;
		}else{
			if ($time > $date_now) {
				$is_valid = false;
			}
		}
		if (!$is_valid)
	        {
	                $this->form_validation->set_message('check_date_time', 'Tanggal dan waktu tidak valid');
	                return FALSE;
	        }
	        else
	        {
	                return TRUE;
	        }
	}
}

/* End of file Booking.php */
/* Location: ./application/controllers/cms/Booking.php */ ?>
