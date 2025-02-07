<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Datatable_Model');
		$this->load->model('User_Model');
		cekLogin();
	}

	public function index($role = null)
	{
		$data = [
			'title' => 'User Management',
			'roles' => $this->db->get_where('roles', ['deleted_at' => null])->result_array()
		];	

		$this->template->load('templates/cms', 'cms/user',$data, FALSE);
	}

	var $column_order = [null, 'profile_picture','fullname', 'username','email','role_name' ,'status'];
	var $column_search = ['profile_picture','fullname', 'username','email','role_name' ,'status'];
	var $order = ['users.created_at' => 'ASC'];
	function getDataById($id_user)
	{
		if ($this->input->is_ajax_request()) {
			$response = [
				'sukses' => true,
				'data' => $this->User_Model->getDataById(encrypt_decrypt("decrypt",$id_user))->row_array()
			];
			$this->output->set_output(json_encode($response));
		} else {
			exit('Proses Tidak Dapat Dilanjutkan');
		}
	}

	function getData()
	{
		if ($this->input->is_ajax_request()) {
			$role_id = $this->session->userdata('userData')['role_id'];
			// var_dump($this->session->userdata('userData'));die;
			$where = ['users.deleted_at' => null];
			if ($role_id != 1) {
				$where['id_user !='] = 1;
			}
			$query = [
				'table' => 'users',
				'select' => 'profile_picture, fullname, username, email, role_name, id_user, status',
				'where' => $where,
				'join' => [
					['roles', 'roles.id_role = users.role_id', 'inner'],
				]
			];
			// var_dump($this->input->post('tipe'));
			$users = $this->Datatable_Model->getDataTables($query, $this->column_order, $this->column_search, $this->order);
			// var_dump($users);die;
			$data = [];
			$no = @$_POST['start'];
			foreach ($users as $user) {
				$no++;
				$row = [];
				$row[] = $no . ".";
				$row[] = '
					<div class="image">
			          <img src="'.base_url().'/uploads/profile/'.$user->profile_picture.'" class="img-circle elevation-2" width="100%" alt="User Image">
			        </div>';
				$row[] = $user->fullname;
				$row[] = $user->username;
				$row[] = $user->email;
				$row[] = $user->role_name;
				if ($user->status == 'Active') {
					$row[] = '<button type="button" class="btn btn-sm btn-success">Active</button>';
				}else{
					$row[] = '<button type="button" class="btn btn-sm btn-danger">Non Active</button>';
				}
				// $row[] = $user->description;
				// $row[] = date('d-m-Y', strtotime($user->created_at));
				$row[] = '
				  	<div class="">
					  	<a href="#" type="button" id="btn-edit-' . $user->id_user . '" onclick="ButtonEdit(' . "'" . encrypt_decrypt('encrypt',$user->id_user) . "'" . ')" class="btn btn-warning shadow btn-sm sharp mr-1"><span class="fa fa-edit"></span></a>
	                 	<a href="#" type="button" id="btn-delete-' . $user->id_user . '" onclick="ButtonDelete(' . "'" . encrypt_decrypt('encrypt',$user->id_user) . "'" . ')" class="btn btn-danger shadow btn-sm sharp"><span class="fa fa-trash"></span></a>

	                </div>	
				  ';
				$data[] = $row;
			}
			$output = [
				'draw' => @$_POST['draw'],
				'recordsTotal' => $this->Datatable_Model->countAll($query),
				'recordsFiltered' => $this->Datatable_Model->countFilters($query, $this->column_order, $this->column_search, $this->order),
				'data' => $data,
			];


			$this->output->set_output(json_encode($output));
		} else {
			exit('Proses Tidak Dapat Dilanjutkan');
		}
	}


	function tambahUser()
	{
		// var_dump($this->input->post());die;
		if ($this->input->is_ajax_request()) {
			if ($this->_validation()) {
				$username = $this->input->post('username', TRUE);
				$password = $this->input->post('password', TRUE);
				$nickname = $this->input->post('nickname', TRUE);
				$fullname = $this->input->post('fullname', TRUE);
				$status = $this->input->post('status', TRUE);
				$role_id = $this->input->post('role_id', TRUE);
				// var_dump($status != NULL ? 'Active' : 'Non Active');die;
				$upload = $this->upload($username);
				if ($upload['status']) {
					$data = [
						'fullname' => $fullname,
						'username' => $username,
						'nickname' => $nickname,
						'role_id' => $role_id,
						'profile_picture' => $upload['profile_pictures'],
						'password' => sha1($password),
						'status' => $status != NULL ? 'Active' : 'Non Active' ,
						'created_by' => $this->session->userdata('userData')['id_user']
						
						// 'created_by' => $this->session->userdata('item')
					];
					$this->User_Model->insert($data);
					$response = [
						'status' => true,
						'alert' => "Successfully Added Data"
					];
				} else {
					$response['error'] = array_merge(['profile_pictures' => $upload['profile_pictures_error']], getErrorValidation());
					$response['status'] = false;
					$response['alert'] = 'Failed Added Data';
				}
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

	function upload($username)
	{
		$this->load->helper('string');
		$random = random_string('alnum', 4);
		$linkLocal = "./uploads/profile/";
		$linkRemote = "./images/user/";
		$ext = explode('.', $_FILES['profile_pictures']['name']);
		$config = [
			'upload_path' => './uploads/profile/',
			'allowed_types' => 'jpg|jpeg|png|webp',
			'max_size' => '5000',
			'encrypt_name' => true,
			'file_name' => 'profile-' . url_title($username, 'dash', true) . '-' . date('d-m-Y') . '-' . $random.'.'.end($ext),
		];
		// var_dump($config['file_name']);die;
		$this->load->library('upload', $config);
		if ($this->input->post('id_user')) {
			$cek = $this->db->get_where('users', ['id_user' => $this->input->post('id_user')])->row_array();
			if ($_FILES['profile_pictures']['name']) {
				if (!$this->upload->do_upload('profile_pictures')) {
					$response = ['profile_pictures_error' => $this->upload->display_errors(), 'status' => false];
				} else {
					// uploadFTP($linkLocal,$linkRemote,$this->upload->data('file_name'));
					$response = ['profile_pictures' => $this->upload->data('file_name'), 'status' => true];
					if ($cek['profile_picture'] != 'default.png') {
						unlink(FCPATH . './uploads/profile/' . $cek['profile_picture']);
					}
					// unlink(FCPATH . './uploads/profile/thumbnail/' . $cek['profile_pictures']);
				}
			} else {
				// uploadFTP($linkLocal,$linkRemote,$cek['profile_picture']);
				$response = ['profile_pictures' => $cek['profile_picture'], 'status' => true];
			}
		} else {
			if ($_FILES['profile_pictures']['name']) {
				if (!$this->upload->do_upload('profile_pictures')) {
					$response = ['profile_pictures_error' => $this->upload->display_errors(), 'status' => false];
				} else {
					// uploadFTP($linkLocal,$linkRemote,$this->upload->data('file_name'));
					$response = ['profile_pictures' => $this->upload->data('file_name'), 'status' => true];
				}
			}else{
				$response = ['profile_pictures' => "default.png", 'status' => true];

			}
		}
		return $response;
	}


	function ubahUser()
	{
		if ($this->input->is_ajax_request()) {
			if ($this->_validation()) {
				$username = $this->input->post('username', TRUE);
				$nickname = $this->input->post('nickname', TRUE);
				$password = $this->input->post('password', TRUE);
				$fullname = $this->input->post('fullname', TRUE);
				$status = $this->input->post('status', TRUE);
				$role_id = $this->input->post('role_id', TRUE);

				$id_user = $this->input->post('id_user', TRUE);


				// var_dump($upload);
				// die();
				$upload = $this->upload($username);
				if ($upload['status']) {
					// createThumbnail('user', $upload['profile_picture']);
					$data = [
						'username' => $username,
						'nickname' => $nickname,
						'profile_picture' => $upload['profile_pictures'],
						'fullname' => $fullname,
						'status' => $status ? 'Active' : 'Non Active' ,
						'role_id' => $role_id,
						'updated_by' => $this->session->userdata('userData')['id_user']

						// 'updated_by' => $this->session->admindata('item')
					];
					if ($password) $data['password'] = sha1($password);
					$this->User_Model->update($id_user, $data);
					$response = [
						'status' => true,
						'alert' => "Successfully Updated Data"
					];
				} else {
					$response['error'] = array_merge(['profile_pictures' => $upload['profile_pictures_error']], getErrorValidation());
					// $response['error'] = ['profile_pictures' => $upload['profile_pictures_error']];
					$response['status'] = false;
					$response['alert'] = 'Failed Updated Data';
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

	function delete($id_user)
	{
		if ($this->input->is_ajax_request()) {
			$this->User_Model->delete(encrypt_decrypt('decrypt',$id_user));
			$this->output->set_output(json_encode(['sukses' => true, 'alert' => 'Successfully Deleted Data']));
		} else {
			exit('Proses Tidak Dapat Dilanjutkan');
		}
	}

	private function _validation()
	{
		$id = $this->input->post('id_user');
		$username = $this->input->post('username');
		$is_unique = "";
		$required = "|required";
		if ($id) {
			$cek = $this->db->get_where('users', ['id_user' =>$id])->row();
			if ($cek->username != $username) {
				$is_unique = "|is_unique[users.username]";
			}

			$required = "";
		}
		$this->form_validation->set_rules('username', 'Username', 'trim|required'.$is_unique, ['required' => '%s Cannot Be Null!!', 'is_unique' => "%s Already Registered"]);
		$this->form_validation->set_rules('role_id', 'Role', 'trim|required', ['required' => '%s Cannot Be Null!!', 'is_unique' => "%s Already Registered"]);
		$this->form_validation->set_rules('fullname', 'Fullname', 'trim|required', ['required' => '%s Cannot Be Null!!']);
		$this->form_validation->set_rules('password', 'Password', 'trim'.$required, ['required' => '%s Cannot Be Null!!']);
		$this->form_validation->set_rules('password_conf', 'Confirmation Password', 'matches[password]|trim'.$required, ['required' => '%s Cannot Be Null!!', "matches" => "%s is not the same as password"]);
		// $this->form_validation->set_rules('role_id', 'Role', 'trim|required', ['required' => '%s Cannot Be Null!!']);

		$this->form_validation->set_error_delimiters('', '');
		return $this->form_validation->run();
	}



	

}

/* End of file User.php */
/* Location: ./application/controllers/cms/User.php */