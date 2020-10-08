<?php

namespace app;

use app\db;

class Session
{

    public function __construct() {
        session_set_save_handler(
            array($this, 'session_open'),
            array($this, 'session_close'),
            array($this, 'session_read'),
            array($this, 'session_write'),
            array($this, 'session_destroy'),
            array($this, 'session_clean')
        );
        session_write_close();
    }

    public function session_open()
    {
       $db = new db;
       $db->db_connect();
       return true;
    }

    public function session_close()
    {
        return true;
    }

    public function session_read($id)
    {
       	$db = new db;
       	$db->db_connect();
        $db->query_free("SELECT * FROM `session` WHERE `session_id` = '".$id."'");

        if($db->table_query->num_rows > 0)
        {
           $row = $db->table_query->fetch_assoc();
           return $row['session_data'];
        }
        else
        {
            return '';
        }
    }

    public function session_write($id, $data)
    {
    		$db = new db;
        $this->CurrentTime = date('Y-m-d H:i:s');
        $db->query_free("REPLACE INTO `session` SET `session_id` = '".$id."', `session_date` = '".$this->CurrentTime."', `session_data` = '".$data."'");
        if($db->table_query)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function session_destroy($id)
    {
    		$db = new db;
        $db->query_free("DELETE FROM `session` WHERE `session_id` = '".$id."'");
        return true;
    }

    public function session_clean($maxlifetime)
    {
    		$db = new db;
       	$db->db_connect();
        $result = $db->query_free("DELETE FROM `session` WHERE ((UNIX_TIMESTAMP(`session_date`) + ".$maxlifetime.") < ".$maxlifetime.")");

        if($result)
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
