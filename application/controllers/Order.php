<?php

class Order extends CI_Controller
{

	/*
		Все методы класса Products возвращают данные в JSON формате.
	*/

	public $status_ok = array(
		'status' => 'status_ok'
		);

	public $status_not_ok = array(
		'status' => 'SomeErrorMessage'
		);

	/*
		Метод create(). Принимает JSON объект заказа, добавляет в БД.
	*/

	public function create($json_order) //Создаю заказ
	{
		$order = json_decode($json_order);

		$client = array(
			'name'   => $order["client"]["client_name"],
			'number' =>  $order["client"]["client_number"],
			);

		$header_order = array(
			#'data' 	  => $order["header"]["data"],
			'status'  =>$order["header"]["status"],
			'comment' =>$order["header"]["comment"]
			);


		if($this->Order_model->create($client,$header_order,$order['order_items']))
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
		Метод get_by_id(). Возвращает заказ по id заказа.
	*/

	public function get_by_id($order_id) // Возвращаю заказ 
	{
		$this->load->model('Order_model');
		$this->load->model('Products_model');

		$order = $this->Order_model->get_order_by_id($order_id);
		
		if(!$order)	//Проверка существования заказа
		{
			$json_answer = array(
				'Status' => 'Status_false',
				'Error_message' => 'Такой заказ не существует'
				);
			$json_answer = json_encode($json_answer);

				var_dump($json_answer)
		}

		$order = $order[0];
		$order_head = array(
			'head' => 
			array('order_id' => $order->order_id,
			'date' 		   => $order->date,
			'status' 	   => $order->status,
			'client_name'  => $order->client_name,
			'comment'      => $order->comment)
			);

		$json_answer = array();

		array_push($json_answer, $order_head);

		$order_items = $this->Order_model->get_orderItems_by_id($order_id);

		$items_array = array();

		foreach ($order_items as $item) 
		{	
			$price= $this->Products_model->get_price_by_id($item->product_id);

			$item_str = array(
				'item_id' 	    => $item->id,
				'product_count' => $item->product_count,
				'price' 		=> $price
				);

			array_push($items_array, $item_str);
		}

		array_push($json_answer, array("items" => $items_array));

		array_push($json_answer, $this->status_ok);

		$json_answer = json_encode($json_answer);

		var_dump($json_answer);
	}	

	/*
		Метод cansel_order(). Отменяет заказ с данным id
	*/

	public function cansel_order($order_id)	  // Удаляю заказ из базы
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
		return json_encode($json_answer);
	}
}

?>