<?php
class contact{
	public function data($input){
		$qry = new connectDb;global $usersession,$lang;
		$pageExist=false;
		
		$m_cate = $qry->qry_assoc("SELECT *,IF('$lang->selected'='kh',title_kh,title_en) title from feedback_type where active=1");
		
		$pageExist=true;
		returnStatus:
		return array('pageExist'=>$pageExist,'m_cate'=>$m_cate);
	}	
}
?>