<?php

namespace app;

use models\TasksModel;
use app\Session;

class Controller
{

	public $view;
	public $data_error = array();
	public $data_from_model_user = array();

	public function __construct()
	{
		$this->Session = new Session;
		Session_start();
		if(!empty($_SESSION))
		{
				$this->data_from_model_user = $_SESSION;
		}

		$this->TasksModel = new TasksModel;
		$this->View = new View;
	}

	public function Authorization()
	{
		if(!empty($_POST) && !empty($_POST['login']) && !empty($_POST['password']))
		{
				$array_auth = array(
					'login' => $_POST['login'],
					'password' => $_POST['password']
				);

				if(!$this->TasksModel->Authorization_model($array_auth))
				{
					$this->data_error['error'] = $this->TasksModel->data_from_model;
					return false;
				}
				else
				{
					$this->data_from_model_user = $_SESSION;
					return true;
				}
		}
		else
		{
				$this->data_error['error'] = 'Заполните обязательные поля';
				return false;
		}
	}

	public function Work_with_table($action, $table)
	{
		$method = $action.'_model';
		if($method == 'Update_task_status_model')
		{
			$array_task = array(
				'id_task' => $_POST['id']
			);
			if($this->TasksModel->$method($array_task, $table))
			{
				return true;
			}
		}
		else
		{
			if(!empty($_POST) && !empty($_POST['user_name_task']) && !empty($_POST['user_email_task']) && !empty($_POST['text_task']))
			{
				if (filter_var($_POST['user_email_task'], FILTER_VALIDATE_EMAIL))
				{
				// тут можно провести дополнительную проверку но за это отвечает метод Db->input_protect()
					$array_task = array(
						'user_name_task' 	=> $_POST['user_name_task'],
						'user_email_task' => $_POST['user_email_task'],
						'text_task' 			=> $_POST['text_task'],
						'id_task' 				=> $_POST['id']
					);

					if(!$this->TasksModel->$method($array_task, $table))
					{
						$this->data_error['error'] = $this->TasksModel->data_from_model;
						return false;
					}
					else
					{
						return true;
					}
				}
				else
				{
						$this->data_error['error'] = 'Укажите корректный e-mail';
						return false;
				}
			}
			else
			{
					$this->data_error['error'] = 'Заполните обязательные поля';
					return false;
			}
		}
	}

	public function Login_out()
	{
		if($this->TasksModel->Login_out_model())
		{
				return true;
		}
		else
		{
				return false;
		}
	}

}
