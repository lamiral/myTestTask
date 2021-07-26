<?php

class Products_model extends CI_Model
{		
	/* Табличные константы */
	
	const IMAGE_TABLE 	 = 'products_images';
	
	const PRODUCTS_TABLE = 'products';
	const PRODUCT_ID     = 'product_id';
	const PRODUCT_GROUP  = 'group';
	
	public function __construct()
	{
		$this->load->database();
	}
	
	/*
		Метод Products_model::is_select_ok()
			проверяет наличие записей в результате запроса
	*/
	
	private function is_select_ok($query)
	{
		if($query->num_rows() == 0) return false;
		else 					    return true;
	}

	/*
		Метод Products_model::get_all() 
			возвращает массив всех картинок для всех продуктов 
	*/
	
	private function get_all_images()
	{
		$images = $this->db->get(self::IMAGE_TABLE);
		return $images;
	}

	/*
		Метод Products_model::get_all_images_group()
			возвращает массив всех картинок для всех продуктов из данной группы
	*/
	
	private function get_all_images_group($group)
	{
		$sql = 'SELECT products_images.low_url,products_images.hight_url,products_images.product_id 
					FROM products_images 
						WHERE products_images.product_id IN(
							SELECT products.product_id FROM products WHERE products.group = '.$this->db->escape($group).')';
		
		$images = $this->db->query($sql);
		return $images->result();
	}
	
	/*
		Метод Products_model::get_images_by_id() 
				возвращает массив картинок продукта с идентификатором product_id
	*/
	
	private function get_images_by_id($product_id)
	{
		$images = $this->db->from(self::IMAGE_TABLE);
		$images = $this->db->where(self::PRODUCT_ID,$product_id);
		$images = $images->get();
		
		return $images->result();
	}
	
	/*
		Метод Products_model::get_all_products() 
			возвращает все продукты(товары)
	*/
	private function get_all_products()
	{
		$products = $this->db->get(self::PRODUCTS_TABLE);
		
		return $products;
	}
	
	/*
		Метод Products_model::get_products_group(() 
			возвращает все продукты(товары) из данной группы
	*/
	
	private function get_products_group($group)
	{
		$products = $this->db->from(self::PRODUCTS_TABLE);
		$products = $this->db->where(self::PRODUCT_GROUP,$group);
		
		$products = $this->db->get();

		return $products;
	}
	
	/*
		Метод Products_model::get_product_by_id() 
			возвращает продукт(товар) по идентификатору(id)
	*/
	
	private function get_product_by_id($product_id)
	{
		$product = $this->db->where(self::PRODUCT_ID,$product_id);
		$product = $this->db->from(self::PRODUCTS_TABLE);

		return $this->db->get();
	}
	
	/*
		Метод Products_model::esult_product() 
			формирует "вид" товара
	*/
	
	private function result_product($product)
	{		
		$result_product = array();
			
		foreach($product as $table_field => $value_field)
		{
			$result_product[$table_field] = $value_field;
		}
			
		$result_product['images'] = array();
			
		return $result_product;
	}
	
	/*
		Метод Products_model::create_result_product()
			возвращает результирующий вид продукта, вместе с картинками
	*/
	
	private function create_result_product($product,$images)
	{
		$result_product = $this->result_product($product);
		$id = self::PRODUCT_ID;
		foreach($images as $image)
		{	
			if($image->$id == $product->$id)
			{	
				array_push($result_product['images'],$image);
			}
		}	
		return $result_product;
	}
		
	/*
		Метод Products_model::create_result_products()
			возвращает результирующий вид продуктов, вместе с картинками
	*/
	
	private function create_result_products($products,$images)
	{
		$result_products = array();

		foreach($products as $product)
		{
			$result_product = $result_product = $this->result_product($product);

			foreach ($images as $image)
			 {	
				array_push($result_product['images'], $image);	
			 }
			 array_push($result_products,$result_product);
		}
		return $result_products;
	}
	
	/******************* ИНТЕРФЕЙС КЛАССА Products_model **************************/
	
	/*
		Метод Products_model::get_price_by_id() 
			возвращает цену товара(продукта) с данным id товара
	*/
	public function get_price_by_id($product_id)
	{
		$sql = "SELECT price FROM products WHERE product_id = ?";
		$price_query = $this->db->query($sql,array($product_id));
		
		$price = $price_query->row();

		return $price;
	}
	
	/*
		Метод Products_model::get_price_by_order() 
			возвращает цену товара(продукта) с данным id заказа
	*/
	
	public function get_price_by_order($order_id)
	{
		$sql = "SELECT products.price,products.product_id FROM products 
					WHERE products.product_id IN
						(SELECT orders_items.product_id  FROM orders_items 
							WHERE orders_items.order_id = ".$this->db->escape($order_id).")";
		$prices = $this->db->query($sql);
		return $prices->result();
	}

	/*
		Метод Products_model::get_all() 
			возвращает все товары
	*/
	
	public function get_all()
	{	
		$products = $this->get_all_products();
		$images   = $this->get_all_images();
		
		$result_products = $this->create_result_products($products->result(),$images->result());
		
		return $result_products;
	}
	
	/*
		Метод Products_model::get_by_id() 
			возвращает товар с данным id
				В случае, если товара с данным id не в базе, 
					вернется ответ "Нет товара с таким id"
	*/
	
	public function get_by_id($product_id)
	{
		$product = $this->get_product_by_id($product_id);
		$images  = $this->get_images_by_id($product_id);
		
		if(!$this->is_select_ok($product))
		{
			$answer = "Нет товара с таким id";
			return $answer;
		}
		
		$result_product = $this->create_result_product($product->row(),$images);
		
		return $result_product;
	}
	
	/*
		Метод Products_model::get_by_group() возвращает товары из данной группы
			В случае, если товаров в данной группе нет в базе, 
					вернется ответ "Нет заказов с такой группы".
	*/
	
	public function get_by_group($group)
	{	
		$images   = $this->get_all_images_group($group);
		$products = $this->get_products_group($group);
		
		if(!$this->is_select_ok($products))
		{
			$answer = "Нет заказов с такой группы";
			return $answer;
		}
		
		$result_products_group = $this->create_result_products($products->result(),$images);
		
		return $result_products_group;
	}
}
?>