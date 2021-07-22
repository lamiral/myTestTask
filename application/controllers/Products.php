<?php

//Все это должен вернуть в формате JSON

class Products extends CI_Controller
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
		Метод get_all возвращает все записи таблицы товаров вместе с картинками
	*/
		
	public function get_all()
	{
		$this->load->model('Products_model');
		$products = $this->Products_model->get_all();	

		$json_anwer = $products;

		$json_anwer = json_encode($json_anwer);
		
		var_dump($json_anwer);
	}

	/*
		Метод get_by_id возвращает товар по идентификатору
	*/
	public function get_by_id($id)
	{
		$this->load->model('Products_model');
		$product = $this->Products_model->get_by_id($id);
		
		$json_anwer = json_encode($product);
		

		var_dump($json_anwer);
	}


	/*
		Метод	get_by_group возвращает список товаров из данной группы
	*/
	public function get_by_group($group)
	{
		$this->load->model('Products_model');
		$products = $this->Products_model->get_group($group);

		$json_anwer = json_encode($products);

		var_dump($json_anwer);
	}
}

?>