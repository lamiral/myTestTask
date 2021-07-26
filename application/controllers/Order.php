<?php

class Order extends CI_Controller
{

	/*
		Все методы класса Products возвращают данные в JSON формате.
	*/

	private $status_ok = array(
		'status' => 'status_ok'
		);

	private $status_not_ok = array(
		'status' => 'SomeErrorMessage'
		);
	
	/*
		Метод Order::get_order_head() возвращает шапку данного заказа
	*/
	
	private function get_order_head($order)
	{	
		$order_head = array();
		foreach($order as $table_field => $table_value)
		{
			$order_head[$table_field] = $table_value;
		}
		return $order_head;
	}
	
	/*
		Метод Order::is_order_exist() проверяет наличие заказа в базе
	*/
	
	private function is_order_exist($order_id)
	{
		$this->load->model('Order_model');
		$order = $this->Order_model->get_order_by_id($order_id);
		
		if($order)	//Проверка существования заказа
		{
			return false;
		}
		return $order;
	}
	
	/*
		Метод Order::get_order_items() возвращает строки заказа
			по данному id заказа.
	*/
	
	private function get_order_items($order_id)
	{	
		$this->load->model('Products_model');
		$order_items = $this->Order_model->get_orderItems_by_id($order_id);
	
		$items_array = array();
		
		
		#$prices = $this->Products_model->get_price_by_order($order_id);
		
		foreach ($order_items as $item) 
		{	
			#$price = "";
			
			/*foreach($prices as $price)
			{
				if($price->product_id == $item->product_id)
				{	
					$item_str = array(
					'product_id' 	=> $item->product_id,
					'product_count' => $item->product_count,
					'price' 		=> $price->price
					);
				}
			}
			*/
			array_push($items_array, $item);
		}
		
		return $items_array;
	}
	
	/*
		Метод Order::attach_order_head() присоединяет шапку заказа
	*/
	
	private function attach_order_head($order_head,$order)
	{
		$result_order = array(
			'head'  => array(),
			'items' => array()
		);
		$result_order['head'] = $order_head;
		return $result_order;
	}
	
	/*
		Метод Order::attach_order_items() присоединяет строки заказа
	*/
	
	private function attach_order_items($order,$items)
	{	
		$order['items'] = $items;
		return $order;
	}
	
	/*
		Метод Order::create(). Принимает JSON объект заказа, добавляет в БД.
	*/

	public function create($json_order) //Создаю заказ
	{
		$order = json_decode($json_order);
		
		$header_order = array(
			#'data' 	  => $order["header"]["data"],
			'name'    =>$order["client"]["client_name"],
			'number'  =>$order["client"]["client_number"],
			'status'  =>$order["header"]["status"],
			'comment' =>$order["header"]["comment"]
			);

		
		if($order = $this->Order_model->create($header_order,$order['products']))
		{
			$json_answer = json_encode($this->status_ok);
		}
		else
		{
			$json_answer = array(
				'Status' => "Status_false",
				'Error_message' => "Пользователь не был создан"
			);
		}
		var_dump($json_answer);
	}

	/*
		Метод Order::get_by_id(). Возвращает заказ по id заказа.
	*/

	public function get_by_id($order_id) // Возвращаю заказ 
	{	
		$this->load->model("Order_model");
		$order = $this->Order_model->get_order_by_id($order_id);
		
		if(!$order)	//Проверка существования заказа
		{
			$json_answer = array(
				'Status' => 'Status_false',
				'Error_message' => 'Такой заказ не существует'
				);
			$json_answer = json_encode($json_answer);

			var_dump($json_answer);
		}

		#$order = $this->Order_model->get_order_by_id($order_id);
		
		$order_head = $this->get_order_head($order);
		$items 		= $this->get_order_items($order_id);
		
		$result_order = $this->attach_order_head($order_head,$order);
		$result_order = $this->attach_order_items($result_order,$items);
		
		$json_answer = $result_order;
		array_push($json_answer, $this->status_ok);
		
		$json_answer = json_encode($json_answer);

		var_dump($json_answer);
	}	

	/*
		Метод Order::cansel_order(). Отменяет заказ с данным id
	*/

	public function cansel($order_id)	  // Удаляю заказ из базы
	{
		$this->load->model('Order_model');
		$delete = $this->Order_model->cansel($order_id);

		if($delete)
		{
			$json_answer = array(
				'Status' => 'Status_ok'
				);
		}
		else
		{
			$json_answer = array(
				'Status' => 'Status_false',
				'Error_message' => 'Не получилось отменить заказ'
				);
		}
		var_dump($json_answer);
	}
}

?>