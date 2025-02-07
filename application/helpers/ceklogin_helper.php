<?php 

	function cekLogin()
	{
		$CI=get_instance();
		if (!$CI->input->is_ajax_request()) {
			$CI->session->set_userdata('redirect', current_url());
		}
		if (empty($CI->session->userdata('userData'))) {
			$CI->session->set_userdata('workshop_id', $CI->input->get('id'));
			redirect(base_url('login'));
		}else{
			$role = $CI->session->userdata('userData')['role_id'];
			$uname = $CI->session->userdata('userData')['username'];

			$segs = $CI->uri->segment_array();
			$totalSegs = count($segs);
			$link = '';
			for ($i = 1; $i <= $totalSegs; $i++) {
			    if ($segs[$i] === $segs[$totalSegs]) {
			        $link .= $segs[$i];
			    } else {
			        $link .= $segs[$i] . "/";
			    }
			}



			$menu = $CI->db->get_where('menus', ['menu_url' => $link, 'type' => 'cms'])->row();
			if ($menu) {
				$akses = $CI->db->get_where('users_access', ['role_id' => $role, 'menu_id' => $menu->id_menu]);
				// var_dump($CI->db->last_query());die;
				if ($akses->num_rows() < 1 && $uname != 'admin') {
					redirect('error-403');
				}
			}
		}
	}

 ?>