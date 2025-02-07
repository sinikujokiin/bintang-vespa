<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Datatable_Model');
		$this->load->model('General_Model');
		cekLogin();
	}

	function index()
	{
		$data = [
			'title' => 'Profile Management',
			'data' => $this->session->userdata('userData')
		];	

		$this->template->load('templates/cms', 'cms/profile',$data, FALSE);
	}



	function saveProfile()
	{
		if ($this->input->is_ajax_request()) {
			$id = $this->session->userdata('userData')['id_user'];
			$fullname = $this->input->post('fullname');
			$nickname = $this->input->post('nickname');
			$email = $this->input->post('email');
			$phone = $this->input->post('phone');

			$data = [
				'fullname' => $fullname,
				'nickname' => $nickname,
				'email' => $email,
				'phone' => $phone,
			];
			$userData = $this->session->userdata('userData');
			$userData['fullname'] = $fullname;
			$userData['nickname'] = $nickname;
			$userData['email'] = $email;
			$userData['phone'] = $phone;
			$this->session->set_userdata('userData', $userData);


			$this->General_Model->update('users', $data, ['id_user' => $id]);
			if (isset($userData['customer_id'])) {
				unset($data['nickname']);
				unset($data['fullname']);
				$data['name'] = $fullname;
				$this->General_Model->update('customers', $data, ['id' => $userData['customer_id']]);
			}

			$response = ['msg' => "Successfully Updated Profile"];

			$this->output->set_output(json_encode($response));
		}else{
			exit('Proses Tidak Dapat Dilanjutkan');
		}
	}

	function savePassword()
	{
		if ($this->input->is_ajax_request()) {
			$id = $this->session->userdata('userData')['id_user'];
			$old_password = $this->input->post('old_password');
			$new_password = $this->input->post('new_password');
			$re_password = $this->input->post('re_password');
			$cek = $this->General_Model->getDataById($id)->row();
			// var_dump($new_password == $re_password);die;
			if ($cek->password == sha1($old_password)) {
				if ($new_password == $re_password) {
					$data['password'] = sha1($new_password);
					$this->General_Model->update('users', $data, ['id_user' => $id]);
					$response = [
						'status' => true,
						'msg' =>  "Successfully Updated Password"
					];
				}else{
					$response = [
						'status' => false,
						'msg' =>  "Re Password Not Matches to New Password"
					];
				}
			}else{
				$response = [
					'status' => false,
					'msg' =>  "Old Password Not Matches"
				];
			}

			$this->output->set_output(json_encode($response));

		}else{
			exit('Proses Tidak Dapat Dilanjutkan');
		}
	}

	function saveProfilePicture()
	{
		$id = $this->input->post('id_user');
		$upload = $this->upload($id);
		if ($upload['sukses']) {
			$this->db->update('users', ['profile_picture' => $upload['upload']] ,['id_user' => $id]);	
			// var_dump($this->db->last_query());die;
			$userData = $this->session->userdata('userData');
			$userData['profile_picture'] = $upload['upload'];
			$this->session->set_userdata('userData', $userData);
			$response = [
				'status' => true
			];
		}else{
			$response = [
				'status' => false,
				'error' => $upload['profile_pictures_error']
			];
		}
		$this->output->set_output(json_encode($response));

	}

	function upload($id)
	{
		$this->load->library('upload');
		          //config untuk upload gambar
		$config['upload_path'] = './uploads/profile/';
		$config['allowed_types'] = 'jpg|jpeg|png';
		$config['overwrite'] = TRUE;
		$config['file_name'] = 'profile-'.url_title($this->input->post('fullname'),"dash", true);
		$this->upload->initialize($config);

		$cek = $this->db->get_where('users', ['id_user' => $id])->row_array();
		if ($_FILES['profile_pictures']['name']) {
			if (!$this->upload->do_upload('profile_pictures')) {
				$array = ['profile_pictures_error' => $this->upload->display_errors('',''), 'sukses' => false];
			}else{
          		$array = ['sukses' => true, 'upload' => $this->upload->data('file_name')];

			}
		}else{

      		$array = ['sukses' => true, 'upload' => $cek['profile_picture']];

		}

		// var_dump($array);die;

		return $array;
	}

}

/* End of file Profile.php */
/* Location: ./application/controllers/cms/Profile.php */