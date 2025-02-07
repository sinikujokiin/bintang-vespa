<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('recaptcha');
	}
	public function index()
	{
		$data = ['title' => 'Login'];
		$data['widget'] = $this->recaptcha->getWidget();
		$data['script'] = $this->recaptcha->getScriptTag();
		loadView('templates/landing', 'landing/login', $data);
		// loadView()
		// $this->load->view('login', $data, FALSE);
	}


	function register()
	{
		if ($this->input->post()) {
			$this->do_regiter();
		}
		$data = ['title' => 'Register'];
		$data['widget'] = $this->recaptcha->getWidget();
		$data['script'] = $this->recaptcha->getScriptTag();
		loadView('templates/landing', 'landing/register', $data);
	}

	function do_regiter()
	{
		$this->form_validation->set_rules('name', 'nama lengkap', 'trim|required');
		$this->form_validation->set_rules('email', 'email', 'trim|required|valid_email|is_unique[users.email]');
		$this->form_validation->set_rules('phone', 'no hp', 'trim|numeric');
		$this->form_validation->set_rules('username', 'username', 'trim|required|is_unique[users.username]|min_length[5]');
		$this->form_validation->set_rules('password', 'password', 'trim|required|callback_check_password_regex');
		$this->form_validation->set_rules('confpassword', 'konfirmasi password', 'trim|matches[password]');
		$this->form_validation->set_error_delimiters('<small class="text-danger" style="font-size:12px">', '</small>');

		if ($this->form_validation->run()) {
			$request = $this->input->post();
			$username = $request['username'];
			$password = $request['password'];
			$name = $request['name'];
			$phone = $request['phone'];
			$email = $request['email'];
			$words = explode(" ", $name); // memecah string menjadi array berdasarkan spasi
			$nickname = "";
			foreach ($words as $word) {
			  $nickname .= substr($word, 0, 1); // mengambil karakter pertama dari setiap kata
			}

			try {
				$dataUser = [
					'username' => $username,
					'password' => sha1($password),
					'backup_password' => encrypt_decrypt('encrypt',$password),
					'email' => $email,
					'phone' => $phone,
					'fullname' => $name,
					'profile_picture' => 'default.png',
					'nickname' => $nickname,
					'status' => 'Active',
				];

				$this->db->insert('users', $dataUser);
				$id_user = $this->db->insert_id();

				$dataCustomer = [
					'user_id' => $id_user,
					'name' => $name,
					'phone' => $phone,
					'email' => $email,
				];
				$this->db->insert('customers', $dataCustomer);
				$customer_id = $this->db->insert_id();
				$cek = $this->db->get_where('users', ['id_user' => $id_user])->row();
				$userData = [
					'id_user' => $cek->id_user,
					'customer_id' => $customer_id,
					'username' => $cek->username,
					'nickname' => $cek->nickname,
					'role_id' => $cek->role_id,
					'phone' => $cek->phone,
					'email' => $cek->email,
					'fullname' => $cek->fullname,
					'profile_picture' => $cek->profile_picture,
				];
				$this->session->set_userdata('userData',$userData);

				$workshop_id = $this->session->userdata('workshop_id');
				$redirect = $this->session->userdata('redirect');
				redirect($redirect,'refresh');
			} catch (Exception $e) {
				
			}


		} else {
			$this->session->set_flashdata('errors', getErrorValidation());
		}
	}

	public function check_password_regex($password)
	{
	    if (!preg_match('/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d).{6,}$/', $password)) {
	        $this->form_validation->set_message('check_password_regex', 'Password must have at least 1 lowercase, 1 uppercase, 1 number, and a minimum length of 6 characters.');
	        return false;
	    } else {
	        return true;
	    }
	}



	function doLogin()
	{
		if ($this->input->is_ajax_request()) {

			$password = $this->input->post('password',true);
			$username = $this->input->post('username',true);
			// $recaptcha = $this->input->post('g-recaptcha-response');
			$cek = $this->db->get_where('users', ['username' => $username])->row();
			// var_dump(sha1($password) == $cek->password);die;
			if ($cek) {
				if ($cek->status == "Active") {
					if (sha1($password) == $cek->password) {
						$userData = [
							'id_user' => $cek->id_user,
							'username' => $cek->username,
							'nickname' => $cek->nickname,
							'role_id' => $cek->role_id,
							'phone' => $cek->phone,
							'email' => $cek->email,
							'fullname' => $cek->fullname,
							'profile_picture' => $cek->profile_picture,
						];
						if ($cek->role_id == 0 || $cek->role_id == '0') {
							$userData['customer_id'] = $this->db->get_where('customers', ['user_id' => $cek->id_user])->row()->id;
						}
						$this->session->set_userdata('userData',$userData);
						$response = [
							'success' => true,
							'msg' => "Welcome back ".$cek->fullname,
							'redirect' => $this->session->userdata('redirect') ? $this->session->userdata('redirect') : 'cms/dashboard' 
						];
					}else{
						$response = [
							'success' => false,
							'msg' => "Username and Password Not Matches"
						];
					}
				}else{
					$response = [
						'success' => false,
						'msg' => "Your Account is Not Active <br> Please Contact Administrator"
					];
				}
			}else{
				$response = [
					'success' => false,
					'msg' => "Account Not Found"
				];
			}

			$this->output->set_output(json_encode($response));

		}else{
			exit();
		}
	}


	function logout()
	{
		foreach ($_COOKIE as $key=>$value) {
		  setcookie($key,"",1);
		  }
		$this->session->unset_userdata('userData');
		redirect('login');
	}

	function forgot()
	{
		$data['title'] = 'Lupa Password';
		loadView('templates/landing', 'landing/forgot', $data);
	}

	function sendOtp()
	{
		if ($this->input->is_ajax_request()) {
			$email = $this->input->post('email');
			$otp = $this->input->post('otp');
			$cekUser = $this->db->get_where('users', ['email' => $email])->row();
			$otp = implode('', $otp);
			$password = $this->input->post('password');
			$confpassword = $this->input->post('confpassword');
			
			// var_dump($otp);die;
			if ($otp) {
				if ($cekUser->otp == $otp ) {
					$response = ['status' => true, 'msg' => 'OTP valid', 'type' => 'password'];
				}else{
					$response = ['status' => false, 'msg' => 'OTP tidak valid', 'type' => 'otp'];
				}
			}else if ($password) {
				$this->form_validation->set_rules('password', 'password', 'trim|required|callback_check_password_regex');
				$this->form_validation->set_rules('confpassword', 'konfirmasi password', 'trim|matches[password]');
				$this->form_validation->set_error_delimiters('<small class="text-danger" style="font-size:12px">', '</small>');
				if ($this->form_validation->run()) {
					$this->db->update('users', ['password' => sha1($password), 'backup_password' => encrypt_decrypt('encrypt', $password)], ['id_user' => $cekUser->id_user]);
					$response = ['status' => true, 'msg' => 'Password Berhasil diperbarui', 'type' => 'done'];
				} else {
					$err = strip_tags(form_error('password').'\n'.form_error('confpassword')) ;
					$response = ['status' => false, 'msg' => $err, 'type' => 'password'];

				}
			}else{
				// var_dump($cekUser);die;
				if ($cekUser) {
					$otp = rand(1000, 9999);
					$msg = '*Permintaan Reset Password*

Berikut adalah kode untuk reset password, Silahkan masukkan kode *'.$otp.'*';
					$now = date("Y-m-d H:i:s");
					$expired_otp = date('Y-m-d H:i:s', strtotime('+3 minutes', strtotime($now)));
					__sendWa($cekUser->phone, $msg);
					$this->db->update('users', ['otp' => $otp, 'expired_otp' => $expired_otp], ['id_user' => $cekUser->id_user]);
					$response = ['status' => true, 'msg' => 'Konfirmasi pengubahan password berhasil dikirim', 'type' => 'otp'];
				}else{
					$response = ['status' => false, 'msg' => 'Email Tidak Terdaftar', 'type' => 'email'];
				}

			}
				echo json_encode($response);
		}
	}

}

/* End of file Auth.php */
/* Location: ./application/controllers/Auth.php */