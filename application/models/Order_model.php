<?php

class Order_model extends CI_Model
{	
	const ORDERS_TABLE 	     = 'Orders';
	const ORDERS_ITEMS_TABLE = 'orders_items';
	const ORDER_ID           = 'order_id';
	
	/*
		Метод Order_model::is_select_ok() 
			проверяет наличие записей в результате запроса
	*/
	
	private function is_select_ok($query)
	{
		if($query->num_rows() == 0) return false;
		else 					    return true;
	}
	
	public function __construct()
	{
		$this->load->database();
	}
	
	/*
		Метод Order_model::get_order_by_id() 
			возвращает шапку заказа по данному id заказа.
	*/
	
	public function get_order_by_id($order_id)
	{	
		$sql = 'SELECT * FROM orders WHERE order_id = ?';
		$query = $this->db->query($sql,array($order_id));
		
		if(!$this->is_select_ok($query)) return false;
		return $query->row();
	}
	
	/*
		Метод Order_model::get_orderItems_by_id() 
			возвращает строки заказа по данному id заказа
	*/
	
	public function get_orderItems_by_id($order_id)
	{
		$sql1 = 'SELECT orders_items.id,orders_items.product_id,orders_items.order_id,orders_items.product_count,products.price
					FROM orders_items,products 
						WHERE products.product_id = orders_items.product_id AND orders_items.order_id = ?';
		$sql = "SELECT * FROM orders_items WHERE order_id = ?";
		
		$query  = $this->db->query($sql1,array($order_id));
		
		if(!$this->is_select_ok($query)) return false;
		
		return $query->result();
	}

	/*
		Метод Order_model::create() записывает заказ в БД
	*/
	
	public function create($header,$order_items)
	{	
		$this->db->trans_start();
		
		$order_date = array();
	
		foreach($header as $header_field => $value)
		{
			$order_date[$header_field] = $value;
		}
		
		$query = $this->db->insert(self::ORDERS_TABLE,$order_date);

		if(!$query)
		{
			return false;
		}
		
		$order_insert_items = array();
		
		foreach($order_items as $order_item)
		{	
			$order_item = array(
				'product_id' 	=> $order_items['product_id'],
				'order_id'   	=> $header["order_id"],
				'product_count' => $order_items['product_count']
			);
			array_push($order_insert_items,$order_item);
		}
		
		$result = $this->db->insert(self::ORDERS_ITEMS_TABLE,$order_insert_items);
		
		$this->db->trans_complete();
		
		return $result;
	}

	/*
		Метод Order_model::cansel() отменяет заказ с данным id
	*/
	
	public function cansel($order_id)
	{	
		$update = array(
			'status' => 'Отменен'
		);
		
		$this->db->where(self::ORDER_ID,$order_id);
		$query = $this->db->update(SELF::ORDERS_TABLE,$update);
		
		if($query) return true;
		else       return false;
	}
}

?>
