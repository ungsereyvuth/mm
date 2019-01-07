<?php
class updatePrivilege{
	public function data($data){
		global $encryptKey,$language,$usersession,$layout,$layout_label,$lang;
		$qry = new connectDb; $_POST=$data;
		$result = false;$msg=$layout_label->message->update_failed->icon.' '.$layout_label->message->update_failed->title;
		$err_fields=array();$uploaded_files=array();
		
		//--------- get privilege ids
		$cmd=$_POST['cmd'];unset($_POST['cmd']);
		$recordid=addslashes($_POST['recordid']);unset($_POST['recordid']);
		$password=addslashes($_POST['password']);unset($_POST['password']);
		$privileges = implode(',',$_POST);
		
		//get post data
		$reg_fields = array('text'=>array('recordid'=>$recordid,'password'=>$password),
							'email'=>array(),
							'file'=>array());
		
		$opt_fields = array();
		$err_fields=validateForm($reg_fields,$opt_fields);		
		if(!count($err_fields)){
			//check if authorized
			$encrypt_pwd = encodeString($reg_fields['text']['password'],$encryptKey);
			$userid = $usersession->info()->id;
			$check_exist = $qry->qry_count("select id from users where password='$encrypt_pwd' and id=$userid");
			if(!$check_exist){$err_fields[]= array('name'=>'password','msg'=>$layout_label->message->confirm_pwd_failed->title);}		
			//check if role exist
			$role_codes = explode('_',decodeString($reg_fields['text']['recordid'],$encryptKey));
			if(count($role_codes)==2){
				$role_id=$role_codes[0];
				$check_exist = $qry->qry_count("select id from user_role where id=$role_id");
				if(!$check_exist){$msg=$layout_label->message->invalid_data->title;$err_fields[]= array('name'=>'error','msg'=>$msg);}	
			}else{$msg=$layout_label->message->invalid_data->title;$err_fields[]= array('name'=>'error','msg'=>$msg);}
			//check no privilege selected
			if(!count($_POST)){$msg=$layout_label->message->blank_data->title;$err_fields[]= array('name'=>'error','msg'=>$msg);}	
		}
		
		//add service
		if(!count($err_fields)){
			$datetime = date("Y-m-d H:i:s");
			//create user
			$qry->update("update user_role set privileges='$privileges',last_updated_by=".$usersession->info()->id.",last_updated_date='$datetime' where id=$role_id limit 1");
			
			//add to user log			
			adduserlog($cmd,$role_id);
			$result = true;$msg=$layout_label->message->update_success->icon.' '.$layout_label->message->update_success->title;;
		}	
		echo json_encode(array('result'=>$result,'msg'=>$msg,'err_fields'=>$err_fields));
	}		
}	



?>