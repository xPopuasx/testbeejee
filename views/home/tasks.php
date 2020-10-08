<?php


if(empty($vars['data']['user']['auth']))
{
  echo '
  <div class="jumbotron p-4 p-md-5 text-white rounded bg-dark">
    <div class="col-md-12 px-0">
      <h1 class="display-4 font-italic">Вы не авторизованы</h1>
      <p class="lead my-3">Для редактирования задач пройдите авторизацию</p>
        <p class="lead mb-0" type="submit" data-toggle="modal" data-target="#EditingModal"><a class="text-white font-weight-bold">Добавить задачу</a></p>
    </div>
  </div>';
}
else {
  echo '
  <div class="jumbotron p-4 p-md-5 text-white rounded bg-dark">
    <div class="col-md-12 px-0">
      <p class="lead mb-0" type="submit" data-toggle="modal" data-target="#EditingModal"><a class="text-white font-weight-bold">Добавить задачу</a></p>
    </div>
  </div>';
  $edditing_full = '<button type="submit" data-toggle="modal" data-target="#EditingModal" class="btn btn-sm btn-outline-secondary mt-2 modal-update" >Редактировать</button>';
  $editing = '
        <input type="submit" class="btn btn-sm btn-outline-secondary mt-3" value="Выполнено">
        ';
}
?>


<div class="row">

    <div class="col-md-3 mb-4">
    <form method="GET">
        <input type="hidden" name="action" value="sort">
        <?php
          if(isset($_GET['sort_by']) && $_GET['sort_by'] == 'sort')
          {
            echo '<input type="hidden" name="sort_by" value="sortDesc">';
          }
          else {
            echo '<input type="hidden" name="sort_by" value="sort">';
          }
        ?>
        <select name="action_sort" class="form-control mb-4">
            <option value="id_task">по порядку</option>
            <option value="user_name_task">по имени составителя</option>
            <option value="email_user_task">по email составителя</option>
            <option value="status_task">по статусу</option>
        </select>
        <input type="submit"  value="Сортировать" class="btn btn-sm btn-outline-secondary">
      </div>
    </form>

  <?php
  echo '<div class="col-md-12">';
  echo $vars['data']['task_pagination'];
  echo '</div>';
  $tasks_array = array_values($vars['data']['tasks']);
  $count_tasks = count($tasks_array);
  if($count_tasks > 0)
  {
    for($i = 0; $i < $count_tasks; $i ++)
    {
        echo '<div class="col-md-12">
          <div class="row no-gutters border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-250 position-relative">
            <div class="col p-4 d-flex flex-column position-static">
              <strong class="d-inline-block mb-2 text-primary" ><span class="user-email-task">'.$tasks_array[$i]['email_user_task'].'</span> (<span class="user-name-task">'.$tasks_array[$i]['user_name_task'].'</span>)</strong>
              <h3 class="mb-0">Задача № <span  class="id-task">'.$tasks_array[$i]['id_task'].'</span></h3>
              <div class="mb-1 text-muted">'.date('d.m.Y H:i:s', strtotime($tasks_array[$i]['datetime_add_task'])).' ['.$tasks_array[$i]['title_status_task'].']</div>
              <p class="card-text mb-auto text-task">'.$tasks_array[$i]['text_task'].'</p>
              <div class="col-md-3 px-0">';
                if($tasks_array[$i]['status_task'] != '3')
                {
                echo $edditing_full.
                  '<form  method="post">
                  <input type="hidden" name="action" value="update_task_status">
                  <input type="hidden" name="id" value="'.$tasks_array[$i]['id_task'].'">
                  '.$editing.'
                </form>';
                }
              echo '</div>
            </div>
          </div>
        </div>';
    }
    echo '<div class="col-md-12">';
    echo $vars['data']['task_pagination'];
    echo '</div>';
  }
  ?>



</div>
