 <?php
 defined('BASEPATH') OR exit('No direct script access allowed');
 
 class Customers extends CI_Controller {
 
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
			'title' => 'List Pelanggan'
		];	

		$this->template->load('templates/cms', 'cms/customers',$data, FALSE);
	}


		function getDataById($id)
		{
			if ($this->input->is_ajax_request()) {
				$response = [
					'sukses' => true,
					'data' => $this->General_Model->get("customers",["id" => encrypt_decrypt("decrypt",$id)])->row_array()
				];
				$this->output->set_output(json_encode($response));
			} else {
				exit('Proses Tidak Dapat Dilanjutkan');
			}
		}

		function getData()
		{
			if ($this->input->is_ajax_request()) {
				$userData = $this->session->userdata('userData');
				$column_order = [null, 'name', 'phone', 'email', 'created_at'];
				$column_search = ['name', 'phone', 'email', 'created_at'];
				$where = ['customers.deleted_at' => null];
				$order = ['id' => 'ASC'];
				$query = [
					'table' => 'customers',
					'select' => '*',
					'where' => $where,
					'join' => []
				];
				// var_dump($this->input->post('tipe'));
				$customers = $this->Datatable_Model->getDataTables($query, $column_order, $column_search, $order);
				$data = [];
				$no = @$_POST['start'];
				foreach ($customers as $cust) {
					$no++;
					$row = [];
					$row[] = $no . ".";
					$row[] = $cust->name;
					$row[] = $cust->phone;
					$row[] = $cust->email;
					$row[] = '
					  	<div class="">
		                 	<a href="#" type="button" id="btn-edit-' . $cust->id . '" onclick="ButtonEdit(' . "'" . encrypt_decrypt('encrypt',$cust->id) . "'" . ')" class="btn btn-warning shadow btn-sm sharp"><span class="fa fa-edit"></span></a>
		                 	<a href="#" type="button" id="btn-delete-' . $cust->id . '" onclick="ButtonDelete(' . "'" . encrypt_decrypt('encrypt',$cust->id) . "'" . ')" class="btn btn-danger shadow btn-sm sharp"><span class="fa fa-trash"></span></a>

		                </div>';
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


	function tambah()
	{
		if ($this->input->is_ajax_request()) {
			if ($this->_validation()) {
				$name = $this->input->post('name', TRUE);
				$phone = $this->input->post('phone', TRUE);
				$email = $this->input->post('email', TRUE);
				$data = [
					'name' => $name,
					'phone' => $phone,
					'email' => $email,
				];
				$this->General_Model->insert('customers',$data);
				$this->session->unset_userdata('image');
				$response = [
					'status' => true,
					'alert' => "Successfully Added Data"
				];
			} else {
				$response['error'] = getErrorValidation();
				$response['status'] = false;
				$response['alert'] = 'Failed Added Data';
			}
			$this->output->set_output(json_encode($response));
		} else {
			exit('Proses Tidak Dapat Dilanjutkan');
		}
	}

	function ubah()
	{
		if ($this->input->is_ajax_request()) {
			if ($this->_validation()) {
				$id = $this->input->post('id', TRUE);
				$name = $this->input->post('name', TRUE);
				$phone = $this->input->post('phone', TRUE);
				$email = $this->input->post('email', TRUE);
				$data = [
					'name' => $name,
					'phone' => $phone,
					'email' => $email,
				];
				$this->General_Model->update('customers',$data,['id' => $id]);
				$this->session->unset_userdata('image');
				$response = [
					'status' => true,
					'alert' => "Successfully Updated Data"
				];
			} else {
				$response['error'] = getErrorValidation();
				$response['status'] = false;
				$response['alert'] = 'Failed Updated Data';
			}
			$this->output->set_output(json_encode($response));
		} else {
			exit('Proses Tidak Dapat Dilanjutkan');
		}
	}


	private function _validation()
	{
		// $this->form_validation->set_rules('kategori_customers', 'kategori_customers', 'trim|required');
		$this->form_validation->set_rules('name', 'name', 'trim|required');
		$this->form_validation->set_rules('phone', 'phone', 'trim|required|numeric');
		$this->form_validation->set_rules('email', 'email', 'trim|required|valid_email');
	
		$this->form_validation->set_error_delimiters('', '');
		$return = $this->form_validation->run();
		return $return;
	}

	function delete($id)
	{
		if ($this->input->is_ajax_request()) {
			softDelete('customers', ['id' => encrypt_decrypt("decrypt",$id)]);
			$response = [
				'status' => true,
				'alert' => 'Successfully deleted data'
			];
			$this->output->set_output(json_encode($response));

		}else{
			exit('access denied');
		}
	}
 
 }
 
 /* End of file Customers.php */
 /* Location: ./application/controllers/cms/Customers.php */ ?>