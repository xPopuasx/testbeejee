<?php

namespace app;

class Db
{

    public $host = 'localhost';
    public $user = 'root';
    public $password = '';
    public $db_name = 'toBeeJee';
    public $connect  = false;

    public $error_code = 0;
    public $error_message = '';

		public $result_query = '';

		public function protect_data($value)
    {
        if(!is_array($value))
        {
            $value = strip_tags($value);
            $value = htmlentities($value, ENT_QUOTES, "UTF-8");
            $value = trim($value);
            $value = addslashes($value);
            return $value;
        }
        else
        {
            return serialize($value);
        }
    }

    public function db_connect() {
        $this->connect = @mysqli_connect($this->host, $this->user, $this->password, $this->db_name);
        if($this->connect)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

		public function query_free($query)
    {
        $this->db_connect();
        $this->table_query = @mysqli_query($this->connect, $query);
        if($this->table_query)
        {
            $this->query_result = 'true';
            return true;
        }
        else
        {
            return false;
        }
    }


		public function protect_select($vars, $params, $table, $sort, $inner_table, $inner_params)
		{
      $count_sort = count($sort);
      if($count_sort == 2)
      {
        $sort_query = ' ORDER BY `id_task` LIMIT '.$sort['start']. ', ' . $sort['end'];
      }

      if(!empty($inner_table) && is_array($inner_params) && is_array($inner_params))
      {
        $key_array_inner_params = key($inner_params);
        $inner_table_query = " INNER JOIN `".$inner_table."` ON `".$inner_table."`.`".$key_array_inner_params."` = `".$table."`.`".$inner_params[$key_array_inner_params]."`";
      }
      if(is_array($vars))
      {
        $result_query = array_map(array($this, 'protect_data'), $vars);
        foreach ($result_query as $key => $value)
        {
          $vars_query .= ' `'.$value.'`,';
        }
        $vars_query = 'SELECT '.substr($vars_query, 0, -1).' FROM `'.$table.'`';
      }
      if($params != NULL)
      {
        $result_query = array_map(array($this, 'protect_data'), $params);
        foreach ($result_query as $key => $value)
        {
          $query_value .= "'".$value."', ";
          $query_column .= "`".$key."`, ";
          $params_query .= "`".$key."` = '". $value ."' AND";
        }
        $params_query = ' WHERE '.substr($params_query, 0, -4);
      }
      $query = $vars_query . $inner_table_query . $params_query . $sort_query;

      $this->db_connect();
      $this->table_query = @mysqli_query($this->connect, $query);
      if($this->table_query)
      {
          return true;
      }
      else
      {
          return false;
      }
		}


		public function protect_insert($vars, $table)
		{
			$result_query = array_map(array($this, 'protect_data'), $vars);

			foreach ($result_query as $key => $value)
			{
				 $query_insert_value .= "'".$value."', ";
				 $query_insert_column .= "`".$key."`, ";
		  }

      $query.= 'INSERT INTO `'.$table.'` ';

			$query_insert_value = substr($query_insert_value, 0, -2);
			$query_insert_column = substr($query_insert_column, 0, -2);

			$query .= '('.$query_insert_column.') VALUES ('.$query_insert_value.')';

      $this->db_connect();
      $this->table_query = @mysqli_query($this->connect, $query);
      if($this->table_query)
      {
          return true;
      }
      else
      {
          return false;
      }
		}

    public function protect_update($data=array(), $table, $params=array())
    {
      $result_query = array_map(array($this, 'protect_data'), $data);

      $query.= "UPDATE `".$table."` SET ";
      foreach ($result_query as $key => $value)
      {
        $params_query .= "`".$key."` = '". $value ."', ";
      }
      $query.= substr($params_query, 0, -2);
      unset($params_query);
      foreach ($params as $key => $value)
      {
        $params_query .= "`".$key."` = '". $value ."' AND";
      }
      $query.= ' WHERE '.substr($params_query, 0, -4);
      $this->db_connect();
      $this->table_query = @mysqli_query($this->connect, $query);
      if($this->table_query)
      {
          return true;
      }
      else
      {
          return false;
      }
    }
}

?>
