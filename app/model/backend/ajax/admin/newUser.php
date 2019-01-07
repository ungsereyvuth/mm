<?php
class newUser{
	public function data($data){
		global $encryptKey,$language,$usersession,$layout,$layout_label,$lang;
		$qry = new connectDb; $_POST=$data;
		$refresh_listname='admin_userlist';
		$result = false;$msg=$layout_label->message->insert_failed->icon.' '.$layout_label->message->insert_failed->title;
		//$refresh_listname = 'admin_chargingrate';
		$err_fields=array();$uploaded_files=array();
		//get post data
		$reg_fields = array('text'=>array(	'role_id'=>addslashes($_POST['role_id']),
											'fullname_kh'=>addslashes($_POST['fullname_kh']),
											'fullname_en'=>addslashes($_POST['fullname_en']),
											'gender'=>addslashes($_POST['gender']),	
											'username'=>addslashes($_POST['username']),				
											'pwd'=>addslashes($_POST['pwd']),
											'rpwd'=>addslashes($_POST['rpwd']),
											'notif'=>isset($_POST['notif'])?1:0,
											'active'=>isset($_POST['active'])?1:0),
							'email'=>array('email'=>$_POST['email']),
							'file'=>array(	'photo'=>$_FILES['photo']));
		
		$opt_fields = array('photo','notif','active');
		$err_fields=validateForm($reg_fields,$opt_fields);		
		if(!count($err_fields)){
			//check valid email
			foreach($reg_fields['email'] as $key=>$value){if(in_array($key,$opt_fields)){if(!filter_var($value, FILTER_VALIDATE_EMAIL)){$err_fields[]= array('name'=>$key,'msg'=>$layout_label->message->invalid_email->title);}}}
			
			//check if exists
			$check_exist = $qry->qry_count("select id from users where email='".$reg_fields['email']['email']."'");
			if($check_exist){$err_fields[]= array('name'=>'email','msg'=>$layout_label->message->email_exist->title);}
	
			//check if username exists
			if(!filter_var($reg_fields['text']['username'], FILTER_VALIDATE_EMAIL)){
				$exist = $qry->qry_assoc("SELECT * FROM users where username='".$reg_fields['text']['username']."' limit 1");
				if(count($exist)){$err_fields[]=array('name'=>'username','msg'=>$layout_label->message->username_exist->title);}
			}else{$err_fields[]=array('name'=>'username','msg'=>$layout_label->message->invalid_username->title);}
			
			//check password match
			$new_pwd_key = 'pwd'; $cf_new_pwd_key = 'rpwd';
			if(strlen($reg_fields['text'][$new_pwd_key])>=6){
				if($reg_fields['text'][$new_pwd_key] <> $reg_fields['text'][$cf_new_pwd_key]){
					$err_fields[]=array('name'=>$cf_new_pwd_key,'msg'=>'Repeat new password failed');
				}
			}else{$err_fields[]=array('name'=>$new_pwd_key,'msg'=>'At least 6 characters');}	
			
			foreach($reg_fields['file'] as $key=>$value){
				//check allowed file type		
				if($value["type"]<>''){
					$allowed_file = allowed_file($value);
					if(!$allowed_file['result']){$err_fields[]=array('name'=>$key,'msg'=>$allowed_file['msg']);}
				}elseif(!in_array($key, $opt_fields)){$err_fields[]=array('name'=>$key,'msg'=>$layout_label->message->no_file->title);}			
			}
			if(!count($err_fields)){	
				$docPath = web_config('post_doc_path');	$profilePath = web_config('profile_pic_path');
				foreach($reg_fields['file'] as $key=>$value){
					if($value["type"]<>''){
						if($key=='photo'){$filePath =$profilePath;}else{$filePath =$docPath;}
						$file_prefix = $key;
						$upload_result = upload($filePath,$value,$file_prefix);
						if($upload_result){$uploaded_files[$key]=$upload_result;}else{$err_fields[]=array('name'=>$key,'msg'=>$layout_label->message->upload_failed->title);}
					}
				}
			}
			
		}
		
		//add service
		if(!count($err_fields)){
			$datetime = date("Y-m-d H:i:s");
			$pwd = encodeString($reg_fields['text']['pwd'],$encryptKey);
			$photo='';
			if(isset($uploaded_files['photo']['newfilename'])){$photo="photo='".$uploaded_files['photo']['newfilename']."',";}
			//create user
			$recordid=$qry->insert("insert into users set											
							role_id=".$reg_fields['text']['role_id'].",
							fullname_kh='".$reg_fields['text']['fullname_kh']."',
							fullname_en='".$reg_fields['text']['fullname_en']."',
							gender='".$reg_fields['text']['gender']."',
							$photo
							username='".$reg_fields['text']['username']."',
							email='".$reg_fields['email']['email']."',							
							password='$pwd',
							notif=".$reg_fields['text']['notif'].",
							active=".$reg_fields['text']['active'].",
							pending=0,
							created_by=".$usersession->info()->id.",
							created_date='$datetime'");
			
			//add to user log			
			adduserlog($_POST['cmd'],$recordid);
			$result = true;$msg=$layout_label->message->insert_success->icon.' '.$layout_label->message->insert_success->title;;
		}	
		echo json_encode(array('result'=>$result,'msg'=>$msg,'err_fields'=>$err_fields,'refresh_listname'=>$refresh_listname));
	}	
}	



?>