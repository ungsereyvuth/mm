<?php
class login{
	public function data(){
		$qry = new connectDb;$pageExist=false;			
		//$intro_data = content('home_intro');
		//$intro =$intro_data['home_intro'];
		
		$pageExist=true; 
		returnStatus:
		return array('pageExist'=>$pageExist);
	}	
}
?>