<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Role extends CI_Controller {


	public function __construct()
	{
		parent::__construct();
		$this->load->model('Datatable_Model');
		$this->load->model('Role_Model');
		cekLogin();
	}

	public function index()
	{
		$data = [
			'title' => "Management Role"
		];
		$this->template->load('templates/cms', 'cms/role', $data);
	}

	var $column_order = [null, 'role_name', 'description_role', 'created_at'];
	var $column_search = ['role_name', 'description_role', 'created_at'];
	var $order = ['created_at' => 'ASC'];

	function getDataById($id_role)
	{
		if ($this->input->is_ajax_request()) {
			$response = [
				'sukses' => true,
				'data' => $this->Role_Model->getDataById(encrypt_decrypt("decrypt",$id_role))->row_array()
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
			$where = ['deleted_at' => null];
			if ($role_id != 1) $where['id_role !='] = 1;
			$query = [
				'table' => 'roles',
				'select' => '*',
				'where' => $where,
				'join' => []
			];
			// var_dump($this->input->post('tipe'));
			$roles = $this->Datatable_Model->getDataTables($query, $this->column_order, $this->column_search, $this->order);
			$data = [];
			$no = @$_POST['start'];
			foreach ($roles as $role) {
				$no++;
				$row = [];
				$row[] = $no . ".";
				$row[] = $role->role_name;
				$row[] = $role->description_role;
				$row[] = date('d-m-Y', strtotime($role->created_at));
				$row[] = '
			  	<div class="">
				  	<a href="#" type="button" id="btn-access-' . $role->id_role . '" onclick=ButtonAccess("' . encrypt_decrypt("encrypt",$role->id_role) . '") class="btn btn-success shadow btn-sm sharp mr-1"><span class="fa fa-wrench"></span></a>
				  	<a href="#" type="button" id="btn-edit-' . $role->id_role . '" onclick=ButtonEdit("' . encrypt_decrypt("encrypt",$role->id_role) . '") class="btn btn-warning shadow btn-sm sharp mr-1"><span class="fa fa-edit"></span></a>
                 	<a href="#" type="button" id="btn-delete-' . $role->id_role . '" onclick=ButtonDelete("' . encrypt_decrypt("encrypt",$role->id_role) . '") class="btn btn-danger shadow btn-sm sharp"><span class="fa fa-trash"></span></a>

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

	function tambah()
	{
		if ($this->input->is_ajax_request()) {
			if ($this->_validation()) {
				$role_name = $this->input->post('role_name', TRUE);
				$description_role = $this->input->post('description_role', TRUE);
				$data = [
					'role_name' => $role_name,
					'description_role' => $description_role,
					'created_by' => $this->session->userdata('userData')['id_user']
				];
				$this->Role_Model->insert($data);
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
				$id_role = $this->input->post('id_role', TRUE);
				$role_name = $this->input->post('role_name', TRUE);
				$description_role = $this->input->post('description_role', TRUE);
				$data = [
					'role_name' => $role_name,
					'description_role' => $description_role,
					'updated_by' => $this->session->userdata('userData')['id_user']
				];
				$this->Role_Model->update($id_role, $data);
				$response = [
					'status' => true,
					'alert' => "Successfully Updated Data"
				];
			} else {
				$response['error'] = getErrorValidation();
				$response['status'] = false;
				$response['alert'] = 'Successfully Updated Data';
			}
			$this->output->set_output(json_encode($response));
		} else {
			exit('Proses Tidak Dapat Dilanjutkan');
		}
	}

	function delete($id_role)
	{
		if ($this->input->is_ajax_request()) {
			$this->Role_Model->delete(encrypt_decrypt("decrypt",$id_role));
			$this->output->set_output(json_encode(['sukses' => true, 'alert' => 'Successfully Deleted Data']));
		} else {
			exit('Proses Tidak Dapat Dilanjutkan');
		}
	}

	private function _validation()
	{
		$this->form_validation->set_rules('role_name', 'Role Name', 'trim|required', ['required' => '%s Cannot Be Null!!']);
		$this->form_validation->set_rules('description_role', 'Description Role', 'trim|required', ['required' => '%s Cannot Be Null!!']);
		$this->form_validation->set_error_delimiters('', '');
		return $this->form_validation->run();
	}


	function akses($role_id)
	{
		if ($this->input->is_ajax_request()) {
			$role_id = encrypt_decrypt('decrypt', $role_id);
			$menuroleparent = $this->Role_Model->get_menu_child_by_role($role_id, 0);
			$menu = '<input type="hidden" id="role_id" name="role_id" value="' . $role_id . '">';
			$menu .= '<ol>';

			foreach ($menuroleparent as $parent) {
				$parent_is = '';
				if ($parent['role_id'] != "") $parent_is = ' checked="checked"';

				$menu .= '<li>
						<label>
						<input type="checkbox" name="menu_id[]" id="parent"' . $parent_is . ' value="' . $parent['id_menu'] . '">
						<span> ' . $parent['menu_title'] . '</span>
						</label>
				';

				$menurolechild = $this->Role_Model->get_menu_child_by_role($role_id, $parent['id_menu']);
				if (count($menurolechild) > 0)
					$menu .= '<ol>';

				foreach ($menurolechild as $child) {

					$menurolegrandchild = $this->Role_Model->get_menu_child_by_role($role_id, $child['id_menu']);

					$child_is = '';
					if ($child['role_id'] != "") $child_is = ' checked="checked"';

				
					// var_dump($child['have_link']);die;
					// if ($child['have_link'] == "yes") {

					// $menu .= '<li class="">
					// <label>
					// 	<span> ' . $child['menu_title'] . '</span>
					// </label><br>';
					// 	$menu .= '
					// 	<label>
					// 		<input type="checkbox" name="access_read['.$child['id_menu'].']" id="access_read"' . $read . ' value="Yes">
					// 		<span>Read</span>
					// 	</label>
					// 	<label>
					// 		<input type="checkbox" name="access_creat['.$child['id_menu'].']" id="access_creat"' . $creat . ' value="Yes">
					// 		<span>Create</span>
					// 	</label>
					// 	<label>
					// 		<input type="checkbox" name="access_update['.$child['id_menu'].']" id="access_update"' . $update . ' value="Yes">
					// 		<span>Edit</span>
					// 	</label>
					// 	<label>
					// 		<input type="checkbox" name="access_delete['.$child['id_menu'].']" id="access_delete"' . $delete . ' value="Yes">
					// 		<span>Delete</span>
					// 	</label>
					// 	';
					// }else{
					// }
						$menu .= '<li class="">
						<label>
						<input type="checkbox" name="menu_id[]" id="parent"' . $child_is . ' value="' . $child['id_menu'] . '">
							<span> ' . $child['menu_title'] . '</span>
						</label>';



					if (count($menurolegrandchild) > 0)
						$menu .= '<ol>';

					foreach ($menurolegrandchild as $grandchild) {
						$grandchild_is = '';
						if ($grandchild['role_id'] != "") $grandchild_is = ' checked="checked"';


					// var_dump($grandchild['have_link']);die;
					// if ($grandchild['have_link'] == "yes") {

					// $menu .= '<li class="">
					// <label>
					// 	<span> ' . $grandchild['menu_title'] . '</span>
					// </label><br>';
					// 	$menu .= '
					// 	<label>
					// 		<input type="checkbox" name="access_read['.$grandchild['id_menu'].']" id="access_read"' . $read_grand . ' value="Yes">
					// 		<span>Read</span>
					// 	</label>
					// 	<label>
					// 		<input type="checkbox" name="access_creat['.$grandchild['id_menu'].']" id="access_creat"' . $creat_grand . ' value="Yes">
					// 		<span>Create</span>
					// 	</label>
					// 	<label>
					// 		<input type="checkbox" name="access_update['.$grandchild['id_menu'].']" id="access_update"' . $update_grand . ' value="Yes">
					// 		<span>Edit</span>
					// 	</label>
					// 	<label>
					// 		<input type="checkbox" name="access_delete['.$grandchild['id_menu'].']" id="access_delete"' . $delete_grand . ' value="Yes">
					// 		<span>Delete</span>
					// 	</label>
					// 	';
					// }else{
					// }
						$menu .= '<li class="">
						<label>
						<input type="checkbox" name="menu_id[]" id="parent"' . $grandchild_is . ' value="' . $grandchild['id_menu'] . '">
							<span> ' . $grandchild['menu_title'] . '</span>
						</label>';

					}

					if (count($menurolegrandchild) > 0)
						$menu .= '</ol>';

					$menu .= '</li>';
				}

				if (count($menurolechild) > 0)
					$menu .= '</ol>';

				$menu .= '
				</li>';
			}

			$menu .= '</ol>';

			$this->output->set_output($menu);
		} else {
			exit('Proses Tidak Dapat Dilanjutkan');
		}
	}

	function saveAkses()
	{
		if ($this->input->is_ajax_request()) {
			$role_id = $this->input->post('role_id');
			$menu_id = $this->input->post('menu_id');
			// var_dump($this->input->post());die;
			$data_batch = array();

			for ($i = 0; $i < count($menu_id); $i++) {
				$data_batch[] = array(
					'role_id' => $role_id,
					'menu_id' => $menu_id[$i],
				);
			}


			$param_delete = array('role_id' => $role_id);

			$this->db->trans_begin();
			$this->Role_Model->hapusAkses($param_delete);
			if ($this->db->trans_status() === true) {
				$this->db->trans_commit();

				if (count($data_batch) > 0) {
					$this->db->trans_begin();
					$this->Role_Model->tambahAkses($data_batch);
					if ($this->db->trans_status() === true) {
						$this->db->trans_commit();
						$response = ['success' => true];
					} else {
						$this->db->trans_rollback();
						$response = ['success' => false];
					}
				} else {
					$response = ['success' => true];
				}
			} else {
				$this->db->trans_rollback();
				$response = ['success' => false];
			}

			$this->output->set_output(json_encode($response));
		} else {
			exit('Proses Tidak Dapat Dilanjutkan');
		}
	}

}

/* End of file Role.php */
/* Location: ./application/controllers/cms/Role.php */