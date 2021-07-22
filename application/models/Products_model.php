<?php

class Products_model extends CI_Model
{	
	public function __construct()
	{
		$this->load->database();
	}

	/*
		Вспомогательный метод. Возвращает массив картинок продукта с идентификатором product_id
	*/

	private function get_images($product_id)
	{
		$sql = "SELECT hight_url, low_url FROM images WHERE product_id = ?";

		$query = $this->db->query($sql,array($product_id));

		return $query->result();
	}

	/*
		Вспомогательный метод. Формирует результирующий вид продукта - данные + картинки.
	*/

	private function create_result_products($products)
	{
		$result_products = array();


		foreach($products as $product)
		{
			$result_product = array(
				'id'  	 => $product->id,
				'name'   => $product->name,
				'price'  => $product->price,
				'group'  => $product->group_product,
				'info'   => $product->info,
				'images' => array()				// Массив картинок
				);

			foreach ($this->get_images($product->id) as $image)
			 {	
			 	$img = array(
			 		'low_url' 	=> $image->low_url,
			 		'hight_url' =>$image->hight_url
			 		);
				array_push($result_product['images'], $img);	
			 }

			 array_push($result_products,$result_product);
		}

		return $result_products;
	}

	public function get_price_by_id($product_id)
	{
		$sql = "SELECT price FROM Products WHERE id = ?";
		$price_query = $this->db->query($sql,array($product_id));

		$price = $price_query->result()[0]->price;

		return $price;
	}


	public function get_all()
	{
		$query = $this->db->get('Products');
		$products = $query->result();

		$result_products = $this->create_result_products($products);

		return $result_products;
	}

	public function get_by_id($product_id)
	{	
		$product_id = $this->db->escape_str($product_id);

		$query = $this->db->query('SELECT * FROM Products WHERE id ='.$product_id);
		$product = $query->result();
		$product = $product[0];

		$result_product = array(
				'id'  	 => $product->id,
				'name'   => $product->name,
				'price'  => $product->price,
				'group'  => $product->group_product,
				'info'   => $product->info,
				#'images' => array()
				);
			/*foreach ($this->get_images($product->id) as $image)
			 {	
			 	$img = array(
			 		'low_url' 	=> $image->low_url,
			 		'hight_url' =>$image->hight_url
			 		);
				array_push($result_product['images'], $img);	
			 }
			*/

		return $result_product;
	}

	public function get_group($group)
	{	
		$group = $this->db->escape_str($group);

		$sql = 'SELECT * FROM Products WHERE group_product= ? ';
		$products_group = $this->db->query($sql,array($group));

		$result_products_group = $this->create_result_products($products_group->result());

		return $result_products_group;
	}
}
?>