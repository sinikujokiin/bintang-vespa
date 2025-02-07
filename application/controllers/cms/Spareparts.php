<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Spareparts extends CI_Controller {

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
			'title' => 'Data Sparepart'
		];	

		$this->template->load('templates/cms', 'cms/spareparts',$data, FALSE);
	}


		function getDataById($id)
		{
			if ($this->input->is_ajax_request()) {
				$response = [
					'sukses' => true,
					'data' => $this->General_Model->get("spareparts",["id" => encrypt_decrypt("decrypt",$id)])->row_array()
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
				$column_order = [null, 'image', 'name','stock','price'];
				$column_search = ['image', 'name','stock','price'];
				$where = ['spareparts.deleted_at' => null];
				$order = ['id' => 'ASC'];
				$query = [
					'table' => 'spareparts',
					'select' => '*',
					'where' => $where,
					'join' => []
				];
				// var_dump($this->input->post('tipe'));
				$spareparts = $this->Datatable_Model->getDataTables($query, $column_order, $column_search, $order);
				$data = [];
				$no = @$_POST['start'];
				foreach ($spareparts as $part) {
					$no++;
					$row = [];
					$row[] = $no . ".";
					$row[] = $part->image ? '<img src="'.base_url('uploads/spareparts/'.$part->image).'" width="50px" alt="'.$part->name.'" title="'.$part->name.'">' : "-";
					$row[] = $part->name;
					$row[] = $part->stock;
					$row[] = 'Rp. '.number_format($part->price,0,',','.');
					$row[] = '
					  	<div class="">
		                 	<a href="#" type="button" id="btn-edit-' . $part->id . '" onclick="ButtonEdit(' . "'" . encrypt_decrypt('encrypt',$part->id) . "'" . ')" class="btn btn-warning shadow btn-sm sharp"><span class="fa fa-edit"></span></a>
		                 	<a href="#" type="button" id="btn-delete-' . $part->id . '" onclick="ButtonDelete(' . "'" . encrypt_decrypt('encrypt',$part->id) . "'" . ')" class="btn btn-danger shadow btn-sm sharp"><span class="fa fa-trash"></span></a>

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
				$stock = $this->input->post('stock', TRUE);
				$price = $this->input->post('price', TRUE);
				$image = $this->session->userdata('image');
				$data = [
					'name' => $name,
					'slug' => url_title($name, '-', true),
					'stock' => $stock,
					'price' => $price,
					'image' => $image ? $image : null,
				];
				$this->General_Model->insert('spareparts',$data);
				$this->session->unset_userdata('image');
				$response = [
					'status' => true,
					'alert' => "Successfully Added Data"
				];
			} else {
				$response['error'] = getErrorValidation();
				$response['error']['image'] = strip_tags(form_error('image'));
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
				$stock = $this->input->post('stock', TRUE);
				$price = $this->input->post('price', TRUE);
				$image = $this->session->userdata('image');
				$data = [
					'name' => $name,
					'slug' => url_title($name, '-', true),
					'stock' => $stock,
					'price' => $price,
				];
				if ($image) {
					$data['image'] = $image;
				}
				// var_dump($data);die;
				$this->General_Model->update('spareparts',$data,['id' => $id]);
				$response = [
					'status' => true,
					'alert' => "Successfully Updated Data"
				];
			} else {
				$response['error'] = getErrorValidation();
				$response['error']['image'] = strip_tags(form_error('image'));
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
		$this->form_validation->set_rules('name', 'name', 'trim|required');
		$this->form_validation->set_rules('stock', 'stok', 'trim|required|numeric');
		$this->form_validation->set_rules('price', 'harga', 'trim|required|numeric');
		if ($_FILES['image']['name'] || $this->uri->segment(3) == 'add') {
			$this->form_validation->set_rules('image', 'image', 'callback_upload_file');
		}
		$this->form_validation->set_error_delimiters('', '');
		$return = $this->form_validation->run();
		return $return;
	}

	function upload_file()
	{
		$judul = $this->input->post("name");
		$path = './uploads/spareparts/';
		if (!is_dir($path)) {
		    mkdir($path, 0777, TRUE);
		}
		$config['upload_path'] = $path;
		$config['allowed_types'] = 'gif|jpg|png|jpeg|webp';
		$config['file_name'] = uniqid().'-'.url_title($judul, "dash", true).'-'.date("y-m-d");
		$config['overwrite'] = true;
		$this->load->library('upload', $config);
		if ( ! $this->upload->do_upload('image')){
			$this->form_validation->set_message('upload_file', $this->upload->display_errors());
			return FALSE;
		}else{
			$ext = explode(".", $this->upload->data('file_name'));
			$ext = end($ext);
			$webp = $this->upload->data('file_name');
			// if ($ext != "webp") {
			// 	$webp = covertToWebp($path, $this->upload->data('file_name'));
			// }
			$file = $this->session->set_userdata('image', $webp);
			return TRUE;
		}
	}

	function updateStatus($id)
	{
		$id = encrypt_decrypt('decrypt', $id);
		$cek = $this->General_Model->get('spareparts', ['id' => $id])->row();
		// var_dump($cek);die;
		if ($cek->status == 'Aktif') {
			$status = 'Tidak Aktif';
		}else{
			$status = 'Aktif';
		}

		$this->General_Model->update('spareparts', ['status' => $status], ['id' => $id]);

		$this->output->set_output(json_encode(['status' => true, 'alert' => "Successfully change status"]));
	}

	function delete($id)
	{
		if ($this->input->is_ajax_request()) {
			softDelete('spareparts', ['id' => encrypt_decrypt("decrypt",$id)]);
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

/* End of file Spareparts.php */
/* Location: ./application/controllers/cms/Spareparts.php */
