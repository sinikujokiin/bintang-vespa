<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Setting_Model extends CI_Model {
	var $table = 'setting';
	var $primary_key = 'id_web';
	function getData()
	{
		return $this->db->get($this->table)->row_array();
	}


	function update($id, $data)
	{
		$this->db->update($this->table, $data, [$this->primary_key => $id]);
	}

}

/* End of file Website_Model.php */
/* Location: ./application/models/Website_Model.php */