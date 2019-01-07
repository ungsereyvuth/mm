<?php
class contact{
	public function data($data){
		global $encryptKey,$language,$usersession,$layout,$layout_label,$lang;
		$qry = new connectDb; $_POST=$data;
		$result=false;$msg=$layout_label->message->insert_failed->icon.' '.$layout_label->message->insert_failed->title;
		$err_fields=array();$datetime = date("Y-m-d H:i:s");
		
		$form_fields = array('feedback_name'=>addslashes($_POST['feedback_name']),
						'feedback_email'=>$_POST['feedback_email'],
						'feedback_type'=>$_POST['feedback_type'],
						'feedback_subject'=>addslashes($_POST['feedback_subject']),
						'feedback_des'=>addslashes($_POST['feedback_des']),
						'sent_copy'=>isset($_POST['sent_copy'])?1:0,
						'captcha'=>$_POST['captcha']);	
	
		$opt_fields = array('sent_copy');
		$temp_fields=array();
		foreach($form_fields as $key=>$value){$temp_fields[]=$key;}		
		$required_fields = array_diff($temp_fields,$opt_fields);
		$required_val = array();
		foreach($required_fields as $value){$required_val[$value]=$form_fields[$value];}		
		if(in_array('',$required_val)){	
			foreach($required_val as $key=>$value){			
				if($value==''){$err_fields[]= array('name'=>$key,'msg'=>$layout_label->message->blank_data->title);}
			}	
		}else{	
			//check valid email	
			if(!filter_var($form_fields['feedback_email'], FILTER_VALIDATE_EMAIL)){$err_fields[]= array('name'=>'feedback_email','msg'=>$layout_label->message->invalid_email->title);}
			//check if captcha matched
			if (!is_session_started()) session_start();
			if(isset($_SESSION['captcha'])){
				if($_SESSION['captcha']<>$form_fields['captcha']){$err_fields[]= array('name'=>'captcha','msg'=>$layout_label->message->wrong_code->title);}
			}else{$err_fields[]= array('name'=>'captcha','msg'=>$layout_label->message->wrong_code->title);}
		}
		
		if(!count($err_fields)){
			$insert = $qry->insert("insert into feedback set 
						name='".addslashes($form_fields['feedback_name'])."',
						email='".$form_fields['feedback_email']."',
						type_id='".$form_fields['feedback_type']."',
						subject='".addslashes($form_fields['feedback_subject'])."',
						description='".addslashes($form_fields['feedback_des'])."',
						created_date='$datetime',
						sent_copy=".$form_fields['sent_copy']);	
			if($insert){
				//add to user log
				adduserlog('contact_us');
				$result = true;$msg=$layout_label->message->contact_us_sent->icon.' '.$layout_label->message->contact_us_sent->title;
				
				/*//get feedback typ title
				$type_row = $qry->qry_assoc("SELECT *,IF('$lang->selected'='kh',title_kh,title_en) title FROM feedback_type where id=".$form_fields['feedback_type']." limit 1");
				$type_title = $type_row[0]['title'];
				
				//send to all admin users
				$admin_emails = admin_emails();
				$admin_subject = 'Contact us Message | '.$layout_label->system_title->sys->title;
				$admin_message = '<p>Dear Admin,</p>
									<p>There is a contact message on Freight Idea website. Bellow is the original copy of the message.</p>
									<p>
										<strong>Message Type:</strong> '.$type_title.'<br />
										<strong>Name:</strong> '.$form_fields['feedback_name'].'<br />
										<strong>Email:</strong> '.$form_fields['feedback_email'].'<br />
										<strong>Subject:</strong> '.$form_fields['feedback_subject'].'<br />
										<strong>Message:</strong><br />'.$form_fields['feedback_des'].'
									</p>
									<p>Thanks,</p>';
				foreach($admin_emails as $key=>$value){
					sendMail($value,$admin_subject, $admin_message,$language);
				}
				
				//check sent_copy checked, then send to commenter
				if($form_fields['sent_copy']){
					$email_subject = 'Contact us Message | Freight Idea';
					$email_message = '	<p>Dear '.$form_fields['feedback_name'].',</p>
											<p>You left a contact message on Freight Idea website. Bellow is the original copy of your message.</p><br />
											<p>
												------- Start Message -----------<br />
												<strong>Feedback Type:</strong> '.$type_title.'<br />
												<strong>Subject:</strong> '.$form_fields['feedback_subject'].'<br />
												<strong>Message:</strong>'.$form_fields['feedback_des'].'
												------- End Message -----------
											</p>
											<p>Thanks,</p>			
										';
					sendMail($form_fields['feedback_email'],$email_subject, $email_message,$language);
				}*/
			}
		}
		
		
		echo json_encode(array('result'=>$result,'msg'=>$msg,'err_fields'=>$err_fields));
	}	
}	



?>