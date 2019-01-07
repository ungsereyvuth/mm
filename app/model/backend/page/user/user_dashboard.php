<?php
class user_dashboard{
	public function data($input){
		$qry = new connectDb;global $usersession;
		$pageExist=false;
		
		
		$pageExist=true;
		returnStatus:
		return array('pageExist'=>$pageExist);
	}	
}
?>