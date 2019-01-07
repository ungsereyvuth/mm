<?php
class userprofile_update{
	public function data($data){
		global $encryptKey,$language,$usersession,$layout,$layout_label,$lang;
		$qry = new connectDb; $_POST=$data;
		
		$result = false;$msg=$layout_label->message->insert_failed->icon.' '.$layout_label->message->insert_failed->title;
		//$refresh_listname = 'admin_chargingrate';
		$err_fields=array();$uploaded_files=array();
		//get post data
		$reg_fields = array('text'=>array(	'recordid'=>addslashes($_POST['recordid']),
											'fullname'=>addslashes($_POST['fullname']),
											'gender'=>addslashes($_POST['gender']),		
											'mobile'=>addslashes($_POST['mobile']),
											'address'=>addslashes($_POST['address']),
											'provincecity'=>addslashes($_POST['provincecity'])),
							'email'=>array('email'=>addslashes($_POST['email'])),
							'file'=>array(	'photo'=>$_FILES['photo']));
		
		$opt_fields = array('photo','dob','mobile','address','provincecity');
	
		$err_fields=validateForm($reg_fields,$opt_fields);		
		if(!count($err_fields)){
			//check valid email
			foreach($reg_fields['email'] as $key=>$value){if(!in_array($key,$opt_fields)){if(!filter_var($value, FILTER_VALIDATE_EMAIL)){$err_fields[]= array('name'=>$key,'msg'=>$layout_label->message->invalid_email->title);}}}
						
			//check if exists
			$recordid=decodeString($reg_fields['text']['recordid'],$encryptKey);
			if(is_numeric($recordid) and $recordid>=0){
				$check_exist = $qry->qry_assoc("select id from users where id=$recordid");
				if(!count($check_exist)){$msg='Invalid user data';$err_fields[]= array('name'=>'error','msg'=>$msg);}
				elseif($recordid<>$usersession->info()->id and !isAdmin($usersession->info()->id) and !isThisUserRole($usersession->info()->id,'officer')){
					$msg='No permission';$err_fields[]= array('name'=>'error','msg'=>$msg);
				}else{
					//check if account email alr exists
					$email_exist = $qry->qry_assoc("SELECT * FROM users where email='".$reg_fields['email']['email']."' and id <> $recordid limit 1");
					if(count($email_exist)){$err_fields[]=array('name'=>'email','msg'=>$layout_label->message->email_exist->title);}
				}
			}else{
				$msg='Invalid data request';
				$err_fields[]= array('name'=>'error','msg'=>$msg);
			}
	
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
			$photo='';
			if(isset($uploaded_files['photo']['newfilename'])){$photo="photo='".$uploaded_files['photo']['newfilename']."',";}
			//update user
			$qry->update("update users set											
							fullname='".$reg_fields['text']['fullname']."',
							gender='".$reg_fields['text']['gender']."',
							email='".$reg_fields['email']['email']."',
							$photo
							mobile='".$reg_fields['text']['mobile']."',
							address='".$reg_fields['text']['address']."',
							provincecity=".(is_numeric($reg_fields['text']['provincecity'])?$reg_fields['text']['provincecity']:'NULL').",
							last_updated_by=".$usersession->info()->id.",
							last_updated_date='$datetime'
							where id=$recordid limit 1");
			
			//add to user log			
			adduserlog($_POST['cmd'],$recordid);
			$result = true;$msg=$layout_label->message->insert_success->icon.' '.$layout_label->message->insert_success->title;;
		}	
		return json_encode(array('result'=>$result,'msg'=>$msg,'err_fields'=>$err_fields));			
	}	
}	



?>