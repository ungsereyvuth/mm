<?php
class logout{ 
	public function data($input){
		if (!is_session_started()) session_start();
		//add to user log
		if(isset($_SESSION['userid'])){
			adduserlog('logout',$_SESSION['userid']);
		}
		unset($_SESSION['userid'],$_SESSION['token']);	
		//header("location:/".$languagecode);
		
		//return array('info'=>'login','input'=>$input);
	}	
}
?>