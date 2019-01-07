<?php
class register{
	public function data($data){
		global $encryptKey,$language,$usersession,$layout,$layout_label,$lang;
		$qry = new connectDb; $_POST=$data;	$goto_url = '';		
		$result = false;$msg=$layout_label->message->reg_failed->icon.' '.$layout_label->message->reg_failed->title;
		$err_fields=array();$uploaded_files=array();			
		$enable_registration = web_config('enable_registration');		
		if(!$enable_registration){
			$msg=$layout_label->message->reg_disable->icon.' '.$layout_label->message->reg_disable->title;
			echo json_encode(array('result'=>$result,'msg'=>$msg,'err_fields'=>$err_fields,'url'=>$goto_url));exit;
		}
		//get post data
		$reg_fields = array('text'=>array('company_name'=>addslashes($_POST['company_name']),
											'company_phone'=>addslashes($_POST['company_phone']),
											'company_address'=>addslashes($_POST['company_address']),
											'company_provincecity'=>addslashes($_POST['company_provincecity']),
											'username'=>addslashes($_POST['username']),
											'password'=>addslashes($_POST['password']),
											'confirm_password'=>addslashes($_POST['confirm_password']),
											'captcha'=>addslashes($_POST['captcha'])),
							'email'=>array('email'=>addslashes($_POST['email'])),
							'file'=>array());
		
		$opt_fields = array('company_address');		
		$err_fields=validateForm($reg_fields,$opt_fields);				
		if(!count($err_fields)){			
			//check valid email
			foreach($reg_fields['email'] as $key=>$value){if(!in_array($key,$opt_fields)){if(!filter_var($value, FILTER_VALIDATE_EMAIL)){$err_fields[]= array('name'=>$key,'msg'=>$layout_label->message->invalid_email->title);}}}
			//check if account email alr exists
			$email_exist = $qry->qry_assoc("SELECT * FROM users where email='".$reg_fields['email']['email']."' limit 1");
			if(count($email_exist)){$err_fields[]=array('name'=>'email','msg'=>$layout_label->message->email_exist->title);}
			//check if username in latin
			$username=$reg_fields['text']['username'];
			if (checkusername($username)){
				$exist = $qry->qry_assoc("SELECT * FROM users where username='".$username."' limit 1");
				if(count($exist)){$err_fields[]=array('name'=>'username','msg'=>$layout_label->message->username_exist->title);}
			}else{
				$err_fields[]=array('name'=>'username','msg'=>$layout_label->message->invalid_username->title);
			}
			//check password match
			if(strlen($reg_fields['text']['password'])>=6){
				if($reg_fields['text']['password'] <> $reg_fields['text']['confirm_password']){
					$err_fields[]=array('name'=>'confirm_password','msg'=>$layout_label->message->confirm_pwd_failed->title);
				}
			}else{$err_fields[]=array('name'=>'password','msg'=>$layout_label->message->pwd_length_failed->title);}
			
			//check if captcha matched
			if (!is_session_started()) session_start(); //echo $_SESSION['captcha'];
			if(isset($_SESSION['captcha'])){
				if($_SESSION['captcha']<>$reg_fields['text']['captcha']){$err_fields[]= array('name'=>'captcha','msg'=>$layout_label->message->wrong_code->title);}
			}else{$err_fields[]= array('name'=>'captcha','msg'=>$layout_label->message->wrong_code->title);}			
		}	
		
		//create account
		if(!count($err_fields)){
			$datetime = date("Y-m-d H:i:s");$more_data='';
			$encryptedPWD = encodeString($reg_fields['text']['password'],$encryptKey);
			$need_confirm = web_config('reg_mail_confirm');	
			if($need_confirm){$pending = "pending=1,";}else{$pending = "pending=0,";}
			//create user
			$account_id = $qry->insert("insert into users set
										role_id=3,
										company_name='".$reg_fields['text']['company_name']."',
										company_phone='".$reg_fields['text']['company_phone']."',
										company_address='".$reg_fields['text']['company_address']."',
										company_provincecity='".$reg_fields['text']['company_provincecity']."',
										email='".$reg_fields['email']['email']."',	
										username='".$reg_fields['text']['username']."',								
										password='".$encryptedPWD."',
										$pending								
										created_date='$datetime'");
					
			if($account_id){
				//if need email confirm, make acc pending awaiting for verification	
				$goto_url = '/'.$lang->selected.$layout_label->label->register_confirm->url;	
				if($need_confirm){
					$activate_link = 'http://'.$_SERVER['HTTP_HOST'].'/'.$lang->selected.$layout_label->label->register_activation->url.'/'.encodeString($account_id.'_'.time(),$encryptKey);
					$fullname = $reg_fields['text']['company_name'];
					$data = array('name'=>$fullname,'url'=>'<a href="'.$activate_link.'">'.$activate_link.'</a>');
					$template_data = mailContent('register',$data);
					sendMail($reg_fields['email']['email'],$template_data['subject'],$template_data['content']);				
				}else{$goto_url .= '/done';}	
				
				//add to user log			
				adduserlog($_POST['cmd'],$account_id);
				$result = true;$msg=$layout_label->message->reg_success->icon.' '.$layout_label->message->reg_success->title;;
			}
		}		
		echo json_encode(array('result'=>$result,'msg'=>$msg,'err_fields'=>$err_fields,'url'=>$goto_url));
	}	
}	



?>