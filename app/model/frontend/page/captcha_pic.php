<?php
class captcha_pic{
	public function data($input){
		global $usersession,$layout_label,$lang;
		$pageExist=false;
		
		$pageExist=true;
		returnStatus:
		return array('pageExist'=>$pageExist);
	}		
}
?>