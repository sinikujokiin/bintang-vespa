<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Sorting extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		cekLogin();
		// $this->load->model('Datatable_Model');
		$this->load->model('Menu_Model');
	}
	public function index()
	{
		$data = [
			'title' => 'Sorting Menu',
		];
		$this->template->load('templates/cms', 'cms/sorting', $data);
	}

	function getSortingMenu($tipe)
	{


		if ($this->input->is_ajax_request()) {
			$html = '
			<div class="dd dd-' . $tipe . '" id="nestable3">
				<ol class="dd-list">';
			$menu = $this->Menu_Model->getMenu(0, $tipe);

			for ($i = 0; $i < count($menu); $i++) {

				$html .= '
			        <li class="dd-item dd3-item" data-id="' . $menu[$i]['id_menu'] . '">
			            <div class="dd-handle dd3-handle">Drag</div><div class="dd3-content">' . $menu[$i]['menu_title'] . '</div>';

				$childmenu = $this->Menu_Model->getMenu($menu[$i]['id_menu'], $tipe);

				if (count($childmenu) > 0)
					$html .= '  <ol class="dd-list">';

				for ($j = 0; $j < count($childmenu); $j++) {

					$html .= '<li class="dd-item dd3-item" data-id="' . $childmenu[$j]['id_menu'] . '">
			            <div class="dd-handle dd3-handle">Drag</div><div class="dd3-content">' . $childmenu[$j]['menu_title'] . '</div>';

					$grandchildmenu = $this->Menu_Model->getMenu($childmenu[$j]['id_menu'], $tipe);

					if (count($grandchildmenu) > 0)
						$html .= '     <ol class="dd-list">';

					for ($k = 0; $k < count($grandchildmenu); $k++) {

						$html .= '     		<li class="dd-item dd3-item" data-id="' . $grandchildmenu[$k]['id_menu'] . '">
			            <div class="dd-handle dd3-handle">Drag</div><div class="dd3-content">' . $grandchildmenu[$k]['menu_title'] . '</div>';
					}

					if (count($grandchildmenu) > 0)
						$html .= '      </ol>';

					$html .= '  </li>';
				}

				if (count($childmenu) > 0)
					$html .= '
	                 </ol>';


				$html .= '
	              </li>';
			}

			$html .= '
				</ol>
			</div>
			';
			$this->output->set_output(json_encode($html));
		} else {
			exit('Proses Tidak Dapat Dilanjutkan');
		}
	}


	function changePosition($tipe)
	{

		if ($this->input->is_ajax_request()) {
			$data = $this->input->post('data');
			$n1 = 1;

			if ($tipe == 'cms') {
				$flaglink = 0;
			}else{
				$flaglink = 1;
			}
			foreach ($data as $parent) {
				$data_parent = [
					'have_link' => $flaglink,
					'sort' => $n1++,
					'menu_parent' => 0,
				];
				$param_parent = [
					'id_menu' => $parent['id']
				];
				$this->Menu_Model->changePositionMenu($data_parent, $param_parent);

				$n2 = 1;
				if (isset($parent['children'])) {
					foreach ($parent['children'] as $child) {
						if (isset($child['children'])) {
							$data_child = [
								'have_link' => 0,
								'sort' => $n2++,
								'menu_parent' => $parent['id'],
							];

							$n3 = 1;
							foreach ($child['children'] as $grandchild) {
								$data_grandchild = [
									'have_link' => 1,
									'sort' => $n3++,
									'menu_parent' => $child['id'],
								];
								$param_grandchild = [
									'id_menu' => $grandchild['id']
								];
								$this->Menu_Model->changePositionMenu($data_grandchild, $param_grandchild);
							}
						} else {
							$data_child = [
								'have_link' => 1,
								'sort' => $n2++,
								'menu_parent' => $parent['id'],
							];
						}
						// var_dump($data_child);
						$param_child = ['id_menu' => $child['id']];
						// var_dump($param_child);
						$this->Menu_Model->changePositionMenu($data_child, $param_child);
					}
				}
			}
			// die;


			$this->output->set_output(json_encode(['status' => true]));
		} else {
			exit('Proses Tidak Dapat Dilanjutkan');
		}
	}
}

/* End of file Sorting.php */
/* Location: ./application/controllers/cms/Sorting.php */