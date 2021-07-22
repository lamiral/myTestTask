<?php

class Order_model extends CI_Model
{
	public function __construct()
	{
		$this->load->database();
	}

	public function get_order_by_id($order_id)
	{	
		$sql = 'SELECT * FROM my_order WHERE order_id = ?';
		$query = $this->db->query($sql,array($order_id));

		return $query->result();
	}

	public function get_orderItems_by_id($order_id)
	{
		$sql = 'SELECT * FROM order_item WHERE order_id = ?';

		$query = $this->db->query($sql,array($order_id));

		return $query->result();
	}

	public function create($client,$header,$products)
	{	
		#$sql = 'INSERT INTO order(status,client_name,client_number,comment) VALUES ('.$this->db->escape($header['status']).','.$this->db->escape($header['comment'].')';
		$this->db->query($sql,array());

		foreach($products as $product)
		{	
			$sql = "INSERT INTO Products "
		}

		#$this->db->
	}

	public function cansel($order_id)
	{	
		$query = $this->db->query('DELETE FROM `order` WHERE order_number = '.$order_id);
		$query = $this->db->query('DELETE FROM `order_item` WHERE order_id = '.$order_id);
	}
}

?>