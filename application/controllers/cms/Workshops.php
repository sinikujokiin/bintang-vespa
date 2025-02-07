<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Workshops extends CI_Controller {

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
			'title' => 'Data Bengkel',
			'data' => $this->General_Model->get('workshops', ['deleted_at' => null])->result()
		];	

		$this->template->load('templates/cms', 'cms/workshops/index',$data, FALSE);
	}


	function create()
	{
		$data = [
			'title' => 'Tambah Data Bengkel',
		];	

		$this->template->load('templates/cms', 'cms/workshops/create',$data, FALSE);
	}

	function edit($id)
	{

		$workshop = $this->General_Model->get('workshops', ['id' => encrypt_decrypt('decrypt', $id)])->row();
		if ($workshop) {
			
			$data = [
				'title' => 'Tambah Data Bengkel',
				'data' => $workshop
			];	
			$this->template->load('templates/cms', 'cms/workshops/edit',$data, FALSE);
		}else{
			redirect('cms/data-workshop', 'refresh');
		}

	}

	function store()
	{
		if ($this->input->is_ajax_request()) {
			if ($this->_validation()) {
				$name = $this->input->post('name', TRUE);
				$phone = $this->input->post('phone', TRUE);
				$email = $this->input->post('email', TRUE);
				$address = $this->input->post('address', TRUE);
				$lat = $this->input->post('lat', TRUE);
				$long = $this->input->post('long', TRUE);
				$link = $this->input->post('link', TRUE);
				$data = [
					'name' => $name,
					'phone' => $phone,
					'status' => "Aktif",
					'email' => $email,
					'address' => $address,
					'lat' => $lat,
					'link' => $link,
				];
				$this->General_Model->insert('workshops',$data);
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

	function update()
	{
		if ($this->input->is_ajax_request()) {
			if ($this->_validation()) {
				$id = $this->input->post('id', TRUE);
				$name = $this->input->post('name', TRUE);
				$phone = $this->input->post('phone', TRUE);
				$email = $this->input->post('email', TRUE);
				$address = $this->input->post('address', TRUE);
				$lat = $this->input->post('lat', TRUE);
				$long = $this->input->post('long', TRUE);
				$link = $this->input->post('link', TRUE);
				$data = [
					'name' => $name,
					'phone' => $phone,
					'status' => "Aktif",
					'email' => $email,
					'address' => $address,
					'lat' => $lat,
					'long' => $long,
					'link' => $link,
				];
				$this->General_Model->update('workshops',$data,['id' => encrypt_decrypt('decrypt',$id)]);
				$this->session->unset_userdata('image');
				$response = [
					'status' => true,
					'alert' => "Successfully Updated Data"
				];
			} else {
				$response['error'] = getErrorValidation();
				$response['error']['kategori_workshops'] = form_error('kategori_workshops');
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
		// $this->form_validation->set_rules('kategori_workshops', 'kategori_workshops', 'trim|required');
		$this->form_validation->set_rules('name', 'nama bengkel', 'trim|required');
		$this->form_validation->set_rules('phone', 'no telepon', 'trim|required|numeric');
		$this->form_validation->set_rules('email', 'email bengkel', 'trim|required|valid_email');
		$this->form_validation->set_rules('address', 'alamat bengkel', 'trim|required');
		$this->form_validation->set_rules('lat', 'titik lokasi bengkel', 'trim|required');
		$this->form_validation->set_rules('long', 'titik lokasi bengkel', 'trim|required');
		$this->form_validation->set_rules('link', 'link lokasi', 'trim|required');
		// $this->form_validation->set_rules('universitas', 'universitas', 'trim|required');
		// $this->form_validation->set_rules('deskripsi', 'deskripsi', 'trim|required');
		// if ($_FILES['image']['name']) {
		// }
		$this->form_validation->set_error_delimiters('', '');
		$return = $this->form_validation->run();
		return $return;
	}

	function upload_file()
	{
		$judul = $this->input->post("name");
		$path = './uploads/workshops/';
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
		$cek = $this->General_Model->get('workshops', ['id' => $id])->row();
		// var_dump($cek);die;
		if ($cek->status == 'Aktif') {
			$status = 'Tidak Aktif';
		}else{
			$status = 'Aktif';
		}

		$this->General_Model->update('workshops', ['status' => $status], ['id' => $id]);

		$this->output->set_output(json_encode(['status' => true, 'alert' => "Successfully change status"]));
	}

	function destroy($id)
	{
		if ($this->input->is_ajax_request()) {
			softDelete('workshops', ['id' => encrypt_decrypt("decrypt",$id)]);
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

/* End of file Workshops.php */
/* Location: ./application/controllers/cms/Workshops.php */ ?>