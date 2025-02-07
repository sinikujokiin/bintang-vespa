<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Menu_Model extends CI_Model {

	var $table = 'menus';
	var $primary = 'id_menu';

	function getParent($type)
	{
		$this->db->select(
			''.$this->table.'.id_menu,'.$this->table.'.menu_parent,
			(select (select b.menu_title from '.$this->table.' as b where b.id_menu = a.menu_parent) from '.$this->table.' as a where a.id_menu = '.$this->table.'.menu_parent) as menu_parent_parent_title,
			(select c.menu_title from '.$this->table.' as c where c.id_menu = '.$this->table.'.menu_parent) as menu_parent_title,'.$this->table.'.menu_title,'.$this->table.'.menu_url,'.$this->table.'.have_link,'.$this->table.'.sort');
		$this->db->from($this->table, 'a');
		$this->db->where('type', $type);
		$this->db->order_by('menu_parent', 'asc');
		$this->db->order_by('sort', 'asc');
		return $this->db->get();
	}

	function getDataById($id_menu)
	{
		$query = $this->db->get_where($this->table, [$this->primary => $id_menu]);
		return $query;
		// var_dump($this->db->last_query($query));die;
	}

	function insert($data)
	{
		$this->db->insert($this->table, $data);
	}

	function update($id_menu, $data)
	{
		$this->db->update($this->table, $data, [$this->primary => $id_menu]);
		// var_dump($this->db->last_query($query));die;
	}

	function delete($id_menu)
	{
		softDelete($this->table, [$this->primary => $id_menu]);
	}


	function getMenu($menu_parent, $type)
	{
		$this->db->select('id_menu, menu_parent, menu_title, menu_url, have_link');
		$this->db->where('menu_parent', $menu_parent);
		$this->db->where('type', $type);
		$this->db->where('deleted_at', null);
		$this->db->order_by('sort', 'ASC');
		$query = $this->db->get($this->table)->result_array();
		return $query;
	}

	function changePositionMenu($data,$param)
	{
		$this->db->update($this->table,$data,$param);
	}

}

/* End of file Menu_Model.php */
/* Location: ./application/models/Menu_Model.php */