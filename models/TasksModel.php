<?

namespace models;

use app\Db;

class TasksModel extends Model
{
  public $sort_status = false;
  public $data_from_model = array();


  public function Sort($key)
  {
    return function($a, $b) use ($key)
    {
      return $a[$key] <=> $b[$key];
      $this->sort_status = 'ORDER';
    };
  }

  public function SortDesc($key)
  {
    return function($a, $b) use ($key)
    {
      return $b[$key] <=> $a[$key];
    };
  }

  public function Sort_task_all()
  {
    $Db = new Db();
    $Db->protect_select(['id_task', 'user_name_task', 'email_user_task', 'text_task', 'datetime_add_task', 'status_task','title_status_task'],NULL,'tasks',NULL , 'status_tasks', ['id_status_task' => 'status_task']);
    if($Db->table_query)
    {
      $this->data_from_model = mysqli_fetch_all($Db->table_query, MYSQLI_ASSOC);
    }
    if($this->sort_status)
    {
      return $this->data_from_model;
    }
  }

  public function Sorting_tasks($data)
	{
    if($data['sort_by'] == 'sort')
    {
      usort($this->data_from_model, $this->Sort($data['action_sort']));
    }
    else
    {
      usort($this->data_from_model, $this->SortDesc($data['action_sort']));
    }
    return $this->data_from_model;
	}

  public function Add_task_model($data, $table)
  {
      $Db = new Db();
      $Db->protect_insert(['user_name_task'=>$data['user_name_task'], 'email_user_task'=> $data['user_email_task'], 'text_task'=>$data['text_task'], 'datetime_add_task'=> date('Y-m-d H:i:s'), 'status_task'=>'1'], $table);
      if($Db->table_query)
      {
        return true;
      }
      else
      {
        return false;
      }
  }

  public function Update_task_model($data, $table)
  {
      $Db = new Db();
      $Db->protect_update(['user_name_task'=>$data['user_name_task'], 'email_user_task'=> $data['user_email_task'], 'text_task'=>$data['text_task'], 'datetime_add_task'=> date('Y-m-d H:i:s'), 'status_task'=>'2'], $table, ['id_task' => $data['id_task']]);
      if($Db->table_query)
      {
        return true;
      }
      else
      {
        return false;
      }

  }

  public function Update_task_status_model($data)
  {
      $Db = new Db();
      $Db->protect_update(['status_task'=>'3'], 'tasks', ['id_task' => $data['id_task']]);
      if($Db->table_query)
      {
        return true;
      }
      else
      {
        return false;
      }

  }


}
