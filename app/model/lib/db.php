<?php
include_once("app/config/config.php");

date_default_timezone_set('Asia/Phnom_Penh'); 
$encryptKey = 'ecobiz';

ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);

class connectDb {
	public static function connect(){
		global $dbhost;global $dbuser;global $dbpass;global $dbname;
		$conn = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname);
		return $conn;
	}	

	public function std_qry($query){	
			$conn = self::connect();
			mysqli_query($conn, "SET NAMES 'utf8' COLLATE 'utf8_unicode_ci'");
			mysqli_query($conn, "SET @@group_concat_max_len = 1000000;");
			$result = mysqli_query($conn, $query) or
			die("could not execute query $query");
			$lastid = mysqli_insert_id($conn);
			return array($result,$lastid);
	}
	
	public function insert($query){	
			$result = self::std_qry($query);
			return $result[1];
	}
	
	public function update($query){	
			$result = self::std_qry($query);
			return $result[0];
	}

	public function qry_assoc($query){	
			$result = self::std_qry($query);
			$arr = array();
			while($row = mysqli_fetch_assoc($result[0])) {
				$arr[] = $row;
			}
			return $arr;
	}
	public function qry_num($query){	
			$result = self::std_qry($query);
			return mysqli_fetch_all($result[0],MYSQLI_NUM);
	}
	public function qry_count($query){
			$result = self::std_qry($query);
			return mysqli_num_rows($result[0]);
	}	
	
	public function exist($query){	
			$result = self::std_qry($query);
			$arr = array();
			while($row = mysqli_fetch_assoc($result[0])) {
				$arr[] = $row;
			}
			if(count($arr)==0){return false;}else{return true;}
	}
}


?>