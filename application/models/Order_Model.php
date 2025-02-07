<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Order_Model extends CI_Model {

	function getDetailOrder($id_order)
	{
		$this->db->select('*, orders.status as status_order');
		$this->db->join('users', 'users.id_user = orders.user_id');
		$this->db->join('orders_detail', 'orders_detail.orders_id = orders.id');
		$this->db->join('products', 'products.id_product = orders_detail.product_id');
		$this->db->where('orders.id', $id_order);
		return $this->db->get('orders')->result_array();
	}

}

/* End of file Order_Model.php */
/* Location: ./application/models/Order_Model.php */