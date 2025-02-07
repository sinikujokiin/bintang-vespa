<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Web extends CI_Controller {

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
			'title' => 'Data Website',
			'categories' => $this->General_Model->get("categories")->result_array()
		];	

		$this->template->load('templates/cms', 'cms/website/index',$data, FALSE);
	}

	function getDataById($web_id)
	{
		if ($this->input->is_ajax_request()) {
			$response = [
				'sukses' => true,
				'data' => $this->General_Model->get("webs",["web_id" => encrypt_decrypt("decrypt",$web_id)])->row_array()
			];
			$this->output->set_output(json_encode($response));
		} else {
			exit('Proses Tidak Dapat Dilanjutkan');
		}
	}

	var $column_order = [null, 'web_name', 'domain', 'category_name', 'jml'];
	var $column_search = ['web_name', 'domain', 'category_name', 'jml'];
	var $order = ['webs.created_date' => 'ASC'];
	function getData()
	{
		if ($this->input->is_ajax_request()) {
			$userData = $this->session->userdata('userData');
			$query = [
				'table' => 'webs',
				'select' => 'web_name, domain, category_name, web_id,(SELECT(COUNT(web_id)) FROM articles WHERE articles.web_id = webs.web_id) as jml',
				'where' => [],
				'join' => [
					['categories', 'categories.category_id = webs.category_id', 'inner'],
				]
			];
			// var_dump($this->input->post('tipe'));
			$webs = $this->Datatable_Model->getDataTables($query, $this->column_order, $this->column_search, $this->order);
			$data = [];
			$no = @$_POST['start'];
			foreach ($webs as $web) {
				$no++;
				$row = [];
				$row[] = $no . ".";
				$row[] = $web->web_name;
				$row[] = '<a href="'.$web->domain.'" title="'.$web->web_name.'">'.$web->domain.'</a>';
				$row[] = $web->category_name;
				$row[] = $web->jml;
				$row[] = '
				  	<div class="">
	                 	<a href="'.base_url("data-web-pbn/".encrypt_decrypt('encrypt',$web->web_id)).'" type="button" id="btn-setting-' . $web->web_id . '" class="btn btn-info shadow btn-sm sharp"><span class="fa fa-wrench"></span></a>
	                 	<a href="#" type="button" id="btn-edit-' . $web->web_id . '" onclick="ButtonEdit(' . "'" . encrypt_decrypt('encrypt',$web->web_id) . "'" . ')" class="btn btn-warning shadow btn-sm sharp"><span class="fa fa-edit"></span></a>
	                 	<a href="#" type="button" id="btn-delete-' . $web->web_id . '" onclick="ButtonDelete(' . "'" . encrypt_decrypt('encrypt',$web->web_id) . "'" . ')" class="btn btn-danger shadow btn-sm sharp"><span class="fa fa-trash"></span></a>

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



	function add()
	{
		if ($this->input->is_ajax_request()) {
			if ($this->__validation()) {
				$web_name = $this->input->post('web_name');
				$domain = $this->input->post('domain');
				$category_id = $this->input->post("category_id");
				$data = [
					'web_name' => $web_name,
					'domain' => $domain,
					'category_id' => $category_id,
					'created_by' => $this->session->userdata('userData')['id_user'],
					'created_date' => date("Y-m-d H:i:s")
				];
				$this->General_Model->insert("webs", $data);
				$response['error'] = getErrorValidation();
				$response['status'] = true;
				$response['alert'] = 'Successfully Added Data';
			}else{
				$response['error'] = getErrorValidation();
				$response['status'] = false;
				$response['alert'] = 'Failed Added Data';
			}

			$this->output->set_output(json_encode($response));
		}else{
			exit("access denied");
		}
	}

	function edit()
	{
		if ($this->input->is_ajax_request()) {
			if ($this->__validation()) {
				$web_id = $this->input->post('web_id');
				$web_name = $this->input->post('web_name');
				$domain = $this->input->post('domain');
				$category_id = $this->input->post("category_id");
				$data = [
					'web_name' => $web_name,
					'domain' => $domain,
					'category_id' => $category_id,
					'updated_by' => $this->session->userdata('userData')['id_user'],
					'updated_date' => date("Y-m-d H:i:s")
				];
				$this->General_Model->update("webs", $data, ['web_id' => $web_id]);
				$response['error'] = getErrorValidation();
				$response['status'] = true;
				$response['alert'] = 'Successfully Added Data';
			}else{
				$response['error'] = getErrorValidation();
				$response['status'] = false;
				$response['alert'] = 'Failed Added Data';
			}

			$this->output->set_output(json_encode($response));
		}else{
			exit("access denied");
		}
	}


	private function __validation()
	{

		$web_id = $this->input->post("web_id");
		$domain = $this->input->post("domain");
		$cek = $this->General_Model->get("webs", ['web_id' => $web_id])->row_array();

		if ($web_id) {
			if ($cek['domain'] == $domain) {
				$is_unique = '';
			}else{
				$is_unique = '|is_unique[webs.domain]';
			}
		}else{
			$is_unique = '|is_unique[webs.domain]';
		}

		$this->form_validation->set_rules('web_name', 'Website Name', 'trim|required');
		$this->form_validation->set_rules('domain', 'Domain', 'trim|required|valid_url'.$is_unique);
		$this->form_validation->set_rules('category_id', 'Category', 'trim|required');
		$this->form_validation->set_error_delimiters('', '');
		return $this->form_validation->run();
	}

	function delete($web_id)
	{
		$web_id = encrypt_decrypt("decrypt", $web_id);
		$this->General_Model->delete("webs", ['web_id' => $web_id]);
		$this->output->set_output(json_encode(['alert' => "Successfully Deleted data"]));
	}


	function getFromImport()
	{

		$table = '
			<table class="table table-responsive table-bordered" width="100%">
				<thead>
					<tr>
						<th width="1%">No.</th>
						<th>Website Name</th>
						<th>Domain</th>
						<th>Kategori</th>
					</tr>
				</thead>
				<tbody>
		';
		if ($_FILES) {
			$file_name = $_FILES['file'];
			// var_dump($file_name);die;
			// $file_name 	= $path.$file_data['file_name'];
			$arr_file 	= explode('.', $file_name['name']);
			$extension 	= end($arr_file);
			if('csv' == $extension) {
				$reader 	= new \PhpOffice\PhpSpreadsheet\Reader\Csv();
			} else {
				$reader 	= new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
			}
			$spreadsheet 	= $reader->load($file_name['tmp_name']);
			$sheet_data 	= $spreadsheet->getActiveSheet()->toArray();
			$list 			= [];
			$no =1;

			$kategori = $this->General_Model->get("categories")->result();
			foreach($sheet_data as $key => $val) {
				if($key != 0) {
						$table .= '
						<tr>
							<td width="1%">'.$no++.'</td>
							<td><input type="text" name="web_name[]" class="form-control" value="'.$val[0].'"></td>
							<td><input type="text" name="domain[]" class="form-control" value="'.$val[1].'"></td>
							<td>
							<select name="category_id[]" id="category_id" class="form-control" >
								<option value="">Kategori Not Matched</option>';
									foreach ($kategori as $kat) {
										 // '.$kat->category_id == $val[2] ? "selected" : "" .'
										if ($kat->category_id == $val[2]) {
											$selected = "selected";
										}else{
											$selected = "";
										}
										$table .= '<option value="'.$kat->category_id.'" '.$selected.' >'.$kat->category_name.'</option>';
									}
						$table .='
							</select>


							</td>
						</tr>
						';

						// $list [] = [
						// 	'web_name'			=> $val[0],
						// 	'domain'			=> $val[1],
						// 	'category_id'		=> $val[2],
						// 	'flag'				=> '1',
						// 	'created_by'		=> $this->session->userdata('userData')['id_user']
						// 	'created_date'		=> date("Y-m-d H:i:s")
						// ];

				}
			}

		}else{
			$table .= '
				<tr><td colspan="3" class="text-center" width="100%">data not available</td></tr>
			';
		}

		$table .='

				</tbody>
			</table>';
		$this->output->set_output(json_encode($table));

	}

	function saveExport()
	{
		$web_name = $this->input->post("web_name");
		$domain = $this->input->post("domain");
		$category_id = $this->input->post("category_id");



		$search = array_search("", $category_id);

		if ($search == FALSE) {
			for ($i=0; $i < count($web_name) ; $i++) { 
				$cek = $this->General_Model->get("webs", ['domain' => $domain[$i]])->row();
				if ($cek) {
				}else{
					$data = [
							'web_name'			=> $web_name[$i],
							'domain'			=> $domain[$i],
							'category_id'		=> $category_id[$i],
							'flag'				=> '0',
							'created_by'		=> $this->session->userdata('userData')['id_user'],
							'created_date'		=> date("Y-m-d H:i:s")
						];
					$this->General_Model->insert("webs", $data);
				}
			}

			$response = ['status' => TRUE, "alert" => "Successfully Added Data"];
		}else{
			$response = ['status' => false, "alert" => "make sure all forms are filled"];
		}


		$this->output->set_output(json_encode($response));


	}

	function downloadFormat()
	{
		$this->load->helper('download');
		$file = './uploads/format-excel-list-website.xlsx';
		$download = force_download($file, null);
	}


	function setting($web_id)
	{
		$web_id = encrypt_decrypt("decrypt",$web_id);
		$web = $this->General_Model->get('webs', ['web_id' => $web_id])->row_array();

		if ($web) {
			$data = [
				'title' => 'Setting Web '.$web['web_name'],
				'data' => $web
			];
			$this->template->load('templates/cms', 'cms/website/setting', $data);
		}else{
			$this->template->load('templates/cms', 'errors/404', $data);
		}

	}


	function updateSetting()
	{
		if ($this->input->is_ajax_request()) {
			if ($this->_validation()) {
				$web_id = $this->input->post('web_id', TRUE);
				$web_name = $this->input->post('web_name', TRUE);
				$title_web = $this->input->post('title_web', TRUE);
				$domain = $this->input->post('domain', TRUE);
				$hostname = $this->input->post('hostname', TRUE);
				$description_web = $this->input->post('description_web', TRUE);
				$username_ftp = $this->input->post('username_ftp', TRUE);
				$password_ftp = $this->input->post('password_ftp', TRUE);
				// varpassword_ftp_dump($status != NULL ? 'Active' : 'Non Active');die;
				$upload = $this->upload($web_name, $hostname, $username_ftp, $password_ftp);
				if (isset($upload[0]['sukses']) && isset($upload[1]['sukses'])) {
					$data = [
						'web_name' => $web_name,
						'domain' => $domain,
						'hostname' => $hostname,
						'description_web' => $description_web,
						'password_ftp' => $password_ftp,
						'username_ftp' => $username_ftp,
						'logo_web' => $upload[0]['upload'],
						'icon_web' => $upload[1]['upload'],
						'title_web' => $title_web,
						'updated_by' => $this->session->userdata('userData')['id_user']
						// 'created_by' => $this->session->userdata('item')
					];
					// var_dump($web_id);die;
					$linkLocal = "./uploads/website/";
        			$linkRemote = "./img/";
					if($upload[0]['upload']){
    					uploadFTPPBN($linkLocal,$linkRemote,$upload[0]['upload'],$hostname,$username_ftp,$password_ftp);
					}
					if($upload[1]['upload']){
    					uploadFTPPBN($linkLocal,$linkRemote,$upload[1]['upload'],$hostname,$username_ftp,$password_ftp);
					}
					$this->General_Model->update("webs",$data, ['web_id' => encrypt_decrypt("decrypt",$web_id)]);
					$response = [
						'status' => true,
						'alert' => "Successfully Updated Data"
					];
				}else{
					$response['status'] = false;
					$response['alert'] = 'Failed Updated Data';
					if (isset($upload[0]['logo_web_error'])) {
					  $error =['logo_web' => $upload[0]['logo_web_error']];
					}
					if (isset($upload[1]['icon_web_error'])){
					  $error = ['icon_web' => $upload[1]['icon_web_error']];
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
		$this->form_validation->set_rules('web_name', 'Website Name', 'trim|required');
		$this->form_validation->set_rules('domain', 'Domain', 'trim|required|valid_url');
		$this->form_validation->set_rules('hostname', 'Hostname', 'trim|required');
		$this->form_validation->set_rules('password_ftp', 'Password FTP', 'trim|required');
		$this->form_validation->set_rules('username_ftp', 'Username FTP', 'trim|required');
		// $this->form_validation->set_rules('description', 'description', 'trim|required', ['required' => '%s Cannot Be Null!!']);
		$this->form_validation->set_error_delimiters('', '');
		return $this->form_validation->run();
	}


		function upload($web_name, $host,$user,$pass)
		{
			$this->load->helper('string');
			$random = random_string('alnum', 4);
			$linkLocal = "./uploads/website/";
			$linkRemote = "./img/";


			$this->load->library('upload');
			          //config untuk upload gambar
			$config['upload_path'] = $linkLocal;
			$config['allowed_types'] = 'jpg|jpeg|png|webp';
			$config['overwrite'] = TRUE;
			$config['file_name'] = 'logo-'.url_title($web_name,"dash", true);
			$this->upload->initialize($config);

			$cek = $this->db->get_where('webs', ['web_id' => encrypt_decrypt("decrypt",$this->input->post('web_id'))])->row_array();
			if ($_FILES['logo_web']['name']) {
				if (!$this->upload->do_upload('logo_web')) {
					$array[] = ['logo_web_error' => $this->upload->display_errors('','')];
				}else{

					$webp_logo = covertToWebp($linkLocal, $this->upload->data('file_name'));
					uploadFTPPBN($linkLocal,$linkRemote,$webp_logo,$host,$user,$pass);
	          		$array[] = ['sukses' => true, 'upload' => $webp_logo];

				}
			}else{

          		$array[] = ['sukses' => true, 'upload' => $cek['logo_web']];

			}

			if ($_FILES['icon_web']['name']) {
				unset($config['upload_path'], $config['allowed_types'], $config['file_name']);
				$config['upload_path'] = $linkLocal;
				$config['allowed_types'] = 'jpg|jpeg|png|webp';
				$config['file_name'] = 'logo-'.url_title($web_name,"dash", true);

				$config['upload_path'] = $linkLocal;
				$config['allowed_types'] = 'jpg|jpeg|png|webp';
				$config['overwrite'] = TRUE;
				$config['file_name'] = 'icon-'.url_title($web_name,"dash", true);

				$this->upload->initialize($config);
				if (!$this->upload->do_upload('icon_web')) {
					$array[] = ['icon_web_error' => $this->upload->display_errors('','')];
	        	} else {
	        		$webp_icon = covertToWebp($linkLocal, $this->upload->data('file_name'));
					uploadFTPPBN($linkLocal,$linkRemote,$webp_icon,$host,$user,$pass);
	          		$array[] = ['sukses' => true, 'upload' => $webp_icon];
	          	}
			}else{
          		$array[] = ['sukses' => true, 'upload' => $cek['icon_web']];
			}

	      return $array;
		}
}

/* End of file Web.php */
/* Location: ./application/controllers/cms/Web.php */