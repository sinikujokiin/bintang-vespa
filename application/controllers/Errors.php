<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Errors extends CI_Controller {

	public function error403()
	{
		$data = [
			'title' => '403 Access Denied',
		];
		$this->template->load('templates/cms', 'errors/403', $data);
	}

	public function error404()
	{
		$data = [
			'title' => '404 Page Not Found',
		];
		if ($this->uri->segment(1) == 'cms') {
			cekLogin();
			$this->template->load('templates/cms', 'errors/404', $data);
		}else{
			$data['breadcrumb'] = breadcrumb($data['title'], true);
			loadView('templates/landing', 'errors/404', $data);
			// $this->template->load('templates/landing', 'errors/404', $data);
		}
	}

}

/* End of file Error.php */
/* Location: ./application/controllers/Error.php */