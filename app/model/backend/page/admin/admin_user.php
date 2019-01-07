<?php
class admin_user{
	public function data($input){
		global $encryptKey,$usersession;$qry = new connectDb;
		$pageExist=false;
		$userinfo=array();
		if(!isset($input[0])){
			$user_id=$usersession->info()->id;
		}elseif(!is_numeric(decodeString($input[0],$encryptKey)) or (!isAdmin($usersession->info()->id) and !isThisUserRole($usersession->info()->id,'officer'))){goto returnStatus;}
		else{$user_id=decodeString($input[0],$encryptKey);}
		
		
		$userinfo = $qry->qry_assoc("select u.*,role.title role_name,l.title_kh provincecity_name
									from users u
									left join user_role role on role.id=u.role_id
									left join address_provincecity l on l.id=u.provincecity
									where u.id=$user_id limit 1");
				
		if(!count($userinfo)){goto returnStatus;}
		$userinfo = $userinfo[0];		
		
		//provincecity list
		$provincecity_select='<option value="">--- Select ---</option>';
		$provincecity_row = $qry->qry_assoc("select *,title_kh title from address_provincecity where active=1");
		foreach($provincecity_row as $value){
			$provincecity_select.='<option value="'.$value['id'].'" '.($value['id']==$userinfo['provincecity']?'selected':'').'>'.$value['title'].'</option>';
		}
		$userinfo['provincecity_select']=$provincecity_select;

		$pageExist=true;
		returnStatus:
		return array('pageExist'=>$pageExist,'input'=>$input,'userinfo'=>(object) $userinfo);
	}	
}
?>