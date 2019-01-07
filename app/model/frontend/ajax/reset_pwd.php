<?php
class reset_pwd{
	public function data($data){
		global $encryptKey,$language,$usersession,$layout,$layout_label,$lang;
		$qry = new connectDb; $_POST=$data;
		$result=false;$msg='<i class="fa fa-exclamation-circle"></i> Please try again!';$err_fields=array();
		
		if(isset($_POST['reset_code']) and $_POST['reset_code']<>''){
			$valid_code = true;$valid_time = 60*web_config('email_link_valid_time');//30min			
			//get post data
			$reg_fields = array('account_newpassword'=>$_POST['account_newpassword'],'account_newpassword_confirm'=>$_POST['account_newpassword_confirm']);
			
			if(in_array('',$reg_fields)){	
				foreach($reg_fields as $key=>$value){
					if($value==''){$err_fields[]= array('name'=>$key,'msg'=>$layout_label->message->blank_data->title);}
				}	
			}else{
				//check if pwd matched
				//check password match
				if(strlen($reg_fields['account_newpassword'])>=6){
					if($reg_fields['account_newpassword'] <> $reg_fields['account_newpassword_confirm']){
						$err_fields[]=array('name'=>'account_newpassword_confirm','msg'=>$layout_label->message->confirm_pwd_failed->title);
					}
				}else{$err_fields[]=array('name'=>'account_newpassword','msg'=>$layout_label->message->pwd_length_failed->title);}	
				
				//check if valid reset_code
				$code_parts = json_decode(decodeString($_POST['reset_code'],$encryptKey));  //format: userid,email,time
				if(count($code_parts)==3){
					$reset_id = $code_parts[0];$reset_email = $code_parts[1];$reset_time = $code_parts[2];$cur_time = time();
					if(is_numeric($reset_id) and filter_var($reset_email, FILTER_VALIDATE_EMAIL) and ($cur_time-$reset_time<=$valid_time)){
						$userInfo = $qry->qry_assoc("SELECT * FROM users where id=$reset_id and email='$reset_email' and pending=0 and active=1 limit 1");
						if(!count($userInfo)){$msg=$layout_label->message->invalid_data->icon.' '.$layout_label->message->invalid_data->title;$valid_code = false;}
					}else{$msg=$layout_label->message->invalid_expired->icon.' '.$layout_label->message->invalid_expired->title;$valid_code = false;}
				}else{$msg=$layout_label->message->invalid_data->icon.' '.$layout_label->message->invalid_data->title;$valid_code = false;}
			}
			
			if(!count($err_fields) and $valid_code){
				$encrypted_pwd = encodeString($reg_fields['account_newpassword'],$encryptKey);
				$qry->update("update users set password='$encrypted_pwd' where id=$reset_id limit 1");

				adduserlog($_POST['cmd'],$userInfo[0]['id']);
				
				$login_link = 'http://'.$_SERVER['HTTP_HOST'].'/'.$lang->selected.$layout_label->label->login->url;
				$fullname=$userInfo[0]['fullname_en'];
				$data = array('name'=>$fullname,'url'=>'<a href="'.$login_link.'">'.$login_link.'</a>');
				$template_data = mailContent('reset_pwd_done',$data);
				$sendMail=sendMail($userInfo[0]['email'],$template_data['subject'],$template_data['content']);
				
				$result = $sendMail->isSent;
				$msg=$result?($layout_label->message->reset_pwddone->icon.' '.$layout_label->message->reset_pwddone->title):$sendMail->msg;
				
			}
		}else{
			$form_fields = array('reset_email'=>$_POST['reset_email'],'captcha'=>$_POST['captcha']);
			if(in_array('',$form_fields)){
				foreach($form_fields as $key=>$value){			
					if($value==''){$err_fields[]= array('name'=>$key,'msg'=>$layout_label->message->blank_data->title);}
				}	
			}else{		
				//valid email
				$keyname = 'reset_email';
				if(filter_var($form_fields[$keyname], FILTER_VALIDATE_EMAIL)){
					$userInfo = $qry->qry_assoc("SELECT * FROM users where email='".$form_fields[$keyname]."' and pending=0 and active=1 limit 1");
					if(!count($userInfo)){$err_fields[]= array('name'=>$keyname,'msg'=>$layout_label->message->email_not_exist->title);}
				}else{$err_fields[]= array('name'=>$keyname,'msg'=>$layout_label->message->invalid_email->title);}
				//check if captcha matched
				if (!is_session_started()) session_start();		
				if(isset($_SESSION['captcha'])){
					if($_SESSION['captcha']<>$form_fields['captcha']){$err_fields[]= array('name'=>'captcha','msg'=>$layout_label->message->wrong_code->title);}
				}else{$err_fields[]= array('name'=>'captcha','msg'=>$layout_label->message->wrong_code->title);}
			}
			
			if(!count($err_fields)){
				// sent pwd reset link to email
				$fullname=$userInfo[0]['fullname_en'];
				$reset_code = json_encode(array($userInfo[0]['id'],$userInfo[0]['email'],time()));
				$reset_link = 'http://'.$_SERVER['HTTP_HOST'].'/'.$lang->selected.$layout_label->label->account_resetpwd->url.'/'.encodeString($reset_code,$encryptKey);
				
				$data = array('name'=>$fullname,'url'=>'<a href="'.$reset_link.'">'.$reset_link.'</a>');
				$template_data = mailContent('reset_pwd',$data);
				$sendMail=sendMail($userInfo[0]['email'],$template_data['subject'],$template_data['content']);
				
				$result = $sendMail->isSent;
				$msg=$sendMail->msg;
			}
		}
		
		
		echo json_encode(array('result'=>$result,'msg'=>$msg,'err_fields'=>$err_fields));
	}	
}	



?>