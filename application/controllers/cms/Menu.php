<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Menu extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Datatable_Model');
		$this->load->model('Menu_Model');
		cekLogin();
		
	}
	public function index()
	{
		$data = [
			'title' => 'Menu Setting'
		];
		$this->template->load('templates/cms','cms/menu', $data,FALSE);
	}

	function getDataById($id_menu)
	{
		if ($this->input->is_ajax_request()) {
			$response = [
				'sukses' => true,
				'data' => $this->Menu_Model->getDataById(encrypt_decrypt('decrypt',$id_menu))->row_array()
			];
			$this->output->set_output(json_encode($response));
		} else {
			exit('Proses Tidak Dapat Dilanjutkan');
		}
	}

	var $column_order = [null, 'parent_name', 'menu_title', 'menu_url', 'icon', 'have_link'];
	var $column_search = ['menu_title', 'menu_url', 'icon', 'have_link'];
	var $order = ['menu_parent' => 'ASC'];

	function getData()
	{
		if ($this->input->is_ajax_request()) {
			$type = $this->input->post('type');
			$query = [
				'table' => 'menus',
				'select' => 'id_menu,menu_parent,menu_title,icon,have_link,menu_url,(SELECT a.menu_title FROM menus a WHERE a.id_menu = menus.menu_parent) as parent_name, sort',
				'where' => ['type' => $type, 'deleted_at' => null],
				'join' => []
			];
			// var_dump($this->input->post('type'));
			$menus = $this->Datatable_Model->getDataTables($query, $this->column_order, $this->column_search, $this->order);
			// var_dump($this->db->last_query());die;
			$data = [];
			$no = @$_POST['start'];
			foreach ($menus as $menu) {
				$no++;
				$row = [];
				$row[] = $no . ".";
				$row[] = $menu->parent_name;
				$row[] = $menu->menu_title;
				$row[] = $menu->menu_url == '#' ? '' : '<a href="' . base_url($menu->menu_url) . '" title="' . $menu->menu_title . '">' . base_url($menu->menu_url) . '</a>';
				$row[] = '<span class="fa fa-' . $menu->icon . '"></span>';
				$row[] = $menu->have_link == "" ? '<span class="badge badge-info">Have Child</span>' : '<span class="badge badge-success">Not Have Child</span>';
				$row[] = '
				  	<a href="#" type="button" id="btn-edit-' . encrypt_decrypt('encrypt',$menu->id_menu) . '" title="Edit Data" onclick=ButtonEdit("' . encrypt_decrypt('encrypt',$menu->id_menu) . '") class="btn btn-warning shadow btn-sm sharp mr-1"><span class="fa fa-edit"></span></a>
                 	<a href="#" type="button" id="btn-delete-' . encrypt_decrypt('encrypt',$menu->id_menu) . '" title="Delete Data" onclick=ButtonDelete("' . encrypt_decrypt('encrypt',$menu->id_menu) . '") class="btn btn-danger shadow btn-sm sharp"><span class="fa fa-trash"></span></a>
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

	function loadParent()
	{
		if ($this->input->is_ajax_request()) {
			$this->output->set_output(json_encode($this->Menu_Model->getParent($this->input->get('type'))->result_array()));
		} else {
			exit('Proses Tidak Dapat Dilanjutkan');
		}
	}

	function tambah()
	{
		if ($this->input->is_ajax_request()) {
			if ($this->_validation()) {
				$menu_parent = $this->input->post('menu_parent', TRUE);
				$icon = $this->input->post('icon', TRUE);
				$menu_title = $this->input->post('menu_title', TRUE);
				$menu_url = $this->input->post('menu_url', TRUE);
				$sort = $this->db->select_max('sort')->where('menus.menu_parent', $menu_parent)->get('menus')->row();
				$type = $this->input->post('type', TRUE);
				$have_link = $this->input->post('have_link', TRUE);
				$data = [
					'menu_title' => $menu_title,
					'menu_url' => $menu_url,
					'menu_parent' => $menu_parent,
					'have_link' => $have_link,
					'sort' => $sort->sort + 1,
					'type' => $type,
					'icon' => $icon,
				];
				$this->Menu_Model->insert($data);
				$response = [
					'status' => true,
					'alert' => "Successfully Added New Menu"
				];
			} else {
				$response['error'] = getErrorValidation();
				$response['status'] = false;
				$response['alert'] = 'Failed Added New Menu';
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
				$id_menu = $this->input->post('id_menu', TRUE);
				$menu_parent = $this->input->post('menu_parent', TRUE);
				$icon = $this->input->post('icon', TRUE);
				$menu_title = $this->input->post('menu_title', TRUE);
				$menu_url = $this->input->post('menu_url', TRUE);
				// $sort = $this->db->select_max('sort')->where('menus.menu_parent', $menu_parent)->get('menus')->row();
				// $type = $this->input->post('type', TRUE);
				$have_link = $this->input->post('have_link', TRUE);
				$data = [
					'menu_title' => $menu_title,
					'menu_url' => $menu_url,
					'menu_parent' => $menu_parent,
					'have_link' => $have_link,
					// 'sort' => $sort->sort + 1,
					// 'type' => $type,
					'icon' => $icon,
				];
				$this->Menu_Model->update($id_menu, $data);
				$response = [
					'status' => true,
					'alert' => "Successfully Updated Menu"
				];
			} else {
				$response['error'] = getErrorValidation();
				$response['status'] = false;
				$response['alert'] = 'Failed Updated Menu';
			}
			$this->output->set_output(json_encode($response));
		} else {
			exit('Proses Tidak Dapat Dilanjutkan');
		}
	}

	function delete($id_menu)
	{
		if ($this->input->is_ajax_request()) {
			$this->Menu_Model->delete(encrypt_decrypt('decrypt',$id_menu));
			$this->output->set_output(json_encode(['sukses' => true, 'alert' => 'Successfully Deleted Data']));
		} else {
			exit('Proses Tidak Dapat Dilanjutkan');
		}
	}


	private function _validation()
	{
		$this->form_validation->set_rules('menu_parent', 'Jenis Menu', 'trim|required', ['required' => '%s Belum Dipilih!!']);
		$this->form_validation->set_rules('menu_title', 'Menu Title', 'trim|required', ['required' => '%s Cannot Be Null!!']);
		$this->form_validation->set_rules('menu_url', 'Menu Url', 'trim|required', ['required' => '%s Cannot Be Null!!']);
		$this->form_validation->set_rules('icon', 'Icon', 'trim|required', ['required' => '%s Belum Dipilih!!']);
		$this->form_validation->set_rules('have_link', 'Have a Link', 'trim|required', ['required' => '%s Belum Dipilih!!']);
		$this->form_validation->set_error_delimiters('', '');
		return $this->form_validation->run();
	}

}

/* End of file Menu.php */
/* Location: ./application/controllers/cms/Menu.php */