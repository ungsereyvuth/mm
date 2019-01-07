<?php
class register{
	public function data($input){
		$qry = new connectDb;global $usersession,$lang;
		$pageExist=false;
		
		//get locationlist
		$provincecity = $qry->qry_assoc("select *,IF('$lang->selected'='kh',name_kh,name_en) provincecity_name from provincecity where active=1");
		
		$pageExist=true;
		returnStatus:
		return array('pageExist'=>$pageExist,'provincecity'=>$provincecity);
	}	
}
?>