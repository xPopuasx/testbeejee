<?php

namespace app;

class View
{
	public $layout = 'layout';

	public function render($controller, $action, $vars=[])
	{
			$layout_file = 'views/'.$controller.'/'.$this->layout.'.php';
			$container_file = 'views/'.$controller.'/'.$action.'.php';

			if(file_exists($layout_file))
			{
				ob_start();
        require $container_file;
        $content = ob_get_clean();

				require $layout_file;
			}
			else
			{
					echo 'Не найден шаблон для данного URL';
			}
	}

}
