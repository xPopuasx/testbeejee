<?

namespace controllers;

use models\TasksModel;

class HomeController extends \app\Controller
{


  public function ActionTasks()
  {
      $TaskModel = new TasksModel;
      $this->data_from_model['auth']  = $TaskModel->Session_inform();
      $action = $_POST['action'];
      $action_get = $_GET['action'];
      switch ($action)
      {
        case 'auth':
          if(!$this->Authorization())
          {
            $this->data_from_model['error_msg'] = $this->data_error['error'];
          }
        break;
          case 'add_task':
            if(!$this->Work_with_table('Add_task', 'tasks'))
            {
              $this->data_from_model['error_msg'] = $this->data_error['error'];
            }
            else
            {
              $this->data_from_model['success'] = 'Задача успешно добавлена!';
            }
          break;
          case 'update_task':
          if(!empty($_SESSION))
          {
            if(!$this->Work_with_table('Update_task', 'tasks'))
            {
              $this->data_from_model['error_msg'] = $this->data_error['error'];
            }
            else
            {
              $this->data_from_model['success'] = 'Задача успешно отредактирована!';
            }
          }
          break;
          case 'update_task_status':
          if(!empty($_SESSION))
          {
            if($this->Work_with_table('Update_task_status', 'tasks'))
            {
              $this->data_from_model['success'] = 'Статус успешно изменён!';
            }
          }
          break;
        case 'loginOut':
            if($this->Login_out())
            {
                header('Location:'.$_SERVER["HTTP_REFERER"]);
            }
        break;
      }

      $this->data_from_model['tasks'] = $TaskModel-> Sort_task_all();
      $this->data_from_model['task_pagination'] = $TaskModel->Pagination($this->data_from_model['tasks'], 3);
      switch($action_get)
      {
          case 'sort':
            $this->data_from_model['tasks'] = $TaskModel->Sorting_tasks($_GET);
          break;
      }
      $tasks_chunk = array_chunk($this->data_from_model['tasks'], 3, true);
      if(!isset($_GET['page']) || intval($_GET['page'])==0)
      {
        $page = 1;
      }
      else
      {
        $page = $_GET['page'];
      }
      $page = $page - 1;
      $this->data_from_model['tasks'] = $tasks_chunk[$page];
      $this->data_from_model['user'] = $this->data_from_model_user;
      $this->View->render('home','tasks', ['title'=> 'Список задач','path'=> '../../', 'data' => $this->data_from_model]);
  }
}
