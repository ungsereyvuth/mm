<?php

//include_once("app/model/db.php");

//include_once("app/model/functions.php");

//include_once("app/model/language.php");



class usersession{

	/*public $language;

	public function __construct($language){

		$this->language = $language;

	}

*/	

	public function isLogin(){

		global $encryptKey;

		if (!is_session_started()) session_start();		

		//$qry = new connectDb;

		if(isset($_SESSION['userid']) and isset($_SESSION['token'])){

			if(decodeString($_SESSION['token'],$encryptKey)==$_SESSION['userid']){

				return true;

			}

		}else{return false;}

	}

	public function info(){

		$dt = array();

		if (!is_session_started()) session_start();		

		if($this->isLogin()){

			

			//$language_id = $this->language;

			global $lang;

			$selected_lang = $lang->selected;

			

			$qry = new connectDb;

			$userData = $qry->qry_assoc("select 

											user.id,
											user.email,
											user.photo,	
											user.mobile,
											user.fullname,
											user.pending user_pending,
											user.active user_active,
											role.icon,
											role.code,
											role.title,
											role.auth_level,
											role.privileges,
											role.homepage

										from users user join user_role role on user.role_id=role.id where user.id = ".$_SESSION['userid']." LIMIT 1");

			

			$dt =  $userData[0];

			//check if account inactive, auto logout

			if($dt['user_pending'] or !$dt['user_active']){header("location: /logout");}

		}

		return (object) $dt;

	}

	

	public function type(){

		$getType = $this->checkType();

		$dt = $getType->dt;

		return (object) $dt;	

	}

	

	public function activeType($authorizedUsers){

		$getType = $this->checkType();

		$activeType = $getType->activeType;

		//check if authorized

		$authorized=true;

		if(count($authorizedUsers)){if(!in_array($activeType,$authorizedUsers)){$authorized=false;}}else{$authorized=false;}		

		return (object) array('activeType'=>$activeType,'authorized'=>$authorized);	

	}

	

	public function checkType(){

		$qry = new connectDb;$dt = array();

		$userData = $qry->qry_assoc("select * from user_role where active=1 order by auth_level asc");

		foreach($userData as $key=>$value){$dt[$value['code']] = false;}

		//$dt = array('isSuperuser'=>false,'isAdmin'=>false,'isApplicant'=>false);

		if(is_object($this->info())){

			$code = $this->info()->code;

			$fuc = array(); $activeType = '';

			if(array_key_exists($code,$dt)){$dt[$code] =  true;$activeType = $code;}

			/*if($code=='superuser'){

				$dt =  array('isSuperuser'=>true,'isAdmin'=>false,'isApplicant'=>false);

				$activeType = 'isSuperuser';

			}elseif($code=='admin'){

				$dt =  array('isSuperuser'=>false,'isAdmin'=>true,'isApplicant'=>false);

				$activeType = 'isAdmin';

			}elseif($code=='applicant'){

				$dt =  array('isSuperuser'=>false,'isAdmin'=>false,'isApplicant'=>true);

				$activeType = 'isApplicant';

			}*/

		}

		return (object) array('dt'=>$dt,'activeType'=>$activeType);	

		

	}

	

	/*public function isClubmember(){

		$isClubmember = false;

		if($this->isLogin()){$isClubmember = club_member($_SESSION['userid']);}

		return $isClubmember;

	}*/

	

}







?>