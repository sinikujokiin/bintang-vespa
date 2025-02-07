 <?php
 defined('BASEPATH') OR exit('No direct script access allowed');
 
 class Vespa extends CI_Controller {
 
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
			'title' => 'List Vespa'
		];	

		$this->template->load('templates/cms', 'cms/vespa',$data, FALSE);
	}


		function getDataById($id)
		{
			if ($this->input->is_ajax_request()) {
				$response = [
					'sukses' => true,
					'data' => $this->General_Model->get("vespa",["id" => encrypt_decrypt("decrypt",$id)])->row_array()
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
				$column_order = [null, 'name','year' ,'description', 'created_at'];
				$column_search = ['name','year' ,'description', 'created_at'];
				$where = ['vespa.deleted_at' => null];
				$order = ['id' => 'ASC'];
				$query = [
					'table' => 'vespa',
					'select' => '*',
					'where' => $where,
					'join' => []
				];
				// var_dump($this->input->post('tipe'));
				$vespa = $this->Datatable_Model->getDataTables($query, $column_order, $column_search, $order);
				$data = [];
				$no = @$_POST['start'];
				foreach ($vespa as $vesp) {
					$no++;
					$row = [];
					$row[] = $no . ".";
					$row[] = $vesp->name;
					$row[] = $vesp->year;
					$row[] = $vesp->description;
					$row[] = '
					  	<div class="">
		                 	<a href="#" type="button" id="btn-edit-' . $vesp->id . '" onclick="ButtonEdit(' . "'" . encrypt_decrypt('encrypt',$vesp->id) . "'" . ')" class="btn btn-warning shadow btn-sm sharp"><span class="fa fa-edit"></span></a>
		                 	<a href="#" type="button" id="btn-delete-' . $vesp->id . '" onclick="ButtonDelete(' . "'" . encrypt_decrypt('encrypt',$vesp->id) . "'" . ')" class="btn btn-danger shadow btn-sm sharp"><span class="fa fa-trash"></span></a>

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
				$year = $this->input->post('year', TRUE);
				$description = $this->input->post('description', TRUE);
				$data = [
					'name' => $name,
					'year' => $year,
					'description' => $description,
				];
				$this->General_Model->insert('vespa',$data);
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
				$year = $this->input->post('year', TRUE);
				$description = $this->input->post('description', TRUE);
				$data = [
					'name' => $name,
					'year' => $year,
					'description' => $description,
				];
				$this->General_Model->update('vespa',$data,['id' => $id]);
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
		// $this->form_validation->set_rules('kategori_vespa', 'kategori_vespa', 'trim|required');
		$this->form_validation->set_rules('name', 'name', 'trim|required');
		$this->form_validation->set_rules('description', 'description', 'trim|required');
	
		$this->form_validation->set_error_delimiters('', '');
		$return = $this->form_validation->run();
		return $return;
	}

	function delete($id)
	{
		if ($this->input->is_ajax_request()) {
			softDelete('vespa', ['id' => encrypt_decrypt("decrypt",$id)]);
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
 
 /* End of file Vespa.php */
 /* Location: ./application/controllers/cms/Vespa.php */ ?>