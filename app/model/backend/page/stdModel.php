<?php
class stdModel{
	public function data($input){
		$qry = new connectDb;global $usersession,$encryptKey;$breadcrumb=array();$pageExist=false;

		
		
		$pageExist=true;
		returnStatus:
		return array('pageExist'=>$pageExist);
	}	
}
?>