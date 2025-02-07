<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Setting extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Setting_Model');
		cekLogin();
	}

	public function index()
	{
		$data = [
			'title' => 'Web Setting',
			'data' => $this->Setting_Model->getData()
		];	

		$this->template->load('templates/cms', 'cms/setting',$data, FALSE);
	}

	function upload($website_name)
	{
		$this->load->helper('string');
		$random = random_string('alnum', 4);
		$linkLocal = "./assets/";
		$linkRemote = "./assets/";
		$this->load->library('upload');
		          //config untuk upload gambar
		$config['upload_path'] = './assets/';
		$config['allowed_types'] = 'jpg|jpeg|png';
		$config['encrypt_name'] = TRUE;
		$config['file_name'] = 'logo'.substr($website_name, 0,5).'_'.date('d-m-Y').'_'.rand(3, 1000);
		$this->upload->initialize($config);

		if ($this->input->post('id_web')) {
			$cek = $this->db->get_where('setting', ['id_web' => encrypt_decrypt("decrypt",$this->input->post('id_web'))])->row_array();
			if ($_FILES['logo']['name']) {
				if (!$this->upload->do_upload('logo')) {
					$array[] = ['logo_error' => $this->upload->display_errors('','')];
				}else{
					// uploadFTP($linkLocal,$linkRemote,$this->upload->data('file_name'));
	          		$array[] = ['sukses' => true, 'upload' => $this->upload->data('file_name')];

				}
			}else{
					// uploadFTP($linkLocal,$linkRemote,$cek['logo']);

          		$array[] = ['sukses' => true, 'upload' => $cek['logo']];

			}

			if ($_FILES['icon']['name']) {
				unset($config['upload_path'], $config['allowed_types'], $config['file_name']);
				$config['upload_path'] = './assets/';
				$config['allowed_types'] = 'jpg|jpeg|png';
				$config['file_name'] = 'logo'.substr($website_name, 0,5).'_'.date('d-m-Y').'_'.rand(3, 1000);

				$config['upload_path'] = './assets/';
				$config['allowed_types'] = 'jpg|jpeg|png';
				$config['encrypt_name'] = TRUE;
				$config['file_name'] = 'icon'.substr($website_name, 0,5).'_'.date('d-m-Y').'_'.rand(3, 1000);

				$this->upload->initialize($config);
				if (!$this->upload->do_upload('icon')) {
					$array[] = ['icon_error' => $this->upload->display_errors('','')];
	        	} else {
					// uploadFTP($linkLocal,$linkRemote,$this->upload->data('file_name'));
	          		$array[] = ['sukses' => true, 'upload' => $this->upload->data('file_name')];
	          	}
			}else{
					// uploadFTP($linkLocal,$linkRemote,$cek['icon']);
          		$array[] = ['sukses' => true, 'upload' => $cek['icon']];
			}
		}else{
			if (!$this->upload->do_upload('logo')) {
				$array[] = ['logo_error' => $this->upload->display_errors('','')];
			} else {
					// uploadFTP($linkLocal,$linkRemote,$this->upload->data('file_name'));
				$array[] = ['sukses' => true, 'upload' => $this->upload->data('file_name')];
				unset($config['upload_path'], $config['allowed_types'], $config['file_name']);
				$config['upload_path'] = './assets/';
				$config['allowed_types'] = 'jpg|jpeg|png';
				$config['file_name'] = 'logo'.substr($website_name, 0,5).'_'.date('d-m-Y').'_'.rand(3, 1000);

				$config['upload_path'] = './assets/';
				$config['allowed_types'] = 'jpg|jpeg|png';
				$config['encrypt_name'] = TRUE;
				$config['file_name'] = 'icon'.substr($website_name, 0,5).'_'.date('d-m-Y').'_'.rand(3, 1000);
				$this->upload->initialize($config);
				if (!$this->upload->do_upload('icon')) {
					$array[] = ['icon_error' => $this->upload->display_errors('','')];
	        	} else {
					// uploadFTP($linkLocal,$linkRemote,$this->upload->data('file_name'));
	          		$array[] = ['sukses' => true, 'upload' => $this->upload->data('file_name')];
	          	}
	      	}

		}

      return $array;
	}

	function update()
	{
		if ($this->input->is_ajax_request()) {
			if ($this->_validation()) {
				$id_web = $this->input->post('id_web', TRUE);
				$website_name = $this->input->post('website_name', TRUE);
				$about = $this->input->post('about', TRUE);
				$email = $this->input->post('email', TRUE);
				$phone = $this->input->post('phone', TRUE);
				$address = $this->input->post('address', TRUE);
				$link_map = $this->input->post('link_map');
				$link_ig = $this->input->post('link_ig');
				$nama_ig = $this->input->post('nama_ig');
				$link_fb = $this->input->post('link_fb');
				$nama_fb = $this->input->post('nama_fb');
				$link_tiktok = $this->input->post('link_tiktok');
				$nama_tiktok = $this->input->post('nama_tiktok');
				$link_twitter = $this->input->post('link_twitter');
				$nama_twitter = $this->input->post('nama_twitter');
				$keyword = $this->input->post('keyword', TRUE);
				$deskripsi = $this->input->post('deskripsi', TRUE);
				$g_tag = $this->input->post('g_tag', TRUE);
				$script_g_tag = $this->input->post('script_g_tag', TRUE);
				// var_dump($status != NULL ? 'Active' : 'Non Active');die;
				$upload = $this->upload($website_name);
				if (isset($upload[0]['sukses']) && isset($upload[1]['sukses'])) {
					$data = [
						'website_name' => $website_name,
						'email' => $email,
						'phone' => $phone,
						'address' => $address,
						'link_map' => $link_map,
						'link_ig' => $link_ig,
						'link_tiktok' => $link_tiktok,
						'link_fb' => $link_fb,
						'link_twitter' => $link_twitter,
						'nama_ig' => $nama_ig,
						'nama_tiktok' => $nama_tiktok,
						'nama_fb' => $nama_fb,
						'nama_twitter' => $nama_twitter,
						'keyword' => $keyword,
						'deskripsi' => $deskripsi,
						'g_tag' => $g_tag,
						'script_g_tag' => $script_g_tag,
						'logo' => $upload[0]['upload'],
						'icon' => $upload[1]['upload'],
						'about' => $about,
						'updated_by' => $this->session->userdata('userData')['id_user']
						// 'created_by' => $this->session->userdata('item')
					];
					$update  = $this->Setting_Model->update(encrypt_decrypt("decrypt",$id_web),$data);
					// var_dump($update);die;
					$response = [
						'status' => true,
						'alert' => "Successfully Updated Data"
					];
				}else{
					$response['status'] = false;
					$response['alert'] = 'Failed Updated Data';
					if (isset($upload[0]['logo_error'])) {
					  $error =['logo' => $upload[0]['logo_error']];
					}
					if (isset($upload[1]['icon_error'])){
					  $error = ['icon' => $upload[1]['icon_error']];
					}
					$response['error'] = array_merge(getErrorValidation(), $error);
				}
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
		$this->form_validation->set_rules('website_name', 'Website Name', 'trim|required');
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
		$this->form_validation->set_rules('phone', 'Phone', 'trim|required');
		$this->form_validation->set_rules('address', 'Address', 'trim|required');
		$this->form_validation->set_rules('about', 'About', 'trim|required');
		// $this->form_validation->set_rules('description', 'description', 'trim|required', ['required' => '%s Cannot Be Null!!']);
		$this->form_validation->set_error_delimiters('', '');
		return $this->form_validation->run();
	}
}

/* End of file Setting.php */
/* Location: ./application/views/cms/Setting.php */