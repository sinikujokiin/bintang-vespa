<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Role_Model extends CI_Model {

	var $table = 'roles';
	var $primary = 'id_role';
	
	function insert($data)
	{
		$this->db->insert($this->table, $data);
	}

	function update($id_role, $data)
	{
		$this->db->update($this->table, $data, [$this->primary => $id_role]);
		// var_dump($this->db->last_query($query));die;
	}

	function delete($id_role)
	{
		softDelete($this->table, [$this->primary => $id_role]);
	}

	function getDataById($id_role)
	{
		$query = $this->db->get_where($this->table, [$this->primary => $id_role]);
		return $query;
		// var_dump($this->db->last_query($query));die;
	}

	public function hapusAkses($param)
	{
		$this->db->delete('users_access',$param);
	}

	public function tambahAkses($data)
	{
		$this->db->insert_batch('users_access',$data);
	}

	function get_menu_child_by_role($id_role,$menu_parent)
	{

		$this->db->select('menus.id_menu, menu_title, users_access.role_id, have_link');
		$this->db->from('menus');
		$this->db->join('users_access', 'users_access.menu_id = menus.id_menu AND users_access.role_id = '.$id_role, 'LEFT');
		$this->db->where('menus.menu_parent', $menu_parent);
		$this->db->where('menus.type', 'cms');
		$this->db->where('menus.deleted_at', null);
		$this->db->order_by('sort', 'ASC');
		return $this->db->get()->result_array();
	}

}

/* End of file KategoriRole_Model.php */
/* Location: ./application/models/KategoriRole_Model.php */