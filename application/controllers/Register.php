<?php
class Register extends CI_Controller
{
	public function register($json_data)
	{	
		$this->load->model('Register_model');
		
		$json_data = json_decode($json_data);

		$client_number   = $json_data["client_number"];
		$client_password = $json_data["client_password"];

		$client_password = password_hash($client_password, PASSWORD_DEFAULT);

		$ans = $this->Register_model->register($client_number,$client_password);

		$json_answer = json_encode($ans);

		var_dump($json_answer);
	}

	public function authorization($json_data)
	{	
		$this->load->model('Register_model');
		
		$json_data = json_decode($json_data);

		$client_number = $json_data["client_number"];
		$client_password = $json_data["client_password"];


		$ans = $this->Register_model->authorization($client_number,$client_password);

		$json_answer = json_encode($ans);

		var_dump($json_answer);
	}
}

?>
