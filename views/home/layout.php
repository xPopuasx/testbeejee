<!DOCTYPE html>
<html lang="ru">
  <head>
    <link rel="stylesheet" type="text/css" href="<?=$vars['path']?>views/assets/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="<?=$vars['path']?>views/assets/js/bootstrap.min.js"></script>
    <script src="<?=$vars['path']?>views/assets/js/functions.js"></script>
    <meta charset="utf-8">
    <title><?=$vars['title']?></title>
  </head>
  <body>
    <div class="container">
      <header class="blog-header py-3">
        <div class="row flex-nowrap justify-content-between align-items-center">
          <div class="col-4 pt-1">
            <a class="text-muted" href="#">Логотип</a>
          </div>
          <div class="col-4 text-center">
            <a class="blog-header-logo text-dark" href="#"><?=$vars['title']?></a>
          </div>
          <div class="col-4 d-flex justify-content-end align-items-center">
            <?php
            if(!empty($vars['data']['user']))
            {
              echo $vars['data']['user']['user_email'].'
              <form  method="post">
                <input type="hidden" name="action" value="loginOut">
                <input type="submit" class="btn btn-sm btn-outline-secondary ml-2" value="Выход">
              </form>';
            }
            else
            {
              echo '<button data-toggle="modal" data-target="#LoginModal" class="btn btn-sm btn-outline-secondary" href="#">Авторизация</button>';
            }
            ?>

          </div>
        </div>
      </header>
        <?php
        if(!empty($vars['data']['error_msg']))
        {
          echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                '.$vars['data']['error_msg'].'
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>';
        }
        if(!empty($vars['data']['success']))
        {
          echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                '.$vars['data']['success'].'
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>';
        }
        ?>
    <?=$content?>
    </div>
    <div class="modal" tabindex="-1" id="LoginModal">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Войти</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form  method="post">
            <div class="input-group mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon1">Л</span>
              </div>
              <input type="text" class="form-control" placeholder="Логин" name ="login">
            </div>
            <input type="hidden" name="action" value="auth">
            <div class="input-group mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon1">П</span>
              </div>
              <input type="password" class="form-control" placeholder="Пароль" name ="password">
            </div>

          </div>
          <div class="modal-footer">
            <input type="submit" class="btn btn-primary" name="start" value="Войти">
          </form>
          </div>
        </div>
      </div>
    </div>
    <div class="modal" tabindex="-1" id="EditingModal">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Работа с задачей <span id="id_task"></span></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form  method="post">
              <input type="hidden" name="action" value="add_task">
              <input type="hidden" name="id" value="">
                <div class="col-md-12 px-0">
                  <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text" id="basic-addon1">П</span>
                    </div>
                    <input type="input" name="user_name_task" class="form-control" placeholder="Ваше имя" >
                  </div>
                </div>
                <div class="col-md-12 px-0">
                  <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text" id="basic-addon1">П</span>
                    </div>
                    <input type="input" name="user_email_task" class="form-control" placeholder="Ваш e-mail" >
                  </div>
                </div>
                <div class="col-md-12 px-0">
                  <div class="form-group">
                    <label for="exampleFormControlTextarea1">Текст задачи</label>
                    <textarea class="form-control" name="text_task" rows="3"></textarea>
                  </div>
                </div>
              </div>
          <div class="modal-footer">
            <input type="submit" class="btn btn-primary" name="start" value="Выполнить">
          </form>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>
