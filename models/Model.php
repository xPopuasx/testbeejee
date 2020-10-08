<?

namespace models;

use app\Db;
use app\Session;

class Model
{
  public $sort_status = false;
  public $data_from_model = array();

    public function Session_inform()
    {
      $Db = new Db();
      $Db->query_free("SELECT * FROM `session`");
      if($Db->table_query)
      {
        $this->sort_status = true;
        $this->data_from_model = mysqli_fetch_all($Db->table_query, MYSQLI_ASSOC);
      }
      if($this->sort_status)
      {
        return $this->data_from_model;
      }
    }

    public function Authorization_model($vars)
    {
        $Db = new Db();
        $Db->protect_select(['id_user', 'email_user', 'login_user', 'password_user'], ['login_user' => $vars['login'], 'password_user' => $vars['password']],'users', NULL, NULL, NULL);
        if($Db->table_query->num_rows > 0)
        {
          $row =  $Db->table_query->fetch_assoc();
          $_SESSION['auth'] = 1;
          $_SESSION['id_user'] = $row['id_user'];
          $_SESSION['user_email'] = $row['email_user'];
          return true;
        }
        else
        {
          $this->data_from_model = 'Неверно указан логин или пароль';
          return false;
        }
    }

    public function Login_out_model()
    {
      if(!empty($_SESSION))
      {
        session_destroy();
        return true;
      }
      else
      {
        return false;
      }
    }

    public function Pagination($vars, $limit)
    {
        $total = count($vars);
        $pages = ceil($total / $limit);

        if(!isset($_GET['page']) || intval($_GET['page']) == 0)
        {
          $page = 1;
        }
        else if(intval($_GET['page']) > $total)
        {
          $page = $pages;
        }
        else
        {
          $page = $_GET['page'];
        }
        if(isset($_GET['action']))
        {
          $get = '?'.http_build_query($_GET);
        }
        if($pages>1)
        {
        $pager .= '<nav aria-label="Page navigation example">
                    <ul class="pagination">
                      <li class="page-item"><a class="page-link" href="'.$get.'&page=1">Начало</a></li>';
                      for ($i=2; $i <=$pages-1 ; $i++)
                      {
                        $pager .='<li class="page-item"><a class="page-link" href="'.$get.'&page='.$i.'">'.$i.'</a></li>';
                      }
            $pager .= '<li class="page-item"><a class="page-link" href="'.$get.'&page='.$pages.'">Конец</a></li>
                    </ul>
                  </nav>';
          }
         return $pager;
    }

}
