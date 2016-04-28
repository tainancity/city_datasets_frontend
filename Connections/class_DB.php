<?php
/**
*程式說明:資料庫的連線物件，mysql
*/
class mydb{
	var $hostname_DB;
	var $username_DB;
	var $password_DB;
	var $database_DB;
	var $_dbConn = 0;
    var $_queryResource = 0;
//MYSQL版本的物件	
	function connect_db()
	{
		//不用做任何動作
	}
	function init_db()
    {
		require('db_config.php');
        $dbConn = mysql_connect($hostname_DB, $username_DB, $password_DB);
        if (! $dbConn)
			die ("MySQL Connect Error");
        mysql_query("SET NAMES utf8");
        if (! mysql_select_db($database_DB, $dbConn))
			die ("MySQL Select DB Error");
        $this->_dbConn = $dbConn;
        return true;
    }
    function query($sql_stream)
    {
		//echo $sql_stream;
		if ($queryResource = mysql_query($sql_stream, $this->_dbConn))
		{
			return $queryResource;
		}
        else
		{
			$fp=fopen("log/error/(".date('Y-m-d').")error.txt","a+");
			fwrite($fp,date('Y-m-d H:i:s')." ".$sql_stream."  ErrorMSG:".mysql_error()." \n");
			fclose($fp);
		
		}
    }
    function get_fetch_array($sql_str)
    {
        return @mysql_fetch_array($sql_str);
    }
	function get_fetch_assoc($sql_str)
	{
		return @mysql_fetch_assoc($sql_str);
	}
    function get_fetch_row($sql_str)
    {
        return @mysql_fetch_row($sql_str);
    }
    function get_num_rows($sql_str)
    {
        return @mysql_num_rows($sql_str);
    }
	function insert_id()
	{
		return mysql_insert_id($this->_dbConn);
	}
	function free_result($in)
	{
		return @mysql_free_result($in);
	}
	function close()
	{
		return mysql_close($this->_dbConn);
	}
	
	/*-------------Transaction-------------------*/
	protected $transactionCount = 0;

    public function beginTransaction()
    {
        if (!$this->transactionCounter++) {
            return parent::beginTransaction();
        }
        $this->exec('SAVEPOINT trans'.$this->transactionCounter);
        return $this->transactionCounter >= 0;
    }

    public function commit()
    {
        if (!--$this->transactionCounter) {
            return parent::commit();
        }
        return $this->transactionCounter >= 0;
    }

    public function rollback()
    {
        if (--$this->transactionCounter) {
            $this->exec('ROLLBACK TO trans'.$this->transactionCounter + 1);
            return true;
        }
        return parent::rollback();
    }

}

/*
範例
//----------------db_config.php內容------------------//
   $hostname_DB = "localhost";
   $database_DB = "jobbank";
   $username_DB = "root";
   $password_DB = "1234567";
//----------------DB_config.php內容end------------------//

    require_once("DB.php");

    $db = new mydb();
    $db->init_db();
    $result=$db->query("SELECT ....");
    while($value = $db->get_fetch_assoc($result))
    {
        // do something you want...
    }
	
*/
