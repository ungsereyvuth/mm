<?php
class useraccount_update{
	public function data($data){
		global $encryptKey,$language,$usersession,$layout,$layout_label,$lang;
		$qry = new connectDb; $_POST=$data;
		$result = false;$msg=$layout_label->message->update_failed->icon.' '.$layout_label->message->update_failed->title;
		//$refresh_listname = 'admin_chargingrate';
		$err_fields=array();$uploaded_files=array();
		//get post data
		$reg_fields = array('text'=>array(	'recordid'=>addslashes($_POST['recordid']),
											'username'=>addslashes($_POST['username']),
											'cpwd'=>addslashes($_POST['cpwd']),
											'npwd'=>addslashes($_POST['npwd']),
											'rpwd'=>addslashes($_POST['rpwd'])),
							'email'=>array(),
							'file'=>array());
		$recordid=decodeString($reg_fields['text']['recordid'],$encryptKey);
		if($recordid<>$usersession->info()->id and isAdmin($usersession->info()->id)){$admin_edit=true;}else{$admin_edit=false;}
	
		$opt_fields = array();
		if($admin_edit){$opt_fields[] = 'cpwd';}
	
		$err_fields=validateForm($reg_fields,$opt_fields);		
		if(!count($err_fields)){
			//check valid email
			//foreach($reg_fields['email'] as $key=>$value){if(in_array($key,$required_fields)){if(!filter_var($value, FILTER_VALIDATE_EMAIL)){$err_fields[]= array('name'=>$key,'msg'=>$layout_label->message->invalid_email->title);}}}
			//check if exists		
			if(is_numeric($recordid) and $recordid>=0){
				$check_exist = $qry->qry_assoc("select id from users where id=$recordid");
				if(!count($check_exist)){$msg='Invalid user data';$err_fields[]= array('name'=>'error','msg'=>$msg);}
				elseif($recordid<>$usersession->info()->id and !isAdmin($usersession->info()->id)){
					$msg='No permission to perform this request';$err_fields[]= array('name'=>'error','msg'=>$msg);
				}else{
					//check if username exists
					if(!filter_var($reg_fields['text']['username'], FILTER_VALIDATE_EMAIL)){
						$exist = $qry->qry_assoc("SELECT * FROM users where username='".$reg_fields['text']['username']."' and id <> $recordid limit 1");
						if(count($exist)){$err_fields[]=array('name'=>'username','msg'=>$layout_label->message->username_exist->title);}
					}else{$err_fields[]=array('name'=>'username','msg'=>$layout_label->message->invalid_username->title);}
				}
			}else{
				$msg='Invalid data request';
				$err_fields[]= array('name'=>'error','msg'=>$msg);
			}
			
			//check if current pwd is correct
				$cur_pwd_key = 'cpwd';
				$cur_pwd = encodeString($reg_fields['text'][$cur_pwd_key],$encryptKey);
				$check_cur_pwd = $qry->qry_count("SELECT id FROM users where password='".$cur_pwd."' and id=$recordid limit 1");	
				if(!$check_cur_pwd and !$admin_edit){$err_fields[]=array('name'=>$cur_pwd_key,'msg'=>'Wrong current password');}
			//check password match
			$new_pwd_key = 'npwd'; $cf_new_pwd_key = 'rpwd';
			if(strlen($reg_fields['text'][$new_pwd_key])>=6){
				if($reg_fields['text'][$new_pwd_key] == $reg_fields['text'][$cur_pwd_key]){
					$err_fields[]=array('name'=>$new_pwd_key,'msg'=>'Same to old password');
				}elseif($reg_fields['text'][$new_pwd_key] <> $reg_fields['text'][$cf_new_pwd_key]){
					$err_fields[]=array('name'=>$cf_new_pwd_key,'msg'=>'Repeat new password failed');
				}
			}else{$err_fields[]=array('name'=>$new_pwd_key,'msg'=>'At least 6 characters');}	
			
		}
		
		//add service
		if(!count($err_fields)){
			$datetime = date("Y-m-d H:i:s");
			$newpwd = encodeString($reg_fields['text']['npwd'],$encryptKey);
			$qry->update("update users set 
								username='".$reg_fields['text']['username']."',
								password='".$newpwd."',
								last_updated_by=".$usersession->info()->id.",
								last_updated_date='$datetime'
								where id=$recordid limit 1");	
			
			//add to user log			
			adduserlog($_POST['cmd'],$recordid);
			$result = true;$msg=$layout_label->message->update_success->icon.' '.$layout_label->message->update_success->title;;
		}	
		echo json_encode(array('result'=>$result,'msg'=>$msg,'err_fields'=>$err_fields));
	}	
}	



?>