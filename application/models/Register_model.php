<?php

class Register_model extends CI_Model
{
	public function __construct()
	{
		$this->load->database();
	}

	public function register($client_number,$client_password)
	{
		$client_number = $this->db->escape_str($client_number);
		$client_number = $this->db->escape_str($client_password);

		$ans = array(
			'status' => 'Status_ok'
			'info'   => ''
			);

		if(!is_numeric($client_number))	//Не число
		{
			$ans["status"] ='Status_false';
			$ans["info"] = "Введенное поле не является номером";

			return $ans;
		}	

		//Дальнейшие проверки...

		$sql = "SELECT number FROM `clients` WHERE number = ?";
		$client = $this->db->query($sql,array($client_number));

		if($client[0])//Клиент с таким номеров уже существует
		{
			$ans["status"] = 'Status_false';
			$ans["info"] = "Клиен с таким номером телефона уже существует";

			return $ans;
		}

		$sql = "INSERT INTO `clients` (number,password) VALUES(".$this->db->escape($client_number).", ".$this->db->escape($client_password).")";
		$client = $this->db->query($sql,array($client_number,$client_password);

		if($client)
		{
			$ans['info'] = "Успешная регистрация";

			return $ans;
		}
		else
		{
			$ans["status"] => 'Status_false';
			$ans["info"] = "Ошибка";

			return $ans;
		}

		return $ans;
	}

	public function authorization($client_number,$client_password)
	{
		$sql = "SELECT number FROM `clients` WHERE number = ?";
		$client = $this->db->query($sql,array($client_number));

		$ans = array(
			'status' => 'Status_ok'
			'info'   => ''
			);

		if(!$client)
		{
			$ans["status"] = "Status_false";
			$ans["info"]   = "Пользователя с таким номером не существует";

			return $ans;

		}

		if(password_verify($client[0]->password,$client_password))
		{
			$ans["status"] = "Status_ok";
			$ans["info"]   = "Успешная авторизация";

			return $ans;

		}else
		{
			$ans["status"] = "Status_false";
			$ans["info"]   = "Не верный пароль";

			return $ans;

		}
	}
	
}

?>