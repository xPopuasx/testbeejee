<?

namespace app;

use app\Session;

class Router
{


    public  $uri = "";
    private $default_controller = "home";
    private $default_action = "tasks";
    public  $routes = "";


    public function __construct()
    {
        if(strlen($this->uri) == 0)
        {
            $this->uri = $this->default_controller.'/'.$this->default_action;
        }
        else
        {
          $this->uri = trim($_GET['url'], '/');;
        }

      $this->uri = mb_strtolower($this->uri);
      $this->routes = include 'Routes.php';
      $uri_explode = explode("/", $this->uri);

      if(isset($this->routes[$uri_explode[0]]))
      {
         $controller = $this->routes[$uri_explode[0]]['url']['controller'];
         $controller_class = 'controllers\\'.ucfirst($controller).'Controller';

         $action = $this->routes[$uri_explode[0]]['url']['action'];
         $action_metod = 'Action'.$action;

         if($uri_explode[1] == $action)
         {
           if(file_exists($controller_class.'.php'))
           {
               $controller = new $controller_class;
               if(method_exists($controller, $action_metod))
               {
                 $controller->$action_metod();
               }
               else
               {
                  echo 'Отсутствует метод контроллера';
               }
           }
           else
           {
             echo 'Отсутствует файл контроллера';
           }
         }
         else
         {
            header('HTTP/1.0 404 Not Found');
         }
      }
      else
      {
          header('HTTP/1.0 404 Not Found');
      }
    }


}
