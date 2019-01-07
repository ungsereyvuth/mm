<?php
class admin_dashboard{
	public function data($input){
		$qry = new connectDb;global $usersession,$lang,$encryptKey;
		$pageExist=false;
		
		
		
		$pageExist=true;
		returnStatus:
		return array('pageExist'=>$pageExist);
	}	
}
?>